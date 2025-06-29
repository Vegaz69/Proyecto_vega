<?php namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use CodeIgniter\Controller;

class ProductoController extends Controller
{
    protected $productoModel; 
    protected $categoriaModel; 


//     public function listar()
// {
//     return $this->index(); 

// }


    public function __construct()
    {
        $this->productoModel = new ProductoModel(); 
        $this->categoriaModel = new CategoriaModel(); 
        
        helper(['form', 'url']); 
    }

        public function index()
{
    $data = [];

    $search = $this->request->getGet('search');
    $categoriaId = $this->request->getGet('categoria');
    $orden_stock = $this->request->getGet('orden_stock') ?? 'desc'; // Solo dejamos el filtro de stock

    $filterConditions = function ($query) use ($search, $categoriaId) {
        if (!empty($search)) {
            $query->groupStart()
                  ->like('productos.nombre', $search)
                  ->orLike('productos.marca', $search)
                  ->groupEnd();
        }
        if (!empty($categoriaId)) {
            $query->where('productos.id_categoria', $categoriaId);
        }
        return $query;
    };

    // Productos activos ordenados por stock
    $queryActivos = $this->productoModel
                         ->select('productos.*, categorias.nombre AS categoria_nombre')
                         ->join('categorias', 'categorias.id_categoria = productos.id_categoria', 'left');

    $queryActivos = $filterConditions($queryActivos);

    $data['productos'] = $queryActivos
                            ->where('productos.activo', 1)
                            ->orderBy('productos.stock', $orden_stock) 
                            ->paginate(10);
    $data['pager'] = $this->productoModel->pager;

    // Productos desactivados ordenados por stock
    $queryDesactivados = $this->productoModel
                             ->select('productos.*, categorias.nombre AS categoria_nombre')
                             ->join('categorias', 'categorias.id_categoria = productos.id_categoria', 'left');

    $queryDesactivados = $filterConditions($queryDesactivados);

    $data['productosEliminados'] = $queryDesactivados
                                    ->where('productos.activo', 0)
                                    ->orderBy('productos.stock', $orden_stock) 
                                    ->findAll(); 

    // Variables de filtro y categoría
    $data['search'] = $search;
    $data['selected_categoria'] = $categoriaId;
    $data['orden_stock'] = $orden_stock;
    $data['categorias'] = $this->categoriaModel->findAll();

    return view('admin/productos/catalogo', $data);
}
    public function crear()
    {
        $data['categorias'] = $this->categoriaModel->findAll(); 

        return view('admin/productos/crear', $data);
    }

