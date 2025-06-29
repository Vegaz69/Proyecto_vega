<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
    

    // BUSCADOR BARRA DE NAVEGACION
        $routes->get('catalogo/suggestions', 'CatalogoController::getSuggestions');

        
    // RUTAS QUE SI NO ESTAN AL COMIENZO NO FUNCIONAN 

    $routes->post('usuarios/guardar', 'UsuarioController::guardar');
   
    


// Ruta para el formulario de contacto (para visitantes)
$routes->post('enviar-contacto', 'ContactoController::enviarConsulta');




// 🔹 1. HOME Y PÁGINAS INFORMATIVAS (públicas)
//
$routes->get('/', 'Home::principal');
$routes->get('principal', 'Home::principal');
$routes->get('quienesSomos', 'Home::quienesSomos');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('contacto', 'Home::contacto');
$routes->get('terminosyUsos', 'Home::terminosyUsos');
$routes->get('construccion', 'Home::construccion');


//
// 🔹 2. CATÁLOGO PÚBLICO Y DETALLE DE PRODUCTOS
//
$routes->get('catalogo', 'CatalogoController::index');
$routes->get('catalogo/buscar', 'CatalogoController::buscar');
$routes->get('productos/(:num)', 'CatalogoController::detalle/$1');


//
// 🔹 3. CARRITO
//
$routes->post('carrito/agregar', 'CarritoController::agregar');
$routes->get('carrito/ver', 'CarritoController::ver');
$routes->post('carrito/eliminar/(:num)', 'CarritoController::eliminar/$1');
$routes->post('carrito/actualizar', 'CarritoController::actualizar');
$routes->get('pedido/confirmacion/(:num)', 'PedidoController::confirmacion/$1');
$routes->post('carrito/confirmar_compra', 'CarritoController::confirmar_compra');
$routes->post('carrito/vaciar', 'CarritoController::vaciar');

// Asegura que solo los usuarios con rol 'cliente' puedan ver sus pedidos
$routes->get('mis-pedidos', 'PedidoController::misPedidos', ['filter' => 'rol:cliente']);

//
// 🔹 4. AUTH / LOGIN / REGISTRO
//
$routes->get('registro', 'AuthController::registroView');
$routes->post('registro', 'AuthController::register');
$routes->get('login', 'AuthController::loginView');
$routes->post('login', 'AuthController::doLogin');
$routes->get('logout', 'AuthController::logout');

// Rutas para gestión de cuenta de usuario (cliente/admin personal)
$routes->get('mi-cuenta', 'AuthController::miCuenta', ['filter' => 'rol:cliente,admin']);
$routes->post('mi-cuenta/actualizar', 'AuthController::actualizarPerfil', ['filter' => 'rol:cliente,admin']);

// Ruta para que el cliente envíe el mensaje desde su cuenta
$routes->post('mi-cuenta/enviar-mensaje', 'MensajesController::enviarMensaje');


//
// 🔹 5. CLIENTE AUTENTICADO
//
$routes->group('cliente', ['filter' => 'rol:cliente'], function($routes) {
    $routes->get('home', 'ClienteController::home');
});


//
// 🔹 6. ADMINISTRACIÓN
//
$routes->group('admin', ['filter' => 'rol:admin'], function($routes) {

    // Dashboard principal
    $routes->get('dashboard', 'AdminController::dashboard');

    //
    // 👥 USUARIOS
    //
    $routes->post('usuarios/guardar', 'UsuarioController::guardar');
    $routes->post('admin/usuarios/guardar', 'UsuarioController::guardar');


    $routes->get('usuarios', 'UsuarioController::listar');
    $routes->get('usuarios/editar/(:num)', 'UsuarioController::editar/$1');
    $routes->get('usuarios/desactivar/(:num)', 'UsuarioController::desactivar/$1');
    $routes->get('usuarios/activar/(:num)', 'UsuarioController::activar/$1');
    $routes->get('usuarios/crear', 'UsuarioController::crear');




    //
    // 📦 PRODUCTOS
    //
    $routes->get('productos', 'ProductoController::index');
    $routes->get('productos/crear', 'ProductoController::crear');
    $routes->get('productos/editar/(:num)', 'ProductoController::editar/$1');
    $routes->get('productos/detalle/(:num)', 'ProductoController::detalle/$1');
    
    $routes->post('productos/guardar', 'ProductoController::guardar');
    $routes->get('productos/eliminar/(:num)', 'ProductoController::eliminar/$1');
    $routes->get('productos/restaurar/(:num)', 'ProductoController::restaurar/$1');


    //
    // 🏷️ CATEGORÍAS
    //
    $routes->get('categorias', 'CategoriaController::index');
    $routes->get('categorias/crear', 'CategoriaController::crear');
    $routes->get('categorias/editar/(:num)', 'CategoriaController::editar/$1');
     $routes->post('categorias/eliminar/(:num)', 'CategoriaController::eliminar/$1');
     $routes->post('categorias/guardar', 'CategoriaController::guardar');
     $routes->get('categorias/restaurar/(:num)', 'CategoriaController::restaurar/$1');
    //
    // VENTAS
    //
    $routes->get('ventas', 'VentasController::listar'); 


     // --- rutas para Mensajes ---
    // $routes->get('mensajes/listado_mensajes', 'AdminMensajesController::index'); 
    // $routes->get('mensajes/marcar-leido/(:num)', 'AdminMensajesController::marcarLeido/$1'); 
    // $routes->get('mensajes/eliminar/(:num)', 'AdminMensajesController::eliminarMensaje/$1'); 

     $routes->get('mensajes', 'AdminMensajesController::index');
    // $routes->get('mensajes/listar', 'AdminMensajesController::index'); // Para compatibilidad con tu formulario de filtro previo

    // Ruta para obtener los detalles de un mensaje (para el modal vía AJAX)
    // $routes->get('mensajes/details/(:num)', 'AdminMensajesController::getMensajeDetails/$1');

    // Rutas para marcar como leído y eliminar
    $routes->get('mensajes/marcar-leido/(:num)', 'AdminMensajesController::marcarLeido/$1');
    $routes->get('mensajes/eliminar/(:num)', 'AdminMensajesController::eliminarMensaje/$1');

});
