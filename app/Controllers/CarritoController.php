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
        // Obtener la instancia de la base de datos explícitamente
        $db = \Config\Database::connect();

        $request = service('request');
        $isAjax = $request->isAJAX(); // Detectar si la solicitud es AJAX

        $id_usuario = session()->get('id');

        // --- Manejo de la sesión de usuario ---
        if (!$id_usuario) {
            $message = 'Debes iniciar sesión o registrarte para añadir productos al carrito.';
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount(), // Usamos la función del helper
                    'redirect_to_login' => true // Añadimos una bandera para que el JS sepa que debe redirigir o mostrar opciones
                ]);
            } else {
                session()->setFlashdata('error_add_to_cart', $message);
                return redirect()->to(base_url('login'));
            }
        }

        $id_producto = $request->getPost('id_producto');
        $cantidad = (int) $request->getPost('cantidad');

        // --- Validación de datos de entrada ---
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

        // --- Validación del producto existente ---
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

        // --- Validación de stock inicial ---
        if ($producto_real['stock'] < $cantidad) {
            $message = 'No hay suficiente stock disponible para la cantidad solicitada de ' . esc($producto_real['nombre']) . '. Stock actual: ' . esc($producto_real['stock']) . '.';
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount(),
                    'new_stock' => $producto_real['stock'] // Devolver stock actual para actualizar en la vista
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

        $new_stock_for_response = $producto_real['stock']; // Variable para almacenar el nuevo stock visible

        // Iniciar una transacción de base de datos para asegurar la atomicidad
        $db->transBegin(); // Usando la variable $db local

        try {
            // --- Lógica para actualizar o insertar en el carrito y actualizar stock ---
            if ($producto_en_carrito) {
                $nueva_cantidad_en_carrito = $producto_en_carrito['cantidad'] + $cantidad;

                // Validación de stock para la nueva cantidad total en el carrito
                // Asegurarse de que el stock real del producto es suficiente para la nueva cantidad total en el carrito
                // considerando lo que ya está en el carrito.
                // El stock disponible para añadir es el stock_real menos lo que ya está en el carrito.
                $stock_disponible_para_nueva_adicion = $producto_real['stock'] - $producto_en_carrito['cantidad'];

                if ($stock_disponible_para_nueva_adicion < $cantidad) {
                    $message = 'No se puede añadir ' . $cantidad . ' unidades más de ' . esc($producto_real['nombre']) . '. El stock disponible es ' . esc($producto_real['stock']) . ' y ya tienes ' . esc($producto_en_carrito['cantidad']) . ' en el carrito.';
                    $db->transRollback(); // Usando la variable $db local
                    if ($isAjax) {
                        return $this->response->setJSON([
                            'success' => false,
                            'message' => $message,
                            'cart_item_count' => getCartItemCount(),
                            'new_stock' => $producto_real['stock'] // Devolver el stock actual sin cambios
                        ]);
                    } else {
                        session()->setFlashdata('error_add_to_cart', $message);
                        return redirect()->back();
                    }
                }

                $data_update = [
                    'cantidad' => $nueva_cantidad_en_carrito,
                ];
                $this->carritoModel->update($producto_en_carrito['id_carrito'], $data_update);
                $message = 'Cantidad del producto actualizada en el carrito.';

                // Deducir la cantidad *recién añadida* del stock real del producto
                $this->productoModel->update($id_producto, ['stock' => $producto_real['stock'] - $cantidad]);
                $new_stock_for_response = $producto_real['stock'] - $cantidad;

            } else {
                // Si el producto no está en el carrito, insertarlo
                $data = [
                    'id_producto' => $id_producto,
                    'id_usuario' => $id_usuario,
                    'nombre_producto' => $producto_real['nombre'],
                    'precio_unitario' => $producto_real['precio'],
                    'cantidad' => $cantidad,
                ];
                $this->carritoModel->insert($data);
                $message = 'Producto añadido al carrito correctamente.';

                // Deducir la cantidad añadida del stock real del producto
                $this->productoModel->update($id_producto, ['stock' => $producto_real['stock'] - $cantidad]);
                $new_stock_for_response = $producto_real['stock'] - $cantidad;
            }

            $db->transCommit(); // Confirmar la transacción si todo fue bien

        } catch (\Exception $e) {
            $db->transRollback(); // Revertir la transacción si algo falla
            $message = 'Error al procesar el carrito y el stock: ' . $e->getMessage();
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount(),
                    'new_stock' => $producto_real['stock'] // Devolver stock actual sin cambios
                ]);
            } else {
                session()->setFlashdata('error_add_to_cart', $message);
                return redirect()->back();
            }
        }

        // --- Respuesta basada en el tipo de solicitud (AJAX vs. HTTP normal) ---
        if ($isAjax) {
            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'cart_item_count' => getCartItemCount(), // Usamos la función del helper
                'new_stock' => $new_stock_for_response // Devuelve el nuevo stock
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

        // Si hay errores de validación de los datos del cliente, se envían a la vista
        if (session()->getFlashdata('errors')) {
            $data['errors'] = session()->getFlashdata('errors');
        }

        return view('front/carrito/ver', $data);
    }

    public function eliminar($id_carrito_item = null) {
        // Obtener la instancia de la base de datos explícitamente
        $db = \Config\Database::connect();

        $request = service('request');
        $isAjax = $request->isAJAX(); // Detectar si la solicitud es AJAX

        $id_usuario = session()->get('id');

        // 1. Validar que el usuario esté logueado
        if (!$id_usuario) {
            $message = 'Debes iniciar sesión para modificar tu carrito.';
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount() // Devolver contador incluso en error
                ]);
            } else {
                session()->setFlashdata('error_cart', $message);
                return redirect()->to(base_url('login'));
            }
        }

        // 2. Validar que se ha recibido un ID de ítem de carrito
        // Tu ruta 'carrito/eliminar/(:num)' ya asegura que $id_carrito_item tendrá un valor.
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

        // 3. Buscar el ítem del carrito
        $item_carrito = $this->carritoModel->find($id_carrito_item);

        // 4. Validar que el ítem existe y pertenece al usuario logueado
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

        // Iniciar una transacción para asegurar que stock y carrito se actualicen juntos
        $db->transBegin(); // Usando la variable $db local

        try {
            // 5. Devolver el stock al producto
            $producto = $this->productoModel->find($item_carrito['id_producto']);
            if ($producto) {
                $nuevo_stock = $producto['stock'] + $item_carrito['cantidad'];
                $this->productoModel->update($producto['id_producto'], ['stock' => $nuevo_stock]);
                
                // Opcional: Si tienes un campo 'activo' y se desactivó por stock 0, podrías reactivarlo si el nuevo stock es > 0
                if ($producto['activo'] == 0 && $nuevo_stock > 0) {
                    $this->productoModel->update($producto['id_producto'], ['activo' => 1]);
                    log_message('info', 'Producto ID ' . $item_carrito['id_producto'] . ' reactivado automáticamente por devolución de stock.');
                }
            } else {
                log_message('error', 'Producto con ID ' . $item_carrito['id_producto'] . ' no encontrado al eliminar del carrito. No se pudo restaurar el stock.');
            }

            // 6. Eliminar el ítem del carrito
            $this->carritoModel->delete($id_carrito_item);

            $db->transCommit(); // Usando la variable $db local
            $message = 'Producto eliminado del carrito correctamente.';

            // 7. Respuesta (AJAX vs. Redirección)
            if ($isAjax) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $message,
                    'cart_item_count' => getCartItemCount() // Actualizar el contador del carrito
                ]);
            } else {
                session()->setFlashdata('success_cart', $message);
                return redirect()->to(base_url('carrito/ver'));
            }
        } catch (\Exception $e) {
            $db->transRollback(); // Usando la variable $db local
            log_message('error', 'Error al eliminar producto del carrito y devolver stock: ' . $e->getMessage());
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
        // Obtener la instancia de la base de datos explícitamente
        $db = \Config\Database::connect();

        $id_usuario = session()->get('id');
        if (!$id_usuario) {
            session()->setFlashdata('error_cart', 'Debes iniciar sesión para realizar esta acción.');
            return redirect()->to(base_url('login'));
        }

        $id_carrito = $this->request->getPost('id_carrito');
        $cantidad_nueva = (int) $this->request->getPost('cantidad'); // Renombrado para claridad

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
        $diferencia_cantidad = $cantidad_nueva - $cantidad_anterior_en_carrito;

        // Iniciar una transacción para asegurar la atomicidad
        $db->transBegin(); // Usando la variable $db local

        try {
            // Validar stock antes de actualizar
            if ($diferencia_cantidad > 0) { // Si la cantidad aumenta, necesitamos más stock
                if ($producto_real['stock'] < $diferencia_cantidad) {
                    $db->transRollback(); // Usando la variable $db local
                    return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'No hay suficiente stock disponible para aumentar la cantidad. Stock actual: ' . ($producto_real['stock'] ?? 0));
                }
            }

            // Actualizar la cantidad en el carrito
            $this->carritoModel->set(['cantidad' => $cantidad_nueva])
                ->where('id_carrito', $id_carrito)
                ->update();

            // Actualizar el stock del producto
            $nuevo_stock_producto = $producto_real['stock'] - $diferencia_cantidad;
            $this->productoModel->update($producto_real['id_producto'], ['stock' => $nuevo_stock_producto]);

            // Lógica para activar/desactivar producto si el stock cambia a 0 o más
            if ($nuevo_stock_producto <= 0 && $producto_real['activo'] == 1) {
                $this->productoModel->update($producto_real['id_producto'], ['activo' => 0]);
                log_message('info', 'Producto ID ' . $producto_real['id_producto'] . ' desactivado automáticamente por stock 0.');
            } elseif ($nuevo_stock_producto > 0 && $producto_real['activo'] == 0) {
                $this->productoModel->update($producto_real['id_producto'], ['activo' => 1]);
                log_message('info', 'Producto ID ' . $producto_real['id_producto'] . ' reactivado automáticamente por stock > 0.');
            }


            $db->transCommit(); // Usando la variable $db local
            return redirect()->to(base_url('carrito/ver'))->with('success_cart', 'Cantidad actualizada.');

        } catch (\Exception $e) {
            $db->transRollback(); // Usando la variable $db local
            log_message('error', 'Error al actualizar cantidad en carrito: ' . $e->getMessage());
            return redirect()->to(base_url('carrito/ver'))->with('error_cart', 'Ocurrió un error al actualizar la cantidad. Intenta de nuevo.');
        }
    }

    public function confirmar_compra()
    {
        // Obtener la instancia de la base de datos explícitamente
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $id_usuario = session()->get('id');

            if (!$id_usuario) {
                session()->setFlashdata('error_cart', 'Debes iniciar sesión para confirmar tu pedido.');
                return redirect()->to(base_url('login'));
            }

            // --- 1. Obtener y validar los datos del cliente del formulario ---
            $rules = [
                'dni'       => 'required|numeric|min_length[7]|max_length[10]', // Ajusta según el formato de DNI en tu país
                'telefono'  => 'required|numeric|min_length[8]|max_length[15]', // Ajusta según el formato de teléfono
                'direccion' => 'required|min_length[5]|max_length[255]',
            ];

            $messages = [
                'dni' => [
                    'required'    => 'El campo DNI es obligatorio.',
                    'numeric'     => 'El DNI debe contener solo números.',
                    'min_length' => 'El DNI debe tener al menos {param} dígitos.',
                    'max_length' => 'El DNI no debe exceder los {param} dígitos.'
                ],
                'telefono' => [
                    'required'    => 'El campo Teléfono es obligatorio.',
                    'numeric'     => 'El Teléfono debe contener solo números.',
                    'min_length' => 'El Teléfono debe tener al menos {param} dígitos.',
                    'max_length' => 'El Teléfono no debe exceder los {param} dígitos.'
                ],
                'direccion' => [
                    'required'    => 'El campo Dirección es obligatorio.',
                    'min_length' => 'La Dirección debe tener al menos {param} caracteres.',
                    'max_length' => 'La Dirección no debe exceder los {param} caracteres.'
                ]
            ];

            if (!$this->validate($rules, $messages)) {
                $db->transRollback();
                // Enviar los errores de validación de vuelta a la vista del carrito
                session()->setFlashdata('errors', $this->validator->getErrors());
                return redirect()->to(base_url('carrito/ver'))->withInput();
            }

            $dni = $this->request->getPost('dni');
            $telefono = $this->request->getPost('telefono');
            $direccion = $this->request->getPost('direccion');
            // --- Fin de obtención y validación de datos del cliente ---

            $items_carrito = $this->carritoModel->getProductosCarrito($id_usuario);
            $total_venta_calculado = 0; // Inicializamos la variable para calcular el total

            if (empty($items_carrito)) {
                session()->setFlashdata('error_cart', 'Tu carrito está vacío. No se puede confirmar un pedido sin productos.');
                return redirect()->to(base_url('carrito/ver'));
            }

            // --- 2. Preparar los datos del cliente para el campo 'datos_cliente' ---
            $datos_cliente_venta = [
                'nombre'    => session()->get('nombre'),
                'apellido'  => session()->get('apellido'),
                'email'     => session()->get('email'),
                'dni'       => $dni,
                'telefono'  => $telefono,
                'direccion' => $direccion,
            ];

            // Primero insertamos la venta con un total_venta_calculado de 0, lo actualizaremos después
            $data_venta = [
                'id_usuario'    => $id_usuario,
                'total_venta'   => 0, // Se inserta con 0 temporalmente
                'estado_venta'  => 'pendiente',
                'datos_cliente' => json_encode($datos_cliente_venta), // Almacenar todos los datos del cliente como JSON
            ];
            $id_venta = $this->ventaModel->insert($data_venta);

            if (!$id_venta) {
                session()->setFlashdata('error_cart', 'Error al crear el registro de la venta.');
                $db->transRollback();
                return redirect()->to(base_url('carrito/ver'));
            }

            foreach ($items_carrito as $item) {
                // Obtener el producto real para verificar su existencia, no para revalidar stock aquí.
                $producto_real = $this->productoModel->find($item['id_producto']);
                
                // Validar que el producto existe. Si no existe, no podemos procesar la venta.
                if (!$producto_real) {
                    session()->setFlashdata('error_cart', 'El producto "' . esc($item['nombre_producto']) . '" ya no está disponible. Por favor, ajusta tu carrito.');
                    $db->transRollback();
                    return redirect()->to(base_url('carrito/ver'));
                }

                // Si hay stock (ya se validó y dedujo al agregar al carrito), se procede a insertar el detalle de la venta
                $data_detalle = [
                    'id_venta'      => $id_venta,
                    'id_producto'   => $item['id_producto'],
                    'nombre_producto' => $item['nombre_producto'],
                    'cantidad'      => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal'      => $item['subtotal']
                ];
                $this->detalleVentaModel->insert($data_detalle);

                // Sumamos el subtotal al total calculado de la venta
                $total_venta_calculado += $item['subtotal'];

                // NOTA IMPORTANTE: La deducción de stock se hizo en la función 'agregar()'.
                // Aquí solo necesitamos asegurarnos de que el producto esté marcado como inactivo si su stock llegó a 0
                // debido a la compra actual (aunque esto también podría haberse manejado en 'agregar').
                // Si el stock ya es 0 y el producto está activo, lo desactivamos.
                if ($producto_real['stock'] <= 0 && $producto_real['activo'] == 1) {
                    $this->productoModel->update($item['id_producto'], [
                        'activo' => 0
                    ]);
                    log_message('info', 'Producto ID ' . $item['id_producto'] . ' desactivado automáticamente por stock 0 durante la confirmación de compra.');
                }
            }

            // Actualizar el campo total_venta de la venta principal
            $this->ventaModel->update($id_venta, ['total_venta' => $total_venta_calculado]);

            // Vaciar el carrito del usuario después de que la venta y sus detalles se hayan guardado
            $this->carritoModel->where('id_usuario', $id_usuario)->delete();

            $db->transComplete(); // Usando la variable $db local

            if ($db->transStatus() === FALSE) {
                // Si la transacción falló en algún punto (ya se hizo rollback)
                session()->setFlashdata('error_cart', 'Hubo un error al procesar tu pedido. Por favor, inténtalo de nuevo.');
                return redirect()->to(base_url('carrito/ver'));
            } else {
                session()->setFlashdata('success_order', '¡Tu pedido ha sido registrado con éxito! Te contactaremos pronto.');
                return redirect()->to(base_url('pedido/confirmacion/' . $id_venta));
            }

        } catch (\Exception $e) {
            $db->transRollback(); // Usando la variable $db local
            log_message('error', 'Error al confirmar la compra: ' . $e->getMessage());
            session()->setFlashdata('error_cart', 'Ocurrió un error inesperado al procesar tu pedido. Intenta de nuevo más tarde.');
            return redirect()->to(base_url('carrito/ver'));
        }
    }

    public function vaciar()
    {
        // Obtener la instancia de la base de datos explícitamente
        $db = \Config\Database::connect();

        $session = session();
        $id_usuario = $session->get('id'); // Obtén el ID del usuario logueado

        if (!$id_usuario) {
            // Si el usuario no está logueado, redirige o muestra un error
            $session->setFlashdata('error_cart', 'Debes iniciar sesión para vaciar tu carrito.');
            return redirect()->to(base_url('login'));
        }

        // Obtener el carrito actual de la base de datos para verificar si está vacío
        // Es mejor usar getProductosCarrito para obtener los ítems con sus cantidades para devolver el stock
        $productosEnBD = $this->carritoModel->where('id_usuario', $id_usuario)->findAll(); // Usar findAll para obtener los items

        if (!empty($productosEnBD)) { // Cambiado a !empty() para verificar si hay ítems
            // Si hay productos en la BD, intenta vaciarlos y devolver el stock
            if ($this->carritoModel->vaciarCarrito($id_usuario)) {
                // Si se vació de la BD, también vacía la sesión si es que la manejabas
                $session->remove('cart'); // Opcional si solo confías en la BD
                $session->setFlashdata('success_cart', 'Tu carrito ha sido vaciado correctamente.');
            } else {
                $session->setFlashdata('error_cart', 'No se pudo vaciar el carrito en la base de datos. Intenta de nuevo.');
            }
        } else {
            // Si el carrito ya estaba vacío en la BD
            $session->setFlashdata('error_cart', 'Tu carrito ya está vacío.');
        }

        return redirect()->to(base_url('carrito/ver'));
    }
}