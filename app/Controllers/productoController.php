<?php namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use CodeIgniter\Controller;

class ProductoController extends Controller
{
    protected $productoModel; // Propiedad para la instancia del modelo de Producto
    protected $categoriaModel; // Propiedad para la instancia del modelo de Categoria

    // Constructor para cargar modelos
    public function __construct()
    {
        $this->productoModel = new ProductoModel(); // <-- CAMBIO: Inicializa el modelo aquí
        $this->categoriaModel = new CategoriaModel(); // <-- CAMBIO: Inicializa el modelo aquí
        
        helper(['form', 'url']); // Ayuda para formularios y URLs
    }

    // Muestra el catálogo de productos para el administrador
        public function index()
    {
        $data = [];

        $search = $this->request->getGet('search');
        $categoriaId = $this->request->getGet('categoria');

        // --- Definir las condiciones de filtro comunes ---
        // Se usarán como base para ambos tipos de consulta (activos y desactivados)
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

        // --- Consulta para productos activos ---
        // Aplicar los filtros comunes y luego las condiciones específicas de activo
        $queryActivos = $this->productoModel
                             ->select('productos.*, categorias.nombre AS categoria_nombre')
                             ->join('categorias', 'categorias.id_categoria = productos.id_categoria', 'left');
        
        $queryActivos = $filterConditions($queryActivos); // Aplica los filtros comunes
        
        $data['productos'] = $queryActivos
                                ->where('productos.activo', 1)
                                ->orderBy('productos.nombre', 'ASC')
                                ->paginate(10);
        $data['pager'] = $this->productoModel->pager; // Línea 56 donde estaba el error si paginate() se llamaba en Builder


        // --- Consulta para productos desactivados ---
        // Aplicar los filtros comunes y luego las condiciones específicas de desactivado
        $queryDesactivados = $this->productoModel
                                 ->select('productos.*, categorias.nombre AS categoria_nombre')
                                 ->join('categorias', 'categorias.id_categoria = productos.id_categoria', 'left');

        $queryDesactivados = $filterConditions($queryDesactivados); // Aplica los filtros comunes

        $data['productosEliminados'] = $queryDesactivados
                                        ->where('productos.activo', 0)
                                        ->orderBy('productos.nombre', 'ASC')
                                        ->findAll(); 

        // Pasar los valores de filtro a la vista para que sean "pegajosos"
        $data['search'] = $search;
        $data['selected_categoria'] = $categoriaId;

        // Obtener todas las categorías para poblar el dropdown del filtro
        $data['categorias'] = $this->categoriaModel->findAll();

        return view('productos/catalogo', $data);
    }

    // Muestra el formulario para crear un nuevo producto
    public function crear()
    {
        $data['categorias'] = $this->categoriaModel->findAll(); // <-- CAMBIO: Usar $this->categoriaModel

        return view('productos/crear', $data);
    }

    public function guardar()
    {
        // No necesitas new ProductoModel() ni new CategoriaModel() aquí, ya están en el constructor
        // $productoModel = new ProductoModel();
        // $categoriaModel = new CategoriaModel();

        $id = $this->request->getPost('id'); // Obtener el ID si estamos editando

        // Reglas de validación para los campos del formulario
        $rules = [
            'nombre'       => 'required|min_length[3]|max_length[255]',
            'marca'        => 'required|min_length[2]|max_length[100]',
            'id_categoria' => 'required|is_natural_no_zero',
            'precio'       => 'required|numeric|greater_than[0]',
            'descripcion'  => 'max_length[1000]',
            'stock'        => 'required|integer|greater_than_equal_to[0]',
            'activo'       => 'permit_empty|integer|in_list[0,1]',
            'imagen_file'  => 'if_exist|uploaded[imagen_file]|max_size[imagen_file,2048]|ext_in[imagen_file,jpg,jpeg,png,gif]',
        ];

        // Mensajes de error personalizados para la validación
        $messages = [
            'nombre' => [
                'required'   => 'El nombre del producto es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no debe exceder los 255 caracteres.',
            ],
            'marca' => [
                'required'   => 'La marca del producto es obligatoria.',
                'min_length' => 'La marca debe tener al menos 2 caracteres.',
                'max_length' => 'La marca no debe exceder los 100 caracteres.',
            ],
            'id_categoria' => [
                'required'           => 'Debe seleccionar una categoría.',
                'is_natural_no_zero' => 'La categoría seleccionada no es válida.',
            ],
            'precio' => [
                'required'      => 'El precio es obligatorio.',
                'numeric'       => 'El precio debe ser un valor numérico.',
                'greater_than'  => 'El precio debe ser mayor que cero.',
            ],
            'stock' => [
                'required'              => 'El stock es obligatorio.',
                'integer'               => 'El stock debe ser un número entero.',
                'greater_than_equal_to' => 'El stock no puede ser negativo.',
            ],
            'imagen_file' => [
                'uploaded'  => 'Debe seleccionar una imagen para subir.',
                'max_size'  => 'El tamaño de la imagen no debe exceder los 2MB.',
                'ext_in'    => 'La imagen debe tener formato JPG, JPEG, PNG o GIF.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            // Si la validación falla, redirigir de vuelta al formulario con los errores y los datos antiguos
            $data['categorias'] = $this->categoriaModel->findAll(); // <-- CAMBIO: Usar $this->categoriaModel
            if ($id) {
                // Si estamos editando, cargamos la vista de edición
                $data['producto'] = $this->productoModel->find($id); // <-- CAMBIO: Usar $this->productoModel
                return view('productos/editar', $data); // Asumo que la vista de edición está en 'productos/editar'
            } else {
                // Si estamos creando, cargamos la vista de creación
                return view('productos/crear', $data); // Asumo que la vista de creación está en 'productos/crear'
            }
        }

        // Procesar la subida de la imagen
        $file = $this->request->getFile('imagen_file');
        $nombreImagen = $this->request->getPost('imagen_actual'); // Obtener el nombre de la imagen actual si existe

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $nombreImagen = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/productos', $nombreImagen);

            if ($id && !empty($this->request->getPost('imagen_actual'))) {
                $rutaImagenAnterior = ROOTPATH . 'public/uploads/productos/' . $this->request->getPost('imagen_actual');
                if (file_exists($rutaImagenAnterior)) {
                    unlink($rutaImagenAnterior);
                }
            }
        } elseif ($id && !empty($this->request->getPost('imagen_actual'))) {
            $nombreImagen = $this->request->getPost('imagen_actual');
        } else {
            $nombreImagen = null;
        }

        // Preparar los datos del producto
        $data = [
            'nombre'        => $this->request->getPost('nombre'),
            'marca'         => $this->request->getPost('marca'),
            'id_categoria'  => $this->request->getPost('id_categoria'),
            'precio'        => $this->request->getPost('precio'),
            'descripcion'   => $this->request->getPost('descripcion'),
            'stock'         => $this->request->getPost('stock'),
            'activo'        => $this->request->getPost('activo') ? 1 : 0, // Si el checkbox está marcado, es 1, si no, es 0
            'imagen'        => $nombreImagen,
        ];

        if ($id) {
            // Actualizar producto existente
            $this->productoModel->update($id, $data); // <-- CAMBIO: Usar $this->productoModel
            return redirect()->to(base_url('admin/productos'))->with('success', 'Producto actualizado correctamente.');
        } else {
            // Crear nuevo producto
            $this->productoModel->insert($data); // <-- CAMBIO: Usar $this->productoModel
            return redirect()->to(base_url('admin/productos'))->with('success', 'Producto agregado correctamente.');
        }
    }

