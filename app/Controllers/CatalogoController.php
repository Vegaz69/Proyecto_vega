<?php namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use CodeIgniter\Controller;
use CodeIgniter\Pager\Pager; // Asegúrate de que esto esté aquí si tu CatalogoController extiende Controller directamente y no BaseController

class CatalogoController extends BaseController
{
    protected $productoModel;
    protected $categoriaModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
        helper(['form', 'url']);
    }

    // Muestra el catálogo de productos activos (para el cliente/público) con filtros y ordenamiento
    public function index()
    {
        $data = [];

        // 1. Obtener parámetros de la URL
        $search = $this->request->getGet('search_query'); // Para la búsqueda general (ej. desde la navbar)
        $categoriaId = $this->request->getGet('categoria'); // Filtro por categoría
        $orderBy = $this->request->getGet('orden');         // Ordenamiento (precio_asc, precio_desc, nombre_asc, nombre_desc)

        // 2. Iniciar la consulta base para productos activos
        $query = $this->productoModel
                      ->select('productos.*, categorias.nombre AS categoria_nombre')
                      ->join('categorias', 'categorias.id_categoria = productos.id_categoria', 'left')
                      ->where('productos.activo', 1);
                      // ->where('productos.stock >', 0); // Opcional: Descomenta si solo quieres mostrar productos con stock > 0

        // 3. Aplicar filtro de búsqueda
        if (!empty($search)) {
            $query->groupStart()
                  ->like('productos.nombre', $search)
                  ->orLike('productos.marca', $search)
                  ->groupEnd();
            $data['search_query_navbar'] = $search; // Pasa la query a la vista para mantener el input si lo hubiera
        }

        // 4. Aplicar filtro por categoría
        if (!empty($categoriaId)) {
            $query->where('productos.id_categoria', $categoriaId);
            $data['selected_categoria'] = $categoriaId; // Para que el dropdown de categoría mantenga la selección
        }

        // 5. Aplicar ordenamiento
        switch ($orderBy) {
            case 'nombre_asc':
                $query->orderBy('productos.nombre', 'ASC');
                break;
            case 'nombre_desc':
                $query->orderBy('productos.nombre', 'DESC');
                break;
            case 'precio_asc':
                $query->orderBy('productos.precio', 'ASC');
                break;
            case 'precio_desc':
                $query->orderBy('productos.precio', 'DESC');
                break;
            default:
                // Orden predeterminado si no se especifica o es inválido
                $query->orderBy('productos.nombre', 'ASC');
                break;
        }
        $data['orderBy'] = $orderBy; // Pasa el valor del orden para que el dropdown mantenga la selección

        // 6. Obtener productos paginados
        $data['productos'] = $query->paginate(10); // 10 productos por página
        $data['pager'] = $this->productoModel->pager;

        // 7. Obtener todas las categorías activas para el filtro de la vista
        $data['categorias'] = $this->categoriaModel->where('activo', 1)->orderBy('nombre', 'ASC')->findAll();

        return view('productos/catalogo_publico', $data);
    }

    // Método para el detalle del producto
    public function detalle($id_producto = null)
    {
        if ($id_producto === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $producto = $this->productoModel
                            ->select('productos.*, categorias.nombre AS categoria_nombre')
                            ->join('categorias', 'categorias.id_categoria = productos.id_categoria', 'left')
                            ->find($id_producto);

        // Asegúrate de que el producto existe, está activo y tiene stock (si así lo deseas para la vista de detalle)
        // Puedes descomentar la condición de stock si no quieres que se vea el detalle de productos sin stock
        if (!$producto || $producto['activo'] == 0 /* || $producto['stock'] == 0 */) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $producto['nombre'],
            'producto' => $producto,
            // Si tuvieras un campo 'especificaciones' en la tabla 'productos', se pasaría automáticamente con 'productos.*'
            // Si tuvieras 'imagenes_adicionales' almacenadas como un array en la DB o cargadas por otro método:
            // 'imagenes_adicionales' => $this->productoModel->getImagenesAdicionales($id_producto),
        ];

        // NO se obtiene 'productos_relacionados' ya que no se desea mostrar esa sección.

        return view('productos/detalle', $data);
    }
}