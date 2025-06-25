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
        $id_producto = $this->request->getPost('id_producto'); // Asegurar que se recibe el ID correctamente

        // Reglas de validación
        $rules = [
            'nombre'         => 'required|min_length[3]|max_length[255]',
            'marca'          => 'required|min_length[2]|max_length[100]',
            'id_categoria'   => 'required|is_natural_no_zero',
            'precio'         => 'required|numeric|greater_than[0]',
            'descripcion'    => 'max_length[65535]',
            'stock'          => 'required|integer|greater_than_equal_to[0]',
            'activo'         => 'permit_empty|integer|in_list[0,1]',
            'imagen_file'    => 'if_exist|uploaded[imagen_file]|max_size[imagen_file,2048]|ext_in[imagen_file,jpg,jpeg,png,gif]',
        ];

        if (!$this->validate($rules)) {
            $data['categorias'] = $this->categoriaModel->findAll();
            $data['producto'] = ($id_producto) ? $this->productoModel->find($id_producto) : null;
            return view('admin/productos/crear', $data);
        }

        // --- INICIO: Nueva lógica de validación para categoría activa ---
        $id_categoria_seleccionada = $this->request->getPost('id_categoria');
        $categoria = $this->categoriaModel->find($id_categoria_seleccionada);

        // Si la categoría no existe o está inactiva
        if (!$categoria || $categoria['activo'] == 0) {
            session()->setFlashdata('error', 'No se puede crear el producto: La categoría seleccionada no existe o está inactiva.');
            $data['categorias'] = $this->categoriaModel->findAll(); // Recargar categorías para la vista
            $data['producto'] = ($id_producto) ? $this->productoModel->find($id_producto) : null; // Si es edición, recargar producto
            return view('admin/productos/crear', $data);
        }
        // --- FIN: Nueva lógica de validación para categoría activa ---


        // Procesar la imagen
        $file = $this->request->getFile('imagen_file');
        $nombreImagen = $this->request->getPost('imagen_actual');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $nombreImagen = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/productos', $nombreImagen);

            if ($id_producto && !empty($this->request->getPost('imagen_actual'))) {
                $rutaImagenAnterior = ROOTPATH . 'public/uploads/productos/' . $this->request->getPost('imagen_actual');
                if (file_exists($rutaImagenAnterior)) {
                    unlink($rutaImagenAnterior);
                }
            }
        }

        // Datos del producto
        $data = [
            'nombre'         => $this->request->getPost('nombre'),
            'marca'          => $this->request->getPost('marca'),
            'id_categoria'   => $this->request->getPost('id_categoria'),
            'precio'         => $this->request->getPost('precio'),
            'descripcion'    => $this->request->getPost('descripcion'),
            'stock'          => $this->request->getPost('stock'),
            'activo'         => $this->request->getPost('activo') ? 1 : 0,
            'imagen'         => $nombreImagen,
        ];

        if ($id_producto && $this->productoModel->find($id_producto)) {
            $this->productoModel->update($id_producto, $data);
            return redirect()->to(base_url('admin/productos'))->with('success', 'Producto actualizado correctamente.');
        } else {
            $this->productoModel->insert($data);
            return redirect()->to(base_url('admin/productos'))->with('success', 'Producto agregado correctamente.');
        }
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
