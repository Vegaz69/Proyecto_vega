<?php
// app/Helpers/cart_helper.php

if (!function_exists('getCartItemCount')) {
    /**
     * Retorna la cantidad total de ítems en el carrito del usuario actual.
     *
     * @return int
     */
    function getCartItemCount(): int
    {
        $session = \Config\Services::session();
        $id_usuario = $session->get('id');

        if (!$id_usuario) {
            return 0; // Si no hay usuario logueado, el carrito está vacío
        }

        // Cargar el modelo del carrito
        $carritoModel = new \App\Models\CarritoModel();

        $totalItems = $carritoModel
                         ->selectSum('cantidad')
                         ->where('id_usuario', $id_usuario)
                         ->get()
                         ->getRow();

        return (int) ($totalItems ? $totalItems->cantidad : 0);
    }
}