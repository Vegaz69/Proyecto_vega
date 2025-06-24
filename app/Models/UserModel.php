<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['nombre', 'apellido', 'email', 'password', 'rol', 'activo'];
    protected $returnType = 'array';
    protected $useTimestamps = true;

    // Reglas de validación
    protected $validationRules = [
        'nombre'    => 'required|alpha_space|min_length[3]|max_length[255]', // Añadido alpha_space
        'apellido'  => 'required|alpha_space|min_length[3]|max_length[255]', // Añadido alpha_space
        'email'     => 'required|valid_email|is_unique[usuarios.email,id_usuario,{id_usuario}]',
        'password'  => 'required|min_length[8]', // Esta regla será ajustada en el controlador para edición
        'rol'       => 'required|in_list[admin,cliente]',
    ];

    // Mensajes de validación personalizados
    protected $validationMessages = [
        'nombre' => [
            'required'    => 'El nombre es obligatorio.',
            'alpha_space' => 'El nombre solo puede contener letras y espacios.', // Mensaje específico para alpha_space
            'min_length'  => 'El nombre debe tener al menos 3 caracteres.',
            'max_length'  => 'El nombre no puede exceder los 255 caracteres.',
        ],
        'apellido' => [
            'required'    => 'El apellido es obligatorio.',
            'alpha_space' => 'El apellido solo puede contener letras y espacios.', // Mensaje específico para alpha_space
            'min_length'  => 'El apellido debe tener al menos 3 caracteres.',
            'max_length'  => 'El apellido no puede exceder los 255 caracteres.',
        ],
        'email' => [
            'required'    => 'El correo electrónico es obligatorio.',
            'valid_email' => 'Por favor, introduce un correo electrónico válido (ej. usuario@dominio.com).', // Mensaje más específico
            'is_unique'   => 'Este correo electrónico ya está registrado. Por favor, usa otro.', // Mensaje más específico
        ],
        'password' => [
            'required'   => 'La contraseña es obligatoria.',
            'min_length' => 'La contraseña debe tener al menos 8 caracteres.',
        ],
        'rol' => [
            'required'  => 'El rol es obligatorio.',
            'in_list'   => 'El rol seleccionado no es válido.',
        ],
    ];

    // No necesitas getValidationRules() ni getValidationMessages() si las propiedades están protegidas,
    // CodeIgniter las usa automáticamente al llamar $this->validate() en el controlador.
    // Si las tenías por alguna razón específica, me avisas.
}
