<?php namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table      = 'categorias'; // Nombre de tu tabla de categorías
    protected $primaryKey = 'id_categoria'; // Clave primaria de la tabla

    protected $useAutoIncrement = true;
    protected $allowedFields = ['nombre', 'activo']; // Solo el campo 'nombre'

    protected $returnType     = 'array';
    protected $useTimestamps = false;
}