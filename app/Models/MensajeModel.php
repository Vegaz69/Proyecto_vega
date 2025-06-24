<?php

namespace App\Models;

use CodeIgniter\Model;

class MensajeModel extends Model
{
    protected $table        = 'mensajes_contacto'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_mensaje'; // Clave primaria de la tabla

    protected $useAutoIncrement = true; // Indica que la clave primaria es autoincremental

    protected $returnType     = 'array'; // Formato en que se devolverán los resultados
    protected $useSoftDeletes = false; // No usaremos borrado suave para los mensajes

    // Campos que pueden ser rellenados (insertados/actualizados) en la base de datos
    // ¡Asegúrate de que todos los campos que intentas insertar/actualizar estén aquí!
    protected $allowedFields = ['id_usuario', 'nombre_completo', 'email', 'telefono', 'asunto', 'mensaje', 'fecha_envio', 'leido', 'tipo_mensaje'];

    // Timestamps
    protected $useTimestamps = false; // No necesitamos campos created_at, updated_at, deleted_at automáticos aquí
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Reglas de validación y mensajes
    // Aunque ya validamos en el controlador, tener reglas aquí es una buena práctica de seguridad.
    // protected $validationRules    = [
    //    'id_usuario'    => 'required|integer',
    //    'asunto'        => 'required|min_length[3]|max_length[255]',
    //    'mensaje'       => 'required|min_length[10]|max_length[1000]',
    //    'fecha_envio'   => 'required|valid_date',
    //    'leido'         => 'permit_empty|integer|in_list[0,1]',
    // ];

    // protected $validationMessages = [];
    // protected $skipValidation     = false;
}