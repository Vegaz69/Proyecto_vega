<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // 1. Verificar si el usuario NO está logueado
        if (!$session->get('isLoggedIn')) {
            // Si no está logueado, redirigir a la página principal con el modal de login
            return redirect()->to(base_url('principal?loginModal=true'))->with('error', 'Necesitas iniciar sesión para acceder a esta sección.');
        }

        // 2. Si el usuario está logueado, verificar su rol.
        // Como este filtro solo se aplica a las rutas de 'admin',
        // si se llega a este punto y el rol no es 'admin', el acceso no está autorizado.
        $rol_usuario = $session->get('rol');

        if ($rol_usuario !== 'admin') {
            // Si el rol no es 'admin', redirigir a la página principal con un mensaje de error
            return redirect()->to(base_url('principal'))->with('error', 'Acceso no autorizado. No tienes permisos para acceder a esta sección de administración.');
        }

        // Si está logueado Y su rol es 'admin', permitir el acceso
        return true;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita nada aquí
    }
}