    // Muestra el formulario para editar un producto existente
    public function editar($id_producto = null) // <-- CAMBIO CLAVE: Añadido "= null" para robustez
    {
        if ($id_producto === null) { // <-- AÑADIDO: Validación de ID
            return redirect()->to(base_url('admin/productos'))->with('error', 'ID de producto no proporcionado.');
        }

        $producto = $this->productoModel->find($id_producto); // <-- CAMBIO CLAVE: $id_producto en lugar de $id

        if (!$producto) {
            return redirect()->to(base_url('admin/productos'))->with('error', 'El producto no existe.'); // <-- CAMBIO: Redirige a admin/productos
        }

        $data['producto'] = $producto;
        $data['categorias'] = $this->categoriaModel->findAll(); // <-- CAMBIO: Usar $this->categoriaModel

        return view('productos/editar', $data);
    }

    // Actualiza el estado 'activo' a 0 (eliminación lógica)
    public function eliminar($id_producto = null) // <-- CAMBIO CLAVE: Añadido "= null"
    {
        if ($id_producto === null) { // <-- AÑADIDO: Validación de ID
            return redirect()->to(base_url('admin/productos'))->with('error', 'ID de producto no proporcionado para eliminar.');
        }

        // Verificar que el producto existe antes de marcarlo como eliminado
        $productoExistente = $this->productoModel->find($id_producto); // <-- CAMBIO CLAVE: $id_producto en lugar de $id
        if (!$productoExistente) {
            return redirect()->to(base_url('admin/productos'))->with('error', 'El producto no existe.'); // <-- CAMBIO: Redirige a admin/productos
        }

        // Marcar el producto como inactivo
        $this->productoModel->update($id_producto, ['activo' => 0]); // <-- CAMBIO CLAVE: $id_producto en lugar de $id

        return redirect()->to(base_url('admin/productos'))->with('success', 'Producto eliminado (desactivado) correctamente.');
    }

    // Actualiza el estado 'activo' a 1 (restauración)
    public function restaurar($id_producto = null) // <-- CAMBIO CLAVE: Añadido "= null"
    {
        if ($id_producto === null) { // <-- AÑADIDO: Validación de ID
            return redirect()->to(base_url('admin/productos'))->with('error', 'ID de producto no proporcionado para restaurar.');
        }

        // Verificar que el producto existe antes de restaurarlo
        $productoExistente = $this->productoModel->find($id_producto); // <-- CAMBIO CLAVE: $id_producto en lugar de $id
        if (!$productoExistente) {
            return redirect()->to(base_url('admin/productos'))->with('error', 'El producto no existe.'); // <-- CAMBIO: Redirige a admin/productos
        }

        // Restaurar el producto cambiando "activo" a 1
        $this->productoModel->update($id_producto, ['activo' => 1]); // <-- CAMBIO CLAVE: $id_producto en lugar de $id

        return redirect()->to(base_url('admin/productos'))->with('success', 'Producto restaurado correctamente.');
    }
}