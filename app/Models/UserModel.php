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

    // Reglas de validación base
    protected $validationRules = [
        'nombre'    => 'required|alpha_space|min_length[3]|max_length[255]',
        'apellido'  => 'required|alpha_space|min_length[3]|max_length[255]',
        'email'     => 'required|valid_email', // Aquí NO va is_unique aún
        'password'  => 'required|min_length[8]',
        'rol'       => 'required|in_list[admin,cliente]',
    ];

    // Mensajes de validación personalizados
    protected $validationMessages = [
        'nombre' => [
            'required'    => 'El nombre es obligatorio.',
            'alpha_space' => 'El nombre solo puede contener letras y espacios.',
            'min_length'  => 'El nombre debe tener al menos 3 caracteres.',
            'max_length'  => 'El nombre no puede exceder los 255 caracteres.',
        ],
        'apellido' => [
            'required'    => 'El apellido es obligatorio.',
            'alpha_space' => 'El apellido solo puede contener letras y espacios.',
            'min_length'  => 'El apellido debe tener al menos 3 caracteres.',
            'max_length'  => 'El apellido no puede exceder los 255 caracteres.',
        ],
        'email' => [
            'required'    => 'El correo electrónico es obligatorio.',
            'valid_email' => 'Por favor, introduce un correo electrónico válido (ej. usuario@dominio.com).',
            'is_unique'   => 'Este correo electrónico ya está registrado. Por favor, usa otro.', // Este mensaje aplica si se agrega la regla
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

    /**
     * Retorna las reglas de validación, ajustadas para un ID de usuario específico si se proporciona.
     *
     * @param int|null $id_usuario El ID del usuario actual para ignorar en la validación unique.
     * @return array Las reglas de validación.
     */
    public function getValidationRulesForUser(?int $id_usuario = null): array
    {
        $rules = $this->validationRules; // Obtenemos las reglas base

        // Ajustamos la regla de 'email' para que sea 'is_unique' solo si estamos actualizando
        // y para ignorar el email del propio usuario si se proporciona un id_usuario.
        if ($id_usuario !== null) {
            $rules['email'] .= '|is_unique[usuarios.email,id_usuario,' . $id_usuario . ']';
        } else {
            $rules['email'] .= '|is_unique[usuarios.email]'; // Para creación, debe ser único sin ignorar a nadie
        }

        return $rules;
    }

    // El método getValidationMessages() se mantiene igual ya que las reglas base no cambian los mensajes.
    // Solo necesitas asegurarte de que tu controlador use esta nueva función.
}