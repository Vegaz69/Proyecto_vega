<?php namespace App\Controllers;

use App\Models\CarritoModel;
use App\Models\ProductoModel;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel;
// Importa las interfaces correctas para la firma de initController
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class CarritoController extends BaseController 
{
    protected $carritoModel;
    protected $productoModel;
    protected $ventaModel;
    protected $detalleVentaModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Llama al initController de la clase padre (BaseController)
        parent::initController($request, $response, $logger); 

        $this->carritoModel = new CarritoModel();
        $this->productoModel = new ProductoModel();
        $this->ventaModel = new VentaModel();
        $this->detalleVentaModel = new DetalleVentaModel();
        
        // Asegúrate de que 'cart_helper' esté cargado.
        helper(['form', 'url', 'session', 'cart_helper']); 
    }

    public function agregar()
    {
        $db = \Config\Database::connect();
        $request = service('request');
        $isAjax = $request->isAJAX();

        $id_usuario = session()->get('id');

        if (!$id_usuario) {
            $message = 'Debes iniciar sesión o registrarte para añadir productos al carrito.';
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount(),
                    'redirect_to_login' => true
                ]);
            } else {
                session()->setFlashdata('error_add_to_cart', $message);
                return redirect()->to(base_url('login'));
            }
        }

        $id_producto = $request->getPost('id_producto');
        $cantidad = (int) $request->getPost('cantidad');

        if (empty($id_producto) || $cantidad <= 0) {
            $message = 'Hubo un problema al añadir el producto al carrito. Por favor, asegúrate de que la cantidad sea válida.';
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount()
                ]);
            } else {
                session()->setFlashdata('error_add_to_cart', $message);
                return redirect()->back();
            }
        }

        $producto_real = $this->productoModel->find($id_producto);

        if (!$producto_real) {
            $message = 'El producto no existe.';
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount()
                ]);
            } else {
                session()->setFlashdata('error_add_to_cart', $message);
                return redirect()->back();
            }
        }

        $producto_en_carrito = $this->carritoModel
            ->where('id_producto', $id_producto)
            ->where('id_usuario', $id_usuario)
            ->first();

        $cantidad_actual_en_carrito = $producto_en_carrito ? $producto_en_carrito['cantidad'] : 0;
        $total_cantidad_deseada = $cantidad_actual_en_carrito + $cantidad;

        if ($total_cantidad_deseada > $producto_real['stock']) {
            $message = 'No se puede añadir ' . $cantidad . ' unidades más de ' . esc($producto_real['nombre']) . '. El stock disponible es ' . esc($producto_real['stock']) . ' y ya tienes ' . esc($cantidad_actual_en_carrito) . ' en el carrito. Solo puedes tener un total de ' . esc($producto_real['stock']) . ' unidades.';
            
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount(),
                    'new_stock' => $producto_real['stock']
                ]);
            } else {
                session()->setFlashdata('error_add_to_cart', $message);
                return redirect()->back();
            }
        }

        $new_stock_for_response = $producto_real['stock'];

        $db->transBegin();

        try {
            if ($producto_en_carrito) {
                $data_update = [
                    'cantidad' => $total_cantidad_deseada,
                ];
                $this->carritoModel->update($producto_en_carrito['id_carrito'], $data_update);
                $message = 'Cantidad del producto actualizada en el carrito.';
                $new_stock_for_response = $producto_real['stock'] - $total_cantidad_deseada;

            } else {
                $data = [
                    'id_producto' => $id_producto,
                    'id_usuario' => $id_usuario,
                    'nombre_producto' => $producto_real['nombre'],
                    'precio_unitario' => $producto_real['precio'],
                    'cantidad' => $cantidad,
                ];
                $this->carritoModel->insert($data);
                $message = 'Producto añadido al carrito correctamente.';
                $new_stock_for_response = $producto_real['stock'] - $cantidad;
            }

            $db->transCommit();

        } catch (\Exception $e) {
            $db->transRollback();
            $message = 'Error al procesar el carrito y el stock: ' . $e->getMessage();
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount(),
                    'new_stock' => $producto_real['stock']
                ]);
            } else {
                session()->setFlashdata('error_add_to_cart', $message);
                return redirect()->back();
            }
        }

        if ($isAjax) {
            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'cart_item_count' => getCartItemCount(),
                'new_stock' => $new_stock_for_response
            ]);
        } else {
            session()->setFlashdata('success_add_to_cart', $message);
            return redirect()->to(base_url('carrito/ver'));
        }
    }

    public function ver() {
        $id_usuario = session()->get('id');

        if (!$id_usuario) {
            session()->setFlashdata('error_cart', 'Debes iniciar sesión para ver tu carrito.');
            return redirect()->to(base_url('login'));
        }

        $productos = $this->carritoModel->getProductosCarrito($id_usuario);

        $total = 0;
        foreach ($productos as $producto) {
            $total += $producto['subtotal'];
        }

        $data = [
            'productos' => $productos,
            'total' => $total
        ];

        if (session()->getFlashdata('errors')) {
            $data['errors'] = session()->getFlashdata('errors');
        }

        return view('front/carrito/ver', $data);
    }

    public function eliminar($id_carrito_item = null) {
        $db = \Config\Database::connect();
        $request = service('request');
        $isAjax = $request->isAJAX();

        $id_usuario = session()->get('id');

        if (!$id_usuario) {
            $message = 'Debes iniciar sesión para modificar tu carrito.';
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount()
                ]);
            } else {
                session()->setFlashdata('error_cart', $message);
                return redirect()->to(base_url('login'));
            }
        }

        if (is_null($id_carrito_item)) {
            $message = 'ID del producto en el carrito no especificado para eliminar.';
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount()
                ]);
            } else {
                session()->setFlashdata('error_cart', $message);
                return redirect()->back();
            }
        }

        $item_carrito = $this->carritoModel->find($id_carrito_item);

        if (!$item_carrito || $item_carrito['id_usuario'] != $id_usuario) {
            $message = 'El producto no se encuentra en tu carrito o no tienes permiso para eliminarlo.';
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount()
                ]);
            } else {
                session()->setFlashdata('error_cart', $message);
                return redirect()->back();
            }
        }

        $db->transBegin();

        try {
            // **IMPORTANTE: Se elimina la lógica de devolver stock aquí.**
            // El stock solo se descuenta en confirmar_compra() y no se "devuelve" al eliminar del carrito.
            // Si en el futuro se implementa una reserva de stock, esta lógica deberá ser revisada.
            
            // 6. Eliminar el ítem del carrito
            $this->carritoModel->delete($id_carrito_item);

            $db->transCommit();
            $message = 'Producto eliminado del carrito correctamente.';

            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount()
                ]);
            } else {
                session()->setFlashdata('success_cart', $message);
                return redirect()->to(base_url('carrito/ver'));
            }
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error al eliminar producto del carrito: ' . $e->getMessage());
            $message = 'Ocurrió un error al eliminar el producto del carrito. Intenta de nuevo.';
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount()
                ]);
            } else {
                session()->setFlashdata('error_cart', $message);
                return redirect()->back();
            }
        }
    }


    public function actualizar() {
        $db = \Config\Database::connect();

        $id_usuario = session()->get('id');
        if (!$id_usuario) {
            session()->setFlashdata('error_cart', 'Debes iniciar sesión para realizar esta acción.');
            return redirect()->to(base_url('login'));
        }

        $id_carrito = $this->request->getPost('id_carrito');
        $cantidad_nueva = (int) $this->request->getPost('cantidad');

        if ($cantidad_nueva < 1) {
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'La cantidad debe ser al menos 1.');
        }

        $producto_en_carrito = $this->carritoModel->find($id_carrito);

        if (!$producto_en_carrito || $producto_en_carrito['id_usuario'] != $id_usuario) {
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'Producto no encontrado en el carrito o no tienes permiso.');
        }

        $producto_real = $this->productoModel->find($producto_en_carrito['id_producto']);
        if (!$producto_real) {
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'El producto original no existe.');
        }

        $cantidad_anterior_en_carrito = $producto_en_carrito['cantidad'];
        // Calcular la diferencia para saber si se está aumentando o disminuyendo
        $diferencia_cantidad = $cantidad_nueva - $cantidad_anterior_en_carrito;

        $db->transBegin();

        try {
            // Validar stock antes de actualizar
            // Si la cantidad nueva es mayor que la anterior, significa que estamos añadiendo más
            if ($cantidad_nueva > $cantidad_anterior_en_carrito) {
                // El stock disponible para añadir es el stock real menos la cantidad que ya está en el carrito
                // antes de esta actualización (es decir, la cantidad_anterior_en_carrito).
                // La cantidad total en el carrito (cantidad_nueva) no debe superar el stock real del producto.
                if ($cantidad_nueva > $producto_real['stock']) {
                    $db->transRollback();
                    return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'No hay suficiente stock disponible para la cantidad solicitada. Stock actual: ' . ($producto_real['stock'] ?? 0) . '. Cantidad máxima para este producto: ' . ($producto_real['stock'] ?? 0));
                }
            }
            // Si la cantidad nueva es menor o igual que la anterior, no necesitamos verificar stock,
            // pero sí necesitamos devolver el stock si se está disminuyendo la cantidad en el carrito.

            // Actualizar la cantidad en el carrito
            $this->carritoModel->set(['cantidad' => $cantidad_nueva])
                ->where('id_carrito', $id_carrito)
                ->update();

            // --- Lógica de devolución/deducción de stock al ACTUALIZAR la cantidad en el carrito ---
            // Si la cantidad ha cambiado, ajustamos el stock del producto real.
            // Si diferencia_cantidad es positiva, se resta del stock.
            // Si diferencia_cantidad es negativa, se suma al stock (se devuelve).
            $nuevo_stock_producto = $producto_real['stock'] - $diferencia_cantidad;

            // Asegurarse de que el stock no exceda el stock original del producto si lo estás "devolviendo"
            // Esto es crucial para evitar que el stock se infle más allá de su valor inicial.
            // Necesitarías almacenar el stock original del producto en algún lugar,
            // o asumir que producto_real['stock'] siempre es el stock total disponible.
            // Dado que el stock solo se descuenta en confirmar_compra, producto_real['stock']
            // *debería* ser el stock total.
            // Por lo tanto, si $diferencia_cantidad es negativa (se quita del carrito),
            // sumamos al stock, pero no deberíamos superar el stock original.
            // Esto es un punto complejo si no tienes un "stock_original" o "stock_inicial" en la tabla de productos.
            // Por ahora, asumiremos que producto_real['stock'] es el stock actual disponible.
            
            // Si el stock se infla, es porque $producto_real['stock'] es el stock actual descontado,
            // y al sumar $diferencia_cantidad (negativa), lo devuelve.
            // Si $producto_real['stock'] es el stock total (no descontado por carritos),
            // entonces la línea de abajo es incorrecta.
            
            // La lógica correcta es: si el stock no se descuenta al añadir, no se devuelve al quitar.
            // Por lo tanto, esta sección de actualización de stock del producto también debe ser eliminada
            // de la función `actualizar()` si el stock solo se gestiona en `confirmar_compra()`.
            // Si la cantidad cambia en el carrito, el stock del producto *no* debe cambiar.
            // Solo se actualiza la cantidad en la tabla `carrito`.

            // Comentamos la línea de actualización de stock del producto aquí también.
            // $this->productoModel->update($producto_real['id_producto'], ['stock' => $nuevo_stock_producto]);

            // Lógica para activar/desactivar producto si el stock cambia a 0 o más (basada en el stock real)
            // Esto solo tiene sentido si el stock se actualiza aquí, lo cual hemos decidido no hacer.
            // Por lo tanto, este bloque también se comenta.
            /*
            if ($nuevo_stock_producto <= 0 && $producto_real['activo'] == 1) {
                $this->productoModel->update($producto_real['id_producto'], ['activo' => 0]);
                log_message('info', 'Producto ID ' . $producto_real['id_producto'] . ' desactivado automáticamente por stock 0.');
            } elseif ($nuevo_stock_producto > 0 && $producto_real['activo'] == 0) {
                $this->productoModel->update($producto_real['id_producto'], ['activo' => 1]);
                log_message('info', 'Producto ID ' . $producto_real['id_producto'] . ' reactivado automáticamente por stock > 0.');
            }
            */

            $db->transCommit();
            return redirect()->to(base_url('carrito/ver'))->with('success_cart', 'Cantidad actualizada.');

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error al actualizar cantidad en carrito: ' . $e->getMessage());
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'Ocurrió un error al actualizar la cantidad. Intenta de nuevo.');
        }
    }

    public function confirmar_compra()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $id_usuario = session()->get('id');

            if (!$id_usuario) {
                session()->setFlashdata('error_cart', 'Debes iniciar sesión para confirmar tu pedido.');
                return redirect()->to(base_url('login'));
            }

            $rules = [
                'dni'       => 'required|numeric|min_length[7]|max_length[10]',
                'telefono'  => 'required|numeric|min_length[8]|max_length[15]',
                'direccion' => 'required|min_length[5]|max_length[255]',
            ];

            $messages = [
                'dni' => [
                    'required'   => 'El campo DNI es obligatorio.',
                    'numeric'    => 'El DNI debe contener solo números.',
                    'min_length' => 'El DNI debe tener al menos {param} dígitos.',
                    'max_length' => 'El DNI no debe exceder los {param} dígitos.'
                ],
                'telefono' => [
                    'required'   => 'El campo Teléfono es obligatorio.',
                    'numeric'    => 'El Teléfono debe contener solo números.',
                    'min_length' => 'El Teléfono debe tener al menos {param} dígitos.',
                    'max_length' => 'El Teléfono no debe exceder los {param} dígitos.'
                ],
                'direccion' => [
                    'required'   => 'El campo Dirección es obligatorio.',
                    'min_length' => 'La Dirección debe tener al menos {param} caracteres.',
                    'max_length' => 'La Dirección no debe exceder los {param} caracteres.'
                ]
            ];

            if (!$this->validate($rules, $messages)) {
                $db->transRollback();
                session()->setFlashdata('errors', $this->validator->getErrors());
                return redirect()->to(base_url('carrito/ver'))->withInput();
            }

            $dni = $this->request->getPost('dni');
            $telefono = $this->request->getPost('telefono');
            $direccion = $this->request->getPost('direccion');

            $items_carrito = $this->carritoModel->getProductosCarrito($id_usuario);
            $total_venta_calculado = 0;

            if (empty($items_carrito)) {
                session()->setFlashdata('error_cart', 'Tu carrito está vacío. No se puede confirmar un pedido sin productos.');
                return redirect()->to(base_url('carrito/ver'));
            }

            $datos_cliente_venta = [
                'nombre'    => session()->get('nombre'),
                'apellido'  => session()->get('apellido'),
                'email'     => session()->get('email'),
                'dni'       => $dni,
                'telefono'  => $telefono,
                'direccion' => $direccion,
            ];

            $data_venta = [
                'id_usuario'    => $id_usuario,
                'total_venta'   => 0,
                'estado_venta'  => 'pendiente',
                'datos_cliente' => json_encode($datos_cliente_venta),
            ];
            $id_venta = $this->ventaModel->insert($data_venta);

            if (!$id_venta) {
                session()->setFlashdata('error_cart', 'Error al crear el registro de la venta.');
                $db->transRollback();
                return redirect()->to(base_url('carrito/ver'));
            }

            foreach ($items_carrito as $item) {
                $producto_real = $this->productoModel->find($item['id_producto']);
                
                if (!$producto_real) {
                    session()->setFlashdata('error_cart', 'El producto "' . esc($item['nombre_producto']) . '" ya no está disponible. Por favor, ajusta tu carrito.');
                    $db->transRollback();
                    return redirect()->to(base_url('carrito/ver'));
                }

                if ($producto_real['stock'] < $item['cantidad']) {
                    session()->setFlashdata('error_cart', 'El producto "' . esc($item['nombre_producto']) . '" no tiene suficiente stock. Solo quedan ' . esc($producto_real['stock']) . ' unidades. Por favor, ajusta tu carrito.');
                    $db->transRollback();
                    return redirect()->to(base_url('carrito/ver'));
                }

                $nuevo_stock = $producto_real['stock'] - $item['cantidad'];
                $this->productoModel->update($item['id_producto'], [
                    'stock' => $nuevo_stock,
                    'activo' => ($nuevo_stock > 0) ? 1 : 0 
                ]);
                
                if ($nuevo_stock <= 0 && $producto_real['activo'] == 1) {
                    log_message('info', 'Producto ID ' . $item['id_producto'] . ' desactivado automáticamente por stock 0 durante la confirmación de compra.');
                }

                $data_detalle = [
                    'id_venta'      => $id_venta,
                    'id_producto'   => $item['id_producto'],
                    'nombre_producto' => $item['nombre_producto'],
                    'cantidad'      => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal'      => $item['subtotal']
                ];
                $this->detalleVentaModel->insert($data_detalle);

                $total_venta_calculado += $item['subtotal'];
            }

            $this->ventaModel->update($id_venta, ['total_venta' => $total_venta_calculado]);
            $this->carritoModel->where('id_usuario', $id_usuario)->delete();

            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                session()->setFlashdata('error_cart', 'Hubo un error al procesar tu pedido. Por favor, inténtalo de nuevo.');
                return redirect()->to(base_url('carrito/ver'));
            } else {
                session()->setFlashdata('success_order', '¡Tu pedido ha sido registrado con éxito! Te contactaremos pronto.');
                return redirect()->to(base_url('pedido/confirmacion/' . $id_venta));
            }

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error al confirmar la compra: ' . $e->getMessage());
            session()->setFlashdata('error_cart', 'Ocurrió un error inesperado al procesar tu pedido. Intenta de nuevo más tarde.');
            return redirect()->to(base_url('carrito/ver'));
        }
    }

    public function vaciar()
    {
        $db = \Config\Database::connect();

        $session = session();
        $id_usuario = $session->get('id');

        if (!$id_usuario) {
            $session->setFlashdata('error_cart', 'Debes iniciar sesión para vaciar tu carrito.');
            return redirect()->to(base_url('login'));
        }

        // Obtener los ítems del carrito para el usuario actual
        // Necesitamos saber qué items y qué cantidades se van a eliminar para potencialmente devolver stock.
        // Sin embargo, si el stock solo se descuenta en confirmar_compra, no hay stock que "devolver" aquí.
        $items_en_carrito = $this->carritoModel->where('id_usuario', $id_usuario)->findAll();

        $db->transBegin(); // Iniciar transacción para vaciar el carrito

        try {
            if (!empty($items_en_carrito)) {
                // No hay lógica para devolver stock aquí, ya que el stock solo se descuenta en confirmar_compra.
                // Si en el futuro implementas una "reserva de stock" al añadir al carrito,
                // aquí sería el lugar para "liberar" esa reserva.

                // Vaciar el carrito del usuario
                $this->carritoModel->where('id_usuario', $id_usuario)->delete();
                $db->transCommit(); // Confirmar la transacción

                $session->setFlashdata('success_cart', 'Tu carrito ha sido vaciado correctamente.');
            } else {
                $db->transRollback(); // No hay nada que hacer, pero para mantener el patrón de transacción
                $session->setFlashdata('error_cart', 'Tu carrito ya está vacío.');
            }
        } catch (\Exception $e) {
            $db->transRollback(); // Revertir la transacción en caso de error
            log_message('error', 'Error al vaciar el carrito: ' . $e->getMessage());
            $session->setFlashdata('error_cart', 'Ocurrió un error al vaciar el carrito. Intenta de nuevo.');
        }

        return redirect()->to(base_url('carrito/ver'));
    }
}