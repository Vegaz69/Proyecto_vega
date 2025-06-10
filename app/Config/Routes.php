<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. Rutas Públicas / Home (sin autenticación requerida)
$routes->get('/', 'Home::principal');
$routes->get('principal', 'Home::principal');
$routes->get('quienesSomos', 'Home::quienesSomos');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('contacto', 'Home::contacto');
$routes->get('terminosyUsos', 'Home::terminosyUsos');
$routes->get('construccion', 'Home::construccion');

// Rutas de Autenticación (formularios y procesamiento)
$routes->post('login', 'Auth::login');
$routes->get('registro', 'Auth::registerForm');
$routes->post('registro', 'Auth::register');
$routes->get('logout', 'Auth::logout');

// 2. Rutas del Catálogo de Productos (Público, sin autenticación requerida)
// APUNTA A CatalogoController, NO A ProductoController (ProductoController es para Admin)
$routes->get('catalogo', 'CatalogoController::index');        // Muestra el catálogo público de productos activos
$routes->get('catalogo/buscar', 'CatalogoController::buscar'); // Realiza la búsqueda en el catálogo público

// Ruta para el detalle de un producto específico (ahora apunta a CatalogoController)
$routes->get('productos/(:num)', 'CatalogoController::detalle/$1');

// 3. Rutas de Gestión de Productos (Administrador - REQUIEREN AUTENTICACIÓN)
// Todas las rutas dentro de este grupo estarán protegidas por el filtro 'auth'.


// Nueva ruta para añadir al carrito
$routes->post('carrito/agregar', 'CarritoController::agregar');
$routes->get('carrito', 'CarritoController::verCarrito');
$routes->get('carrito/ver', 'CarritoController::verCarrito'); 
$routes->post('carrito/eliminar', 'CarritoController::eliminarProducto');
$routes->post('carrito/actualizar', 'CarritoController::actualizarCantidad');
$routes->post('carrito/procesarCompra', 'CarritoController::procesarCompra'); 







$routes->group('admin', ['filter' => 'auth'], function($routes) {

    // Ruta principal del Dashboard de administración
    $routes->get('dashboard', 'AdminController::dashboard');

    // Rutas para el listado principal de productos del administrador (consolidado)
    $routes->get('productos', 'ProductoController::index');
    // La ruta 'catalogo' dentro de 'admin' es redundante si 'productos' hace lo mismo.
    // Si 'admin/catalogo' es diferente a 'admin/productos', déjala. Si no, puedes eliminar una.
    // $routes->get('catalogo', 'ProductoController::index');


    // Rutas para las operaciones CRUD específicas de productos (admin)
    // Estas rutas seguirán el patrón /admin/productos/...
    $routes->group('productos', function($routes) {
        $routes->get('crear', 'ProductoController::crear');           // admin/productos/crear
        $routes->post('guardar', 'ProductoController::guardar');      // admin/productos/guardar (maneja creación y edición)
        $routes->get('editar/(:num)', 'ProductoController::editar/$1'); // admin/productos/editar/:id
        $routes->get('eliminar/(:num)', 'ProductoController::eliminar/$1'); // admin/productos/eliminar/:id (desactivar)
        $routes->get('restaurar/(:num)', 'ProductoController::restaurar/$1'); // admin/productos/restaurar/:id
    });

    // La ruta 'guardar' directa bajo 'admin' ($routes->post('guardar', 'ProductoController::guardar');)
    // es redundante con la que está dentro de $routes->group('productos', ...).
    // Deberías eliminar esta línea para evitar confusiones y usar solo admin/productos/guardar.
    // $routes->post('guardar', 'ProductoController::guardar');


    /* Rutas para la gestión de categorías */
    $routes->get('categorias', 'CategoriaController::index');
    $routes->get('categorias/crear', 'CategoriaController::crear');
    $routes->post('categorias/guardar', 'CategoriaController::guardar');
    $routes->get('categorias/editar/(:num)', 'CategoriaController::editar/$1');
    $routes->get('categorias/eliminar/(:num)', 'CategoriaController::eliminar/$1');
    $routes->get('categorias/restaurar/(:num)', 'CategoriaController::restaurar/$1');


    // Rutas para gestión de usuarios
    $routes->get('usuarios', 'UsuarioController::index');
    $routes->get('usuarios/editar/(:num)', 'UsuarioController::editar/$1');
    $routes->post('usuarios/guardar', 'UsuarioController::guardar');
    $routes->get('usuarios/desactivar/(:num)', 'UsuarioController::desactivar/$1');
    $routes->get('usuarios/activar/(:num)', 'UsuarioController::activar/$1');
});