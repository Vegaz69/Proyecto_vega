<?php namespace App\Models;

use CodeIgniter\Model;

class VentaModel extends Model
{
    protected $table      = 'ventas';
    protected $primaryKey = 'id_venta';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_usuario',
        'total_venta',
        'estado_venta',
        'datos_cliente' // Si almacenas datos adicionales del cliente en la venta
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Si lo necesitas
}