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
    protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // --- Reglas de validación ---
    protected $validationRules = [
        'id_producto' => [
            'label' => 'ID del Producto',
            'rules' => 'permit_empty|integer',
            'errors' => [
                'integer' => 'El {field} debe ser un número entero válido.'
            ]
        ],
        'nombre' => [
            'label'  => 'Nombre del Producto',
            // CAMBIO AQUÍ: max_length[100]
            'rules'  => 'required|min_length[3]|max_length[100]|alpha_numeric_space|is_unique[productos.nombre,id_producto,{id_producto}]',
            'errors' => [
                'required'            => 'El {field} es obligatorio.',
                'min_length'          => 'El {field} debe tener al menos {param} caracteres.',
                'max_length'          => 'El {field} no debe exceder los {param} caracteres.', // Este mensaje usará 100
                'alpha_numeric_space' => 'El {field} solo puede contener letras, números y espacios.',
                'is_unique'           => 'Ya existe un producto con este {field}.'
            ]
        ],
        'marca' => [
            'label'  => 'Marca',
            'rules'  => 'required|min_length[2]|max_length[100]|alpha_numeric_space',
            'errors' => [
                'required'            => 'La {field} es obligatoria.',
                'min_length'          => 'La {field} debe tener al menos {param} caracteres.',
                'max_length'          => 'La {field} no debe exceder los {param} caracteres.',
                'alpha_numeric_space' => 'La {field} solo puede contener letras, números y espacios.'
            ]
        ],
        'id_categoria' => [
            'label'  => 'Categoría',
            'rules'  => 'required|integer|is_natural_no_zero|exist_in_table[categorias,id_categoria]',
            'errors' => [
                'required'           => 'La {field} es obligatoria.',
                'integer'            => 'Debe seleccionar una {field} válida.',
                'is_natural_no_zero' => 'Debe seleccionar una {field} válida.',
                'exist_in_table'     => 'La {field} seleccionada no existe.'
            ]
        ],
        'precio' => [
            'label'  => 'Precio',
            'rules'  => 'required|numeric|greater_than[0]|decimal',
            'errors' => [
                'required'     => 'El {field} es obligatorio.',
                'numeric'      => 'El {field} debe ser un número.',
                'greater_than' => 'El {field} debe ser mayor a 0.',
                'decimal'      => 'El {field} debe ser un número decimal válido.'
            ]
        ],
        'descripcion' => [
            'label'  => 'Descripción',
            'rules'  => 'max_length[65535]',
            'errors' => [
                'max_length' => 'La {field} no debe exceder los {param} caracteres.'
            ]
        ],
        'stock' => [
            'label'  => 'Stock',
            'rules'  => 'required|integer|greater_than_equal_to[0]',
            'errors' => [
                'required'              => 'El {field} es obligatorio.',
                'integer'               => 'El {field} debe ser un número entero.',
                'greater_than_equal_to' => 'El {field} no puede ser negativo.'
            ]
        ],
        'activo' => [
            'label'  => 'Estado Activo',
            'rules'  => 'required|in_list[0,1]',
            'errors' => [
                'required' => 'El {field} es obligatorio.',
                'in_list'  => 'El {field} debe ser 0 (inactivo) o 1 (activo).'
            ]
        ],
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    protected function exist_in_table(string $str, string $fields, array $data): bool
    {
        list($table, $field) = explode(',', $fields);
        $db = \Config\Database::connect();
        
        if (empty($table) || empty($field)) {
            return false;
        }

        return $db->table($table)->where($field, $str)->countAllResults() > 0;
    }

    public function buscarProductos($searchTerm, $perPage = 10)
    {
        $this->select('productos.*, categorias.nombre as categoria_nombre');
        $this->join('categorias', 'categorias.id_categoria = productos.id_categoria', 'left');
        $this->where('productos.activo', 1);
        if (!empty($searchTerm)) {
            $this->groupStart()
                ->like('productos.nombre', $searchTerm)
                ->orLike('productos.marca', $searchTerm)
                ->orLike('categorias.nombre', $searchTerm)
                ->groupEnd();
        }
        $this->orderBy('productos.nombre', 'ASC');
        return $this->paginate($perPage);
    }
}