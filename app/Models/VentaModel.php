<?php namespace App\Models;

use CodeIgniter\Model;

class VentaModel extends Model
{
    protected $table      = 'ventas';
    protected $primaryKey = 'id_venta';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true; // Si incluiste deleted_at en la tabla

    protected $allowedFields = ['id_usuario', 'total_venta', 'estado_venta', 'datos_cliente'];

    protected $useTimestamps = true; // Si incluiste created_at y updated_at
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Si usas soft deletes

    // Puedes añadir validación si la necesitas
    // protected $validationRules    = [];
    // protected $validationMessages = [];
    // protected $skipValidation     = false;
}