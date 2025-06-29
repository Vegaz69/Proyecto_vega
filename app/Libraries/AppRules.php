<?php namespace App\Libraries;

use CodeIgniter\Database\BaseBuilder;

class AppRules
{
    /**
     * Valida si un valor existe en una columna de una tabla específica.
     * Uso: exist_in_table[nombre_tabla,nombre_columna]
     * Ejemplo: exist_in_table[categorias,id_categoria]
     *
     * @param string $str El valor a buscar.
     * @param string $fields La tabla y columna separadas por coma (ej. 'categorias,id_categoria').
     * @param array $data Todos los datos del formulario.
     * @return bool
     */
    public function exist_in_table(string $str, string $fields, array $data): bool
    {
        list($table, $field) = explode(',', $fields);
        $db = \Config\Database::connect();
        
        // Asegurarse de que la tabla y el campo no estén vacíos para evitar errores SQL
        if (empty($table) || empty($field)) {
            return false;
        }

        // Realiza la consulta para verificar si el valor existe
        return $db->table($table)->where($field, $str)->countAllResults() > 0;
    }
}