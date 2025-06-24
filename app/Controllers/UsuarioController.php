<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UsuarioController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UserModel(); 
        helper(['form', 'url']);
    }

    public function listar()
{   

    $busqueda = $this->request->getGet('busqueda');
    $orden = $this->request->getGet('orden') ?? 'asc';
    $orden_apellido = $this->request->getGet('orden_apellido') ?? 'asc'; 

    $orden = ($orden === 'desc') ? 'desc' : 'asc';
    $orden_apellido = ($orden_apellido === 'desc') ? 'desc' : 'asc';

    $query = $this->usuarioModel;

    if (!empty($busqueda)) {
        $query = $query->groupStart()
            ->like('nombre', $busqueda)
            ->orLike('apellido', $busqueda)
            ->orLike('email', $busqueda)
            ->groupEnd();
    }

    $data['usuarios'] = $query->where('activo', 1)->orderBy('apellido', $orden_apellido)->findAll();

    $queryInactivos = $this->usuarioModel;

    if (!empty($busqueda)) {
        $queryInactivos = $queryInactivos->groupStart()
            ->like('nombre', $busqueda)
            ->orLike('apellido', $busqueda)
            ->orLike('email', $busqueda)
            ->groupEnd();
    }

    $data['usuariosInactivos'] = $queryInactivos->where('activo', 0)->orderBy('apellido', $orden_apellido)->findAll();

    // Valores para la vista
    $data['busqueda'] = $busqueda;
    $data['orden'] = $orden;
    $data['orden_apellido'] = $orden_apellido; // Pasar el nuevo orden a la vista

    return view('admin/usuarios/listar', $data);
}



    public function editar($id_usuario = null)
    {
        if ($id_usuario === null) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'ID de usuario no proporcionado.');
        }

        $usuario = $this->usuarioModel->find($id_usuario);

        if (!$usuario) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'El usuario no existe.');
        }

        $data['usuario'] = $usuario;
        $data['roles_posibles'] = ['admin', 'cliente'];

        return view('admin/usuarios/editar', $data); // ✅ Vista dentro de la carpeta admin
    }

    public function guardar()
    {
        $id_usuario = $this->request->getPost('id_usuario');

        // Obtener las reglas de validación del modelo
        $rules = $this->usuarioModel->getValidationRules();
        $messages = $this->usuarioModel->getValidationMessages();

        // Ajustar la regla de contraseña para edición (permit_empty si no se cambia)
        // y para email (unique, ignorando el ID actual si se edita)
        if (!empty($id_usuario)) {
            $rules['password'] = 'permit_empty|min_length[8]';
            // La regla is_unique en el modelo ya usa {id_usuario} para ignorar el ID actual
            // por lo que no es necesario modificar la regla de email aquí si el modelo ya lo hace
        } else {
            // Para creación, la contraseña es obligatoria
            $rules['password'] = 'required|min_length[8]';
        }

        // Depuración (estos mensajes irán a writable/logs/)
        log_message('debug', 'Datos POST recibidos en guardar(): ' . json_encode($this->request->getPost()));
        log_message('debug', 'Reglas de validación finales aplicadas: ' . json_encode($rules));

        // Realizar la validación
        if (!$this->validate($rules, $messages)) {
            log_message('debug', 'Errores de validación: ' . json_encode($this->validator->getErrors()));
            // Si la validación falla, redirigir al formulario con los errores
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Preparar los datos para guardar
        $data = [
            'nombre'   => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'), // ¡Campo APELIDO añadido aquí!
            'email'    => $this->request->getPost('email'),
            'rol'      => $this->request->getPost('rol'),
            'activo'   => $this->request->getPost('activo') ?? 0, // Si no se marca, será 0
        ];

        // Hashear la contraseña si se proporciona
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $result = false; // Para almacenar el resultado de la operación (true/false)
        $message = '';
        $redirectUrl = base_url('admin/usuarios');

        try {
            if ($id_usuario) {
                // Actualizar usuario existente
                $result = $this->usuarioModel->update($id_usuario, $data);
                $message = 'Usuario actualizado correctamente.';
            } else {
                // Insertar nuevo usuario
                $result = $this->usuarioModel->insert($data);
                $message = 'Usuario creado correctamente.';
            }
            log_message('debug', 'Resultado de la operación de base de datos (insert/update): ' . ($result ? 'Éxito' : 'Fallo'));

        } catch (\ReflectionException $e) { // Captura excepciones que puedan ocurrir en el modelo
            log_message('error', 'Excepción al guardar/actualizar usuario: ' . $e->getMessage());
            $result = false; // Forzar fallo
            $message = 'Error interno al procesar la solicitud: ' . $e->getMessage();
        }

        // Verificar si la operación fue exitosa
        if ($result) {
            return redirect()->to($redirectUrl)->with('success', $message);
        } else {
            // Si $result es falso, la operación de DB falló
            $modelErrors = $this->usuarioModel->errors(); // Obtener errores del modelo
            $errorMessage = 'No se pudo completar la operación.';

            if (!empty($modelErrors)) {
                // Si el modelo tiene errores registrados, incluirlos
                $errorMessage .= ' Detalles: ' . implode(', ', $modelErrors);
            } else {
                // Si no hay errores del modelo, puede ser un problema más genérico
                $errorMessage .= ' Posible error interno o de base de datos desconocido.';
            }
            log_message('error', 'Fallo al guardar/actualizar usuario: ' . $errorMessage);
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }
    }

    public function desactivar($id_usuario = null)
    {
        if ($id_usuario === null || !$this->usuarioModel->find($id_usuario)) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'Usuario no válido.');
        }

        $this->usuarioModel->update($id_usuario, ['activo' => 0]);
        return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario desactivado correctamente.');
    }

    public function activar($id_usuario = null)
    {
        if ($id_usuario === null || !$this->usuarioModel->find($id_usuario)) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'Usuario no válido.');
        }

        $this->usuarioModel->update($id_usuario, ['activo' => 1]);
        return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario activado correctamente.');
    }

    public function crear()
{
    $data['roles_posibles'] = ['admin', 'cliente']; 
    return view('admin/usuarios/crear', $data);
}

}
