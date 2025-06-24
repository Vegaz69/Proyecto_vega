<?php

namespace App\Controllers; // Asegúrate de que el namespace sea Admin si está en una subcarpeta

use App\Controllers\BaseController;
use App\Models\MensajeModel;
use App\Models\UserModel; // Asegúrate de que este sea el nombre correcto de tu modelo de usuarios

class AdminMensajesController extends BaseController
{
    protected $mensajeModel;
    protected $userModel;

    public function __construct()
    {
        $this->mensajeModel = new MensajeModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Obtener los filtros de la URL (si existen)
        $filtroTipo = $this->request->getVar('tipo_mensaje');
        $filtroEstado = $this->request->getVar('estado_mensaje');
        $filtroFecha = $this->request->getVar('fecha_mensaje');

        // Inicializar la consulta con el modelo
        $mensajesQuery = $this->mensajeModel;

        // Aplicar filtros condicionalmente
        if (!empty($filtroTipo)) {
            $mensajesQuery->where('tipo_mensaje', $filtroTipo);
        }

        if (!empty($filtroEstado)) {
            // Asumiendo que 'leido' es un campo booleano (0 para no leído, 1 para leído)
            $mensajesQuery->where('leido', ($filtroEstado == 'leido' ? 1 : 0));
        }

        if (!empty($filtroFecha)) {
            // Asume que 'fecha_envio' es de tipo DATETIME o TIMESTAMP en tu DB.
            // DATE(fecha_envio) convierte a formato 'YYYY-MM-DD' para comparar solo la fecha.
            $mensajesQuery->where('DATE(fecha_envio)', $filtroFecha);
        }

        // Ordenamiento por defecto (puedes ajustar esto si quieres un ordenamiento por columna clicable)
        $mensajesQuery->orderBy('fecha_envio', 'DESC');

        // Obtener todos los mensajes después de aplicar los filtros y ordenamiento
        $mensajes = $mensajesQuery->findAll();

        // Procesar los mensajes para añadir información de remitente y formato de fecha
        foreach ($mensajes as &$mensaje) {
            if (isset($mensaje['tipo_mensaje']) && $mensaje['tipo_mensaje'] === 'cliente') {
                $usuario = $this->userModel->find($mensaje['id_usuario']);
                $mensaje['nombre_remitente'] = $usuario ? $usuario['nombre'] . ' ' . $usuario['apellido'] : 'Usuario Desconocido';
                $mensaje['email_remitente'] = $usuario ? $usuario['email'] : 'N/A';
                $mensaje['telefono_remitente'] = $usuario ? ($usuario['telefono'] ?? 'N/A') : 'N/A';
            } else {
                $mensaje['nombre_remitente'] = $mensaje['nombre_completo'] ?? 'Anónimo';
                $mensaje['email_remitente'] = $mensaje['email'] ?? 'N/A';
                $mensaje['telefono_remitente'] = $mensaje['telefono'] ?? 'N/A';
            }
            // Asegurarse de que fecha_envio exista antes de formatear
            $mensaje['fecha_envio_formato'] = date('d/m/Y H:i', strtotime($mensaje['fecha_envio'] ?? date('Y-m-d H:i:s')));
        }
        unset($mensaje); // Romper la referencia del último elemento

        $data = [
            'title' => 'Gestión de Mensajes',
            'mensajes' => $mensajes,
            // Pasamos los valores actuales de los filtros a la vista para que se mantengan en los inputs
            'filtro_tipo' => $filtroTipo,
            'filtro_estado' => $filtroEstado,
            'filtro_fecha' => $filtroFecha
        ];

        return view('admin/mensajes/listado_mensajes', $data);
    }

    public function marcarLeido($id = null)
    {
        if ($id === null) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID de mensaje no proporcionado.'
            ])->setStatusCode(400); // Bad Request
        }

        $mensaje = $this->mensajeModel->find($id);

        if (!$mensaje) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Mensaje no encontrado.'
            ])->setStatusCode(404); // Not Found
        }

        if ($mensaje['leido'] == 1) {
            return $this->response->setJSON([
                'status' => 'info',
                'message' => 'El mensaje ya estaba marcado como leído.'
            ]);
        }

        if ($this->mensajeModel->update($id, ['leido' => 1])) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Mensaje marcado como leído correctamente.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No se pudo marcar el mensaje como leído.'
            ])->setStatusCode(500); // Internal Server Error
        }
    }

    public function eliminarMensaje($id = null)
    {
        if ($id === null) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID de mensaje no proporcionado.'
            ])->setStatusCode(400); // Bad Request
        }

        $mensaje = $this->mensajeModel->find($id);
        if (!$mensaje) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Mensaje no encontrado.'
            ])->setStatusCode(404); // Not Found
        }

        if ($this->mensajeModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Mensaje eliminado correctamente.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No se pudo eliminar el mensaje.'
            ])->setStatusCode(500); // Internal Server Error
        }
    }
}