<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
{
    $rol = session()->get('rol');

    if (!session()->get('isLoggedIn') || !in_array($rol, $arguments)) {
        return redirect()->to('/login');
    }
}


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita lógica posterior en este caso
    }
}

