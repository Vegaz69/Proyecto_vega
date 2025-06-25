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


     public function buscarProductos($searchTerm, $perPage = 10)
    {
        // Unimos la tabla de productos con la tabla de categorías
        // Asumimos que tienes una tabla 'categorias' con 'id_categoria' y 'nombre'
        $this->select('productos.*, categorias.nombre as categoria_nombre');
        $this->join('categorias', 'categorias.id_categoria = productos.id_categoria', 'left');

        // Filtramos solo productos activos
        $this->where('productos.activo', 1);

        // Condiciones de búsqueda: busca en nombre de producto, marca y nombre de categoría
        if (!empty($searchTerm)) {
            $this->groupStart()
                ->like('productos.nombre', $searchTerm)
                ->orLike('productos.marca', $searchTerm)
                ->orLike('categorias.nombre', $searchTerm) // Busca también en el nombre de la categoría
                ->groupEnd();
        }

        // Ordena los resultados (puedes ajustar el orden si lo deseas)
        $this->orderBy('productos.nombre', 'ASC');

        // Retorna los resultados paginados
        return $this->paginate($perPage);
    }
}