 public function guardar()
    {
        // Asegúrate de que $this->productoModel y $this->categoriaModel
        // estén inicializados en el constructor de tu controlador.
        // Ejemplo:
        // public function __construct()
        // {
        //     $this->productoModel = new \App\Models\ProductoModel();
        //     $this->categoriaModel = new \App\Models\CategoriaModel();
        //     helper(['form', 'url', 'session']); // Asegúrate de que estos helpers estén cargados
        // }

        $id_producto = $this->request->getPost('id_producto'); // Será null si es un nuevo producto

        $data = $this->request->getPost(); // Obtener todos los datos del POST

        // Manejo de la subida de la imagen
        $imagenFile = $this->request->getFile('imagen_file');
        $nombreImagen = $this->request->getPost('imagen_actual'); // Conservar imagen actual si no se sube una nueva

        if ($imagenFile && $imagenFile->isValid() && !$imagenFile->hasMoved()) {
            $nombreImagen = $imagenFile->getRandomName();
            $imagenFile->move(ROOTPATH . 'public/uploads/productos', $nombreImagen);
            if ($id_producto && !empty($this->request->getPost('imagen_actual'))) {
                $oldImagePath = ROOTPATH . 'public/uploads/productos/' . $this->request->getPost('imagen_actual');
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        } elseif ($imagenFile && $imagenFile->hasMoved()) {
            // Si la imagen ya se ha movido (ej. por una ejecución previa), no hacer nada
        } else {
            $nombreImagen = $this->request->getPost('imagen_actual');
        }

        $productData = [
            'nombre'       => $data['nombre'],
            'marca'        => $data['marca'],
            'id_categoria' => $data['id_categoria'],
            'precio'       => $data['precio'],
            'descripcion'  => $data['descripcion'],
            'stock'        => $data['stock'],
            'activo'       => isset($data['activo']) ? 1 : 0,
            'imagen'       => $nombreImagen
        ];

        if ($id_producto) {
            $productData['id_producto'] = $id_producto;
        }

        // --- INICIO: Lógica de validación y redirección explícita ---
        if (!$this->productoModel->validate($productData)) {
            session()->setFlashdata('errors', $this->productoModel->errors());
            session()->setFlashdata('old_input', $this->request->getPost()); // Pasa todos los datos del POST

            if ($id_producto) {
                // Redirige explícitamente a la URL de edición
                return redirect()->to(base_url('admin/productos/editar/' . $id_producto));
            } else {
                // Redirige explícitamente a la URL de creación
                return redirect()->to(base_url('admin/productos/crear'));
            }
        }
        // --- FIN: Lógica de validación y redirección explícita ---

        // Si la validación es exitosa
        try {
            if ($id_producto) {
                $this->productoModel->update($id_producto, $productData);
                session()->setFlashdata('success', 'Producto actualizado correctamente.');
            } else {
                $this->productoModel->insert($productData);
                session()->setFlashdata('success', 'Producto agregado correctamente.');
            }
        } catch (\ReflectionException $e) {
            session()->setFlashdata('error', 'Error al guardar el producto: ' . $e->getMessage());
            // Si hay un error de DB después de la validación, redirigir a la vista correcta con old_input
            session()->setFlashdata('old_input', $this->request->getPost());
            if ($id_producto) {
                return redirect()->to(base_url('admin/productos/editar/' . $id_producto));
            } else {
                return redirect()->to(base_url('admin/productos/crear'));
            }
        }

        return redirect()->to(base_url('admin/productos'));
    }




public function editar($id_producto = null)
{
    if ($id_producto === null) {
        return redirect()->to(base_url('admin/productos'))->with('error', 'ID de producto no proporcionado.');
    }

    $producto = $this->productoModel->find($id_producto);
    if (!$producto) {
        return redirect()->to(base_url('admin/productos'))->with('error', 'El producto no existe.');
    }

    $data['producto'] = $producto;
    $data['categorias'] = $this->categoriaModel->findAll();

    return view('admin/productos/editar', $data);
}

    public function eliminar($id_producto = null) // <-- CAMBIO CLAVE: Añadido "= null"
    {
        if ($id_producto === null) { // <-- AÑADIDO: Validación de ID
            return redirect()->to(base_url('admin/productos'))->with('error', 'ID de producto no proporcionado para eliminar.');
        }

  
        $productoExistente = $this->productoModel->find($id_producto); // <-- CAMBIO CLAVE: $id_producto en lugar de $id
        if (!$productoExistente) {
            return redirect()->to(base_url('admin/productos'))->with('error', 'El producto no existe.'); // <-- CAMBIO: Redirige a admin/productos
        }

        $this->productoModel->update($id_producto, ['activo' => 0]); // <-- CAMBIO CLAVE: $id_producto en lugar de $id

        return redirect()->to(base_url('admin/productos'))->with('success', 'Producto eliminado (desactivado) correctamente.');
    }

    public function restaurar($id_producto = null) // <-- CAMBIO CLAVE: Añadido "= null"
    {
        if ($id_producto === null) { // <-- AÑADIDO: Validación de ID
            return redirect()->to(base_url('admin/productos'))->with('error', 'ID de producto no proporcionado para restaurar.');
        }

        $productoExistente = $this->productoModel->find($id_producto); // <-- CAMBIO CLAVE: $id_producto en lugar de $id
        if (!$productoExistente) {
            return redirect()->to(base_url('admin/productos'))->with('error', 'El producto no existe.'); // <-- CAMBIO: Redirige a admin/productos
        }

        $this->productoModel->update($id_producto, ['activo' => 1]); // <-- CAMBIO CLAVE: $id_producto en lugar de $id

        return redirect()->to(base_url('admin/productos'))->with('success', 'Producto restaurado correctamente.');
    }

    
}
