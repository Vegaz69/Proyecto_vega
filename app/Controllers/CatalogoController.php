<?php namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\CategoriaModel; // <-- ¡ESTA LÍNEA ESTABA MAL, AHORA ESTÁ CORREGIDA!
use CodeIgniter\Controller;
use CodeIgniter\Pager\Pager;

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

    /**
     * Procesa el término de búsqueda original:
     * 1. Divide la frase en palabras individuales.
     * 2. Para cada palabra, verifica si tiene sinónimos definidos.
     * 3. Retorna un array único de todas las palabras procesadas (originales + sinónimos).
     *
     * @param string $originalTerm El término de búsqueda ingresado por el usuario.
     * @return array Un array de términos a utilizar en las consultas LIKE.
     */
    private function _getProcessedSearchTerms(string $originalTerm): array
    {
        $rawWords = explode(' ', strtolower($originalTerm)); // Dividir la frase en palabras
        $processedTerms = [];

        // Define tus sinónimos aquí. Formato: 'palabra_clave' => ['sinónimo1', 'sinónimo2']
        $synonymsMap = [
            'pantallas' => ['monitores'],
            'monitores' => ['pantallas'],
            'pc' => ['ordenador', 'computadora', 'computador'],
            'cpu' => ['procesador'],
            'grafica' => ['tarjeta grafica', 'gpu', 'placa de video'],
            'ram' => ['memoria ram', 'memoria'],
            'teclado' => ['keyboard'],
            'mouse' => ['raton'],
            'auriculares' => ['headset', 'cascos'],
            // Puedes seguir añadiendo más sinónimos aquí para tu nicho
        ];

        foreach ($rawWords as $word) {
            $word = trim($word);
            if (empty($word)) {
                continue;
            }

            $processedTerms[] = $word; // Siempre incluir la palabra original

            // Buscar sinónimos para la palabra actual
            foreach ($synonymsMap as $key => $values) {
                if ($word === $key) {
                    foreach ($values as $synonym) {
                        $processedTerms[] = $synonym;
                    }
                } else if (in_array($word, $values)) {
                    // Si la palabra es un sinónimo, añadir la clave principal y otros sinónimos
                    $processedTerms[] = $key;
                    foreach ($values as $synonym) {
                        $processedTerms[] = $synonym;
                    }
                }
            }
        }
        
        // Eliminar duplicados y reindexar el array
        return array_values(array_unique($processedTerms));
    }


    // Muestra el catálogo de productos activos (para el cliente/público) con filtros y ordenamiento
    public function index()
    {
        $data = [];

        // 1. Obtener parámetros de la URL
        $search = $this->request->getGet('search_query'); 
        $categoriaId = $this->request->getGet('categoria'); 
        $orderBy = $this->request->getGet('orden');          

        // --- Lógica para redirigir si la búsqueda es una categoría activa (exacta) ---
        // Esto se ejecuta SÓLO si hay un 'search_query' y NO hay un 'categoria' ya definido en la URL.
        // Aquí NO usamos sinónimos para la coincidencia de categoría porque queremos una redirección canónica por ID.
        if (!empty($search) && empty($categoriaId)) {
            $matchedCategory = $this->categoriaModel
                                     ->where('activo', 1)
                                     ->where('LOWER(nombre)', strtolower($search)) 
                                     ->first();

            if ($matchedCategory) {
                return redirect()->to(base_url('catalogo?categoria=' . $matchedCategory['id_categoria'] . '&orden=' . esc($orderBy)));
            }
        }
        // --- FIN: Lógica para redirigir si la búsqueda es una categoría activa ---


        // 2. Iniciar la consulta base para productos activos y categorías activas
        $query = $this->productoModel
                      ->select('productos.*, categorias.nombre AS categoria_nombre')
                      ->join('categorias', 'categorias.id_categoria = productos.id_categoria', 'left')
                      ->where('productos.activo', 1) 
                      ->where('productos.stock >', 0) 
                      ->where('categorias.activo', 1);

        // 3. Aplicar filtro de búsqueda general (nombre de producto o marca)
        if (!empty($search)) {
            // Obtener todos los términos de búsqueda procesados (incluyendo sinónimos y palabras individuales)
            $processedSearchTerms = $this-> _getProcessedSearchTerms($search);

            $query->groupStart();
            foreach ($processedSearchTerms as $termToSearch) {
                // Aplicar LIKE a cada término en nombre y marca
                $query->orLike('productos.nombre', $termToSearch, 'both', null, true);
                $query->orLike('productos.marca', $termToSearch, 'both', null, true);
            }
            $query->groupEnd();
            $data['search_query_navbar'] = $search; // Mantener el término original en la barra de búsqueda
        }

        // 4. Aplicar filtro por categoría (si se recibió un ID de categoría)
        if (!empty($categoriaId)) {
            $categoriaParaFiltro = $this->categoriaModel->find($categoriaId);
            if ($categoriaParaFiltro && $categoriaParaFiltro['activo'] == 1) {
                $query->where('productos.id_categoria', $categoriaId);
                $data['selected_categoria'] = $categoriaId;
            } else {
                session()->setFlashdata('info', 'La categoría seleccionada no existe o está inactiva y no se puede usar para filtrar.');
            }
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
                $query->orderBy('productos.nombre', 'ASC');
                break;
        }
        $data['orderBy'] = $orderBy;

        // 6. Obtener productos paginados
        $data['productos'] = $query->paginate(10);
        $data['pager'] = $this->productoModel->pager;

        // 7. Obtener solo las categorías activas para el filtro de la vista
        $data['categorias'] = $this->categoriaModel->where('activo', 1)->orderBy('nombre', 'ASC')->findAll();

        // Si no se encontraron productos, puedes añadir un mensaje flashdata aquí
        if (empty($data['productos']) && !empty($search)) {
            session()->setFlashdata('info', 'No se encontraron productos que coincidan con su búsqueda "' . esc($search) . '".');
        }


        return view('admin/productos/catalogo_publico', $data);
    }

    // Método para el detalle del producto
    public function detalle($id_producto = null)
    {
        if ($id_producto === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $producto = $this->productoModel
                            ->select('productos.*, categorias.nombre AS categoria_nombre, categorias.activo AS categoria_activa') 
                            ->join('categorias', 'categorias.id_categoria = productos.id_categoria', 'left')
                            ->find($id_producto);

        if (!$producto || $producto['activo'] == 0 || $producto['stock'] == 0 || $producto['categoria_activa'] == 0) { 
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $producto['nombre'],
            'producto' => $producto,
        ];

        return view('admin/productos/detalle', $data); 
    }

    /**
     * Devuelve sugerencias de búsqueda en formato JSON.
     * Busca en nombres de productos, marcas y nombres de categorías activas.
     * Ahora utiliza la lógica de procesamiento de términos para sinónimos y palabras individuales.
     */
    public function getSuggestions()
    {
        $term = $this->request->getGet('term'); 
        $suggestions = [];

        if (!empty($term)) {
            $processedSearchTerms = $this->_getProcessedSearchTerms($term);

            // Sugerencias de Nombres de Productos y Marcas
            $productosQuery = $this->productoModel
                                   ->select('nombre, marca, id_producto')
                                   ->where('productos.activo', 1)
                                   ->where('productos.stock >', 0);
            
            $productosQuery->groupStart();
            foreach ($processedSearchTerms as $termToSearch) {
                $productosQuery->orLike('nombre', $termToSearch, 'both', null, true);
                $productosQuery->orLike('marca', $termToSearch, 'both', null, true);
            }
            $productosQuery->groupEnd();
            $productos = $productosQuery->limit(5)->findAll();

            foreach ($productos as $producto) {
                // Añadir sugerencia de producto por nombre
                $suggestions[] = [
                    'value' => $producto['nombre'],
                    'label' => $producto['nombre'] . ' (Producto)',
                    'type'  => 'product',
                    'id'    => $producto['id_producto'],
                ];
                // Añadir sugerencia de marca si es relevante y no es el mismo que el nombre
                if (!empty($producto['marca']) && strtolower($producto['marca']) !== strtolower($producto['nombre'])) {
                     $suggestions[] = [
                        'value' => $producto['marca'],
                        'label' => $producto['marca'] . ' (Marca)',
                        'type'  => 'brand',
                        'id'    => null,
                    ];
                }
            }
            
            // Sugerencias de Categorías Activas
            $categoriasQuery = $this->categoriaModel
                                   ->select('id_categoria, nombre')
                                   ->where('activo', 1);

            $categoriasQuery->groupStart();
            foreach ($processedSearchTerms as $termToSearch) {
                $categoriasQuery->orLike('nombre', $termToSearch, 'both', null, true);
            }
            $categoriasQuery->groupEnd();
            $categorias = $categoriasQuery->limit(5)->findAll();

            foreach ($categorias as $categoria) {
                $suggestions[] = [
                    'value' => $categoria['nombre'],
                    'label' => $categoria['nombre'] . ' (Categoría)',
                    'type'  => 'category',
                    'id'    => $categoria['id_categoria'],
                ];
            }

            // Eliminar duplicados de sugerencias y ordenar
            $uniqueSuggestions = [];
            $seenValues = [];
            foreach ($suggestions as $sug) {
                $uniqueKey = strtolower($sug['label'] . '|' . $sug['type']);
                if (!in_array($uniqueKey, $seenValues)) {
                    $uniqueSuggestions[] = $sug;
                    $seenValues[] = $uniqueKey;
                }
            }
            $suggestions = $uniqueSuggestions;

            // Ordenar sugerencias por tipo o relevancia (opcional)
            usort($suggestions, function($a, $b) {
                $order = ['category' => 1, 'brand' => 2, 'product' => 3]; // Prioridad: categorías > marcas > productos
                if ($order[$a['type']] === $order[$b['type']]) {
                    return strcmp($a['label'], $b['label']); // Orden alfabético si son del mismo tipo
                }
                return $order[$a['type']] <=> $order[$b['type']];
            });
        }

        return $this->response->setJSON($suggestions);
    }
}