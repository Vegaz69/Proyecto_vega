<?php namespace App\Models;

use CodeIgniter\Model;

class CarritoModel extends Model
{
    protected $table = 'carrito';
    protected $primaryKey = 'id_carrito';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_producto',
        'id_usuario', // ¡Importante que este campo esté aquí!
        'nombre_producto',
        'cantidad',
        'precio_unitario',
        // 'subtotal' NO LO INCLUIMOS AQUÍ porque es una columna GENERADA en la BD.
        'activo' // Si usas este campo en tu lógica de carrito
    ];

    protected $returnType     = 'array'; // o 'object' si lo prefieres

    // Habilitar el uso de Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Para soft deletes (no borra el registro, solo lo marca)

    // Reglas de validación (puedes añadir más si las necesitas)
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // Método para obtener los productos del carrito de un usuario específico, con detalles del producto
    public function getProductosCarrito($id_usuario)
    {
        return $this->select('carrito.*, productos.imagen, productos.stock') // Selecciona campos de carrito y detalles del producto
                    ->join('productos', 'productos.id_producto = carrito.id_producto')
                    ->where('carrito.id_usuario', $id_usuario) // Filtrar por el ID del usuario
                    ->where('carrito.activo', 1) // Asumo que quieres mostrar solo ítems activos en el carrito
                    ->findAll();
    }


     public function vaciarCarrito($id_usuario)
    {
        // Elimina todos los registros del carrito para el id_usuario dado
        return $this->where('id_usuario', $id_usuario)->delete();
    }
}