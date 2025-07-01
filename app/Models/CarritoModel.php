<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\ProductoModel; // Importa el ProductoModel

class CarritoModel extends Model
{
    protected $table = 'carrito';
    protected $primaryKey = 'id_carrito';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_producto',
        'id_usuario',
        'nombre_producto',
        'cantidad',
        'precio_unitario',
        'activo'
    ];

    protected $returnType     = 'array';

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $productoModel;

    public function __construct()
    {
        parent::__construct();
        $this->productoModel = new ProductoModel();
    }

    public function getProductosCarrito($id_usuario)
    {
        return $this->select('carrito.*, productos.imagen, productos.stock as stock_actual')
                    ->join('productos', 'productos.id_producto = carrito.id_producto')
                    ->where('carrito.id_usuario', $id_usuario)
                    ->where('carrito.activo', 1)
                    ->findAll();
    }

    /**
     * Vacía el carrito de un usuario y devuelve el stock de los productos.
     *
     * @param int $id_usuario El ID del usuario cuyo carrito se va a vaciar.
     * @return bool True si el carrito se vació correctamente, false en caso contrario.
     */
 public function vaciarCarrito(int $id_usuario): bool
    {
        log_message('debug', 'Iniciando vaciarCarrito para usuario ID: ' . $id_usuario);

        // No es necesario obtener los ítems del carrito si solo vamos a eliminarlos
        // y no vamos a devolver stock.
        // $items_en_carrito = $this->where('id_usuario', $id_usuario)->findAll();

        // if (empty($items_en_carrito)) {
        //     log_message('debug', 'Carrito ya vacío para usuario ID: ' . $id_usuario);
        //     return true; // No hay nada que vaciar
        // }

        $this->db->transBegin();
        log_message('debug', 'Transacción de BD iniciada para vaciar carrito.');

        try {
            // Eliminar todos los ítems del carrito para ese usuario
            $deleteResult = $this->where('id_usuario', $id_usuario)->delete();
            log_message('debug', 'Resultado de eliminación de ítems del carrito para usuario ID ' . $id_usuario . ': ' . ($deleteResult ? 'Éxito' : 'Fallo'));

            $this->db->transCommit();
            log_message('debug', 'Transacción de BD confirmada para vaciar carrito.');
            return true;

        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Error CRÍTICO al vaciar el carrito: ' . $e->getMessage());
            return false;
        }
}
}