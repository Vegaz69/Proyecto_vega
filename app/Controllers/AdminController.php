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
        // Carga cualquier dato que desees mostrar en el dashboard (ej. estadísticas)
        $data = [
            'titulo' => 'Panel de Administración',
            // Puedes añadir más datos aquí
        ];

        return view('admin/dashboard', $data);
    }
}