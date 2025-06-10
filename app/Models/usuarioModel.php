<?php namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table        = 'usuarios';
    protected $primaryKey = 'id_usuario';
    
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';

    protected $allowedFields = ['nombre', 'email', 'password', 'rol', 'activo'];

    protected $useTimestamps = true; // ✅ PON EN 'false' SI NO TIENES COLUMNAS 'created_at' y 'updated_at' en tu tabla
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'nombre'    => 'required|min_length[3]|max_length[50]',
        'email'     => 'required|valid_email|is_unique[usuarios.email,id_usuario,{id_usuario}]',
        'password'  => 'permit_empty|min_length[8]',
        // <-- CAMBIO CLAVE AQUÍ: 'in_list' debe coincidir con los valores EXACTOS del ENUM
        'rol'       => 'required|in_list[admin,cliente]', // <-- CAMBIO: 'admin' y 'cliente'
        'activo'    => 'permit_empty|integer|in_list[0,1]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del usuario es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no debe exceder los 50 caracteres.'
        ],
        'email' => [
            'required'    => 'El email es obligatorio.',
            'valid_email' => 'Ingrese un email válido.',
            'is_unique'   => 'Este email ya está registrado.'
        ],
        'password' => [
            'min_length' => 'La contraseña debe tener al menos 8 caracteres.'
        ],
        'rol' => [
            'required' => 'El rol del usuario es obligatorio.',
            // <-- CAMBIO CLAVE AQUÍ: Mensaje para reflejar los valores EXACTOS del ENUM
            'in_list'  => 'El rol seleccionado no es válido. Debe ser "admin" o "cliente".' // <-- MENSAJE AJUSTADO
        ],
        'activo' => [
            'integer'  => 'El estado activo debe ser un número entero (0 o 1).',
            'in_list'  => 'El estado activo no es válido.'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPasswordIfProvided'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    protected function hashPasswordIfProvided(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']);
        }
        return $data;
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}