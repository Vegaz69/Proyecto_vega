<?php namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table      = 'productos'; // Nombre de tu tabla de productos
    protected $primaryKey = 'id_producto'; // Clave primaria de la tabla

    protected $useAutoIncrement = true;

    // Campos que pueden ser rellenados (white-listed fields)
    protected $allowedFields = [
        'nombre',
        'marca',
        'id_categoria',
        'precio',
        'descripcion',
        'imagen',
        'stock',
        'activo' // Es importante incluir 'activo' aquí
    ];

    // Tipo de retorno (array, object, etc.)
    protected $returnType     = 'array';

    // Usar timestamps (created_at, updated_at, deleted_at)
    protected $useTimestamps = false; // Ajusta a 'true' si usas estos campos
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at'; // Para soft deletes si lo implementas más adelante

    // Reglas de validación (opcional, pero recomendable)
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}