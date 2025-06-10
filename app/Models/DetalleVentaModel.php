<?php namespace App\Models;

use CodeIgniter\Model;

class DetalleVentaModel extends Model
{
    protected $table      = 'detalle_venta';
    protected $primaryKey = 'id_detalle';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false; // Detalle de venta no suele tener soft delete

    protected $allowedFields = ['id_venta', 'id_producto', 'nombre_producto', 'cantidad', 'precio_unitario', 'subtotal'];

    protected $useTimestamps = false; // Detalle de venta no suele tener timestamps propios
}