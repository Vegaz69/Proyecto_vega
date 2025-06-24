<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel; // <--- Asegúrate que esta línea esté presente
use App\Models\UserModel; // <--- Añadir si planeas usar UserModel en este controlador

class PedidoController extends BaseController
{
    protected $ventaModel;
    protected $detalleVentaModel; // <--- ¡Esta línea faltaba!
    protected $userModel; // <--- Declarar si vas a usarlo, como para obtener datos del usuario

    public function __construct()
    {
        $this->ventaModel = new VentaModel();
        $this->detalleVentaModel = new DetalleVentaModel(); // <--- ¡Esta línea faltaba!
        $this->userModel = new UserModel(); // <--- Instanciar si vas a usarlo
    }

    public function confirmacion($id_venta = null)
    {
        if ($id_venta === null) {
            return redirect()->to(base_url())->with('error', 'No se encontró información del pedido.');
        }

        $data['id_venta'] = $id_venta;

        return view('front/carrito/confirmacion', $data);
    }

    public function misPedidos()
    {
        $id_usuario = session()->get('id'); // Obtener el ID del usuario logueado

        if (!$id_usuario) {
            session()->setFlashdata('error', 'Debes iniciar sesión para ver tus pedidos.');
            return redirect()->to(base_url('login'));
        }

        $ventas = $this->ventaModel->where('id_usuario', $id_usuario)
                                   ->orderBy('fecha_venta', 'DESC')
                                   ->findAll();

        $pedidos_completos = [];
        foreach ($ventas as $venta) {
            // Aquí es donde ocurría el error, ahora $this->detalleVentaModel ya está instanciado
            $detalle_venta = $this->detalleVentaModel->where('id_venta', $venta['id_venta'])->findAll();
            $venta['detalles'] = $detalle_venta;
            $pedidos_completos[] = $venta;
        }

        $data['pedidos'] = $pedidos_completos;

        return view('front/carrito/mis_pedidos', $data);  
    }
}