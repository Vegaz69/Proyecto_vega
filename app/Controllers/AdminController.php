<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    /**
     * Muestra el panel principal de administración.
     * Requiere que el usuario esté autenticado y tenga rol de administrador.
     */
        public function dashboard()
    {
        if (!session()->get('isLoggedIn') || session()->get('rol') !== 'admin') {
            return redirect()->to('login');
        }

        return view('admin/dashboard');
    }

}   