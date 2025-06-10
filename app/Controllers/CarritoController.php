<?php namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\VentaModel;       // <--- AGREGADO
use App\Models\DetalleVentaModel; // <--- AGREGADO
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class CarritoController extends BaseController
{
    use ResponseTrait;
    protected $productoModel;
    protected $ventaModel;        // <--- AGREGADO
    protected $detalleVentaModel; // <--- AGREGADO

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->ventaModel = new VentaModel();         // <--- AGREGADO
        $this->detalleVentaModel = new DetalleVentaModel(); // <--- AGREGADO
        helper(['form', 'url']);
    }

    public function agregar()
    {
        $requestMethod = $this->request->getMethod();
        if (strtolower($requestMethod) !== 'post') {
            return redirect()->back()->with('error_add_to_cart', 'Método de solicitud no permitido.');
        }

        $id_producto = $this->request->getPost('id_producto');
        $cantidad = $this->request->getPost('cantidad');
        $precio_unitario = $this->request->getPost('precio_unitario');
        $nombre_producto = $this->request->getPost('nombre_producto');

        if (empty($id_producto) || empty($cantidad) || !is_numeric($cantidad) || $cantidad <= 0) {
            return redirect()->back()->with('error_add_to_cart', 'Datos de producto o cantidad inválidos.');
        }

        $producto = $this->productoModel->find($id_producto);

        if (!$producto || $producto['activo'] == 0) {
            return redirect()->back()->with('error_add_to_cart', 'Producto no encontrado o inactivo.');
        }

        if ($cantidad > $producto['stock']) {
            return redirect()->back()->with('error_add_to_cart', 'Cantidad solicitada excede el stock disponible (' . $producto['stock'] . ' unidades).');
        }

        $carrito = session()->get('carrito') ?? [];

        if (isset($carrito[$id_producto])) {
            $nuevaCantidad = $carrito[$id_producto]['cantidad'] + $cantidad;
            if ($nuevaCantidad > $producto['stock']) {
                return redirect()->back()->with('error_add_to_cart', 'No puedes añadir más, el stock total para este producto es ' . $producto['stock'] . '.');
            }
            $carrito[$id_producto]['cantidad'] = $nuevaCantidad;
        } else {
            $carrito[$id_producto] = [
                'id_producto' => $id_producto,
                'nombre' => $nombre_producto,
                'precio' => $precio_unitario,
                'cantidad' => $cantidad,
                'imagen' => $producto['imagen']
            ];
        }

        session()->set('carrito', $carrito);

        return redirect()->back()->with('success_add_to_cart', 'Producto "' . esc($nombre_producto) . '" añadido al carrito.');
    }


    public function verCarrito()
    {
        $carrito = session()->get('carrito') ?? [];

        foreach ($carrito as $id_producto => &$item) {
            $productoDB = $this->productoModel->find($id_producto);
            if ($productoDB) {
                $item['stock_actual'] = $productoDB['stock'];
                $item['activo'] = $productoDB['activo'];
            } else {
                $item['stock_actual'] = 0;
                $item['activo'] = 0;
            }
        }
        unset($item);

        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }

        $data = [
            'title' => 'Tu Carrito de Compras',
            'carrito' => $carrito,
            'subtotal' => $subtotal,
            'total' => $subtotal
        ];

        return view('carrito/ver_carrito', $data);
    }

    public function procesarCompra()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'Método de solicitud no permitido para la compra.');
        }

        $carrito = session()->get('carrito') ?? [];

        if (empty($carrito)) {
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'Tu carrito está vacío. No se puede realizar la compra.');
        }

        $total_compra = 0;
        $productos_actualizados = [];
        $errores_stock = [];

        // ***** AQUÍ ESTÁ LA LÍNEA QUE MOSTRÓ NULL *****
        // La comentamos o borramos después de la prueba
        // var_dump(\Config\Services::db());
        // die();

        \Config\Services::db()->transBegin(); // <--- Esta es la línea 133

        try {
            foreach ($carrito as $id_producto => $item) {
                $productoDB = $this->productoModel->find($id_producto);

                if (!$productoDB || $productoDB['activo'] == 0) {
                    $errores_stock[] = 'El producto "' . esc($item['nombre']) . '" ya no está disponible o está inactivo.';
                    continue;
                }

                if ($item['cantidad'] > $productoDB['stock']) {
                    $errores_stock[] = 'Stock insuficiente para el producto "' . esc($item['nombre']) . '". Disponible: ' . $productoDB['stock'] . ', solicitado: ' . $item['cantidad'] . '.';
                    continue;
                }

                $item_subtotal = $item['precio'] * $item['cantidad'];
                $total_compra += $item_subtotal;

                $nuevo_stock = $productoDB['stock'] - $item['cantidad'];
                $productos_actualizados[] = [
                    'id_producto' => $id_producto,
                    'stock' => $nuevo_stock,
                    'activo' => ($nuevo_stock > 0) ? 1 : 0
                ];

                $detalle_items[] = [
                    'id_producto' => $id_producto,
                    'nombre_producto' => $item['nombre'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item_subtotal
                ];
            }

            if (!empty($errores_stock)) {
                \Config\Services::db()->transRollback();
                return redirect()->to(base_url('carrito/ver'))->with('error_cart', implode('<br>', $errores_stock));
            }

            if (empty($detalle_items)) {
                \Config\Services::db()->transRollback();
                return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'No hay productos válidos en el carrito para procesar la compra.');
            }

            // 1. Registrar la Venta Principal
            $venta_data = [
                'id_usuario' => session()->get('id_usuario') ?? null,
                'total_venta' => $total_compra,
                'estado_venta' => 'completada'
            ];
            $id_venta = $this->ventaModel->insert($venta_data, true);

            if (!$id_venta) {
                throw new \Exception("Error al registrar la venta principal.");
            }

            // 2. Registrar el Detalle de la Venta
            foreach ($detalle_items as &$detalle) {
                $detalle['id_venta'] = $id_venta;
            }
            if (!$this->detalleVentaModel->insertBatch($detalle_items)) {
                throw new \Exception("Error al registrar el detalle de la venta.");
            }

            // 3. Actualizar el Stock de los Productos y desactivar si es 0
            if (!$this->productoModel->updateBatch($productos_actualizados, 'id_producto')) {
                throw new \Exception("Error al actualizar el stock de los productos.");
            }

            \Config\Services::db()->transCommit();

            session()->remove('carrito');

            return redirect()->to(base_url('carrito/ver'))->with('success_cart', '¡Compra realizada con éxito! Tus productos han sido procesados.');

        } catch (\Exception $e) {
            \Config\Services::db()->transRollback();
            log_message('error', 'Error al procesar la compra: ' . $e->getMessage());
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'Ocurrió un error al procesar tu compra. Por favor, intenta de nuevo.');
        }
    }

    public function eliminarProducto()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'Método de solicitud no permitido.');
        }

        $id_producto = $this->request->getPost('id_producto');

        if (empty($id_producto)) {
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'ID de producto no proporcionado para eliminar.');
        }

        $carrito = session()->get('carrito') ?? [];

        if (isset($carrito[$id_producto])) {
            unset($carrito[$id_producto]);
            session()->set('carrito', $carrito);
            return redirect()->to(base_url('carrito/ver'))->with('success_cart', 'Producto eliminado del carrito.');
        } else {
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'El producto no se encontró en el carrito.');
        }
    }

    public function actualizarCantidad()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'Método de solicitud no permitido.');
        }

        $id_producto = $this->request->getPost('id_producto');
        $cantidad_nueva = $this->request->getPost('cantidad');

        if (empty($id_producto) || !is_numeric($cantidad_nueva) || $cantidad_nueva < 1) {
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'Datos de producto o cantidad inválidos para actualizar.');
        }

        $carrito = session()->get('carrito') ?? [];

        if (isset($carrito[$id_producto])) {
            $productoDB = $this->productoModel->find($id_producto);

            if (!$productoDB || $productoDB['activo'] == 0) {
                unset($carrito[$id_producto]);
                session()->set('carrito', $carrito);
                return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'El producto ya no está disponible o ha sido eliminado.');
            }

            if ($cantidad_nueva > $productoDB['stock']) {
                $cantidad_nueva = $productoDB['stock'];
                $carrito[$id_producto]['cantidad'] = $cantidad_nueva;
                session()->set('carrito', $carrito);
                return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'La cantidad solicitada excede el stock disponible. Cantidad ajustada a ' . $cantidad_nueva . '.');
            }

            $carrito[$id_producto]['cantidad'] = $cantidad_nueva;
            session()->set('carrito', $carrito);

            return redirect()->to(base_url('carrito/ver'))->with('success_cart', 'Cantidad del producto "' . esc($carrito[$id_producto]['nombre']) . '" actualizada.');

        } else {
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'El producto no se encontró en el carrito para actualizar.');
        }
    }
}