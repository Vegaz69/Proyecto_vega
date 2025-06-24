<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel;
use App\Models\UserModel;

class VentasController extends BaseController // Asegúrate de extender tu BaseController si lo usas
{
    protected $ventaModel;
    protected $detalleVentaModel;
    protected $userModel;

    public function __construct()
    {
        $this->ventaModel = new VentaModel();
        $this->detalleVentaModel = new DetalleVentaModel();
        $this->userModel = new UserModel();
    }

    // Método para que el administrador vea todas las ventas
    public function listar()
    {
        $data['titulo'] = 'Gestión de Ventas'; // Título para el layout

        // 1. Obtener los filtros de la URL (si existen)
        $filtroNombre = $this->request->getVar('nombre_cliente');
        $filtroDni = $this->request->getVar('dni_cliente');
        $filtroFecha = $this->request->getVar('fecha_venta');

        // Iniciar la consulta con el modelo de ventas
        $ventasQuery = $this->ventaModel
                              // Seleccionamos las columnas de ventas y las de usuarios
                              ->select('ventas.*, usuarios.nombre as nombre_cliente, usuarios.apellido as apellido_cliente')
                              // Nos unimos con la tabla 'usuarios'
                              ->join('usuarios', 'usuarios.id_usuario = ventas.id_usuario', 'left');

        // 2. Aplicar filtros condicionalmente

        // Filtro por nombre de cliente
        if (!empty($filtroNombre)) {
            // Buscamos en nombre O apellido
            $ventasQuery->groupStart()
                        ->like('usuarios.nombre', $filtroNombre, 'both') // 'both' para buscar en cualquier parte del string
                        ->orLike('usuarios.apellido', $filtroNombre, 'both')
                        ->groupEnd();
        }

        // Filtro por DNI (el DNI está en el campo JSON 'datos_cliente')
        if (!empty($filtroDni)) {
            // Para filtrar por un campo JSON, CodeIgniter 4 soporta JSON_EXTRACT para MySQL/MariaDB
            // Asegúrate de que tu base de datos y versión de MySQL/MariaDB soporten JSON_EXTRACT
            // Si usas PostgreSQL, deberías usar 'datos_cliente->>'nombre_del_campo_json'
            $ventasQuery->where("JSON_UNQUOTE(JSON_EXTRACT(ventas.datos_cliente, '$.dni')) LIKE '%" . $filtroDni . "%'");
            // Nota: JSON_UNQUOTE(JSON_EXTRACT(...)) es importante para remover las comillas del string extraído.
        }

        // Filtro por fecha de venta
        if (!empty($filtroFecha)) {
            // Asume que 'fecha_venta' es de tipo DATE, DATETIME o TIMESTAMP en tu DB.
            // DATE(fecha_venta) convierte a formato 'YYYY-MM-DD' para comparar solo la fecha.
            $ventasQuery->where('DATE(ventas.fecha_venta)', $filtroFecha);
        }

        // Ordenamiento por defecto (siempre al final para que los filtros se apliquen primero)
        $ventas = $ventasQuery->orderBy('ventas.fecha_venta', 'DESC')
                              ->findAll();

        // Para cada venta, obtener sus detalles y parsear los datos del cliente
        $ventas_completas = [];
        foreach ($ventas as $venta) {
            // Parsear el JSON del campo 'datos_cliente'
            $venta['datos_cliente_parsed'] = json_decode($venta['datos_cliente'], true);

            // Asegurarse de que el email_cliente sea del JSON parseado si existe, o N/A
            $venta['email_cliente'] = $venta['datos_cliente_parsed']['email'] ?? 'N/A';

            $detalle_venta = $this->detalleVentaModel->where('id_venta', $venta['id_venta'])->findAll();
            $venta['detalles'] = $detalle_venta;
            $ventas_completas[] = $venta;
        }

        $data['ventas'] = $ventas_completas;

        // 3. Pasar los filtros actuales a la vista para que los campos mantengan sus valores
        $data['filtro_nombre'] = $filtroNombre;
        $data['filtro_dni'] = $filtroDni;
        $data['filtro_fecha'] = $filtroFecha;

        // Asegurando que la ruta de la vista sea correcta
        return view('admin/ventas/ventas', $data);
    }

    // Aquí podrías añadir otros métodos para gestionar ventas (ver detalle, cambiar estado, etc.)
}