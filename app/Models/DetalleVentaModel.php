<?php namespace App\Models;

use CodeIgniter\Model;

class DetalleVentaModel extends Model
{
    protected $table      = 'detalle_venta';
    protected $primaryKey = 'id_detalle';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_venta',
        'id_producto',
        'nombre_producto',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    // No suelen llevar timestamps los detalles de venta si la venta ya los tiene
    protected $useTimestamps = false;
}