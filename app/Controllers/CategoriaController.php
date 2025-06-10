<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use CodeIgniter\Controller; // Usar la clase base de controlador

class CategoriaController extends BaseController // Se extiende de BaseController por defecto en CI4
{
    // Constructor para cargar modelos si es necesario
    public function __construct()
    {
        // Puedes cargar helpers aquí si los necesitas en varios métodos,
        // por ejemplo, helper(['form', 'url']);
    }

    // -----------------------------------------------------------
    // Métodos para la Gestión del Administrador de Categorías (CRUD)
    // -----------------------------------------------------------

    // Muestra la lista de categorías (Panel de Administración)
    public function index()
    {
        $categoriaModel = new CategoriaModel();

        // Obtener categorías activas con paginación (si quieres)
        $data['categorias'] = $categoriaModel->where('activo', 1)->findAll(); // O paginate(10); si quieres paginación

        // Obtener categorías desactivadas (eliminadas lógicamente)
        $data['categoriasEliminadas'] = $categoriaModel->where('activo', 0)->findAll();

        // Si usas paginación para las activas, también pasa el pager:
        // $data['pager'] = $categoriaModel->pager; 

        // Retornar la vista del listado de categorías para el administrador
        return view('/categorias/listar', $data);
    }

    // Muestra el formulario para crear una nueva categoría
    public function crear()
    {
        // Simplemente carga la vista del formulario vacío
        return view('/categorias/crear');
    }

    // Guarda una nueva categoría en la base de datos (o actualiza una existente)
    public function guardar()
    {
        $categoriaModel = new CategoriaModel();

        $id = $this->request->getPost('id_categoria');

        // Reglas de validación
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[100]'
        ];

        // Mensajes de error personalizados
        $messages = [
            'nombre' => [
                'required'   => 'El nombre de la categoría es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no debe exceder los 100 caracteres.',
                'is_unique'  => 'Ya existe una categoría con este nombre.'
            ],
        ];

            if (!empty($id)) {
                // Si estamos EDITANDO, la regla debe excluir el propio ID del registro actual
                // Aquí pasamos el valor real de $id, no el placeholder {id_categoria}
                $rules['nombre'] .= '|is_unique[categorias.nombre,id_categoria,' . $id . ']';
                } else {
                // Si estamos CREANDO una nueva categoría, simplemente comprobamos la unicidad
                $rules['nombre'] .= '|is_unique[categorias.nombre]';
    }

        // Validar la solicitud
        if (!$this->validate($rules, $messages)) {
            // Si la validación falla, redirigir de vuelta al formulario con los errores
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Preparar los datos para guardar
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'activo' => 1 
        ];


        if ($id) {
            // Si hay un ID, es una actualización
            $categoriaModel->update($id, $data);
            return redirect()->to(base_url('admin/categorias'))->with('success', 'Categoría actualizada correctamente.');
        } else {
            // Si no hay ID, es una nueva categoría
            $categoriaModel->insert($data);
            return redirect()->to(base_url('admin/categorias'))->with('success', 'Categoría creada correctamente.');
        }
    }

    // Muestra el formulario para editar una categoría existente
    public function editar($id)
    {
        $categoriaModel = new CategoriaModel();
        $categoria = $categoriaModel->find($id);

        if (!$categoria) {
            return redirect()->to(base_url('admin/categorias'))->with('error', 'La categoría no existe.');
        }

        $data['categoria'] = $categoria;
        return view('/categorias/editar', $data);
    }

    // Elimina una categoría (¡Eliminación física!)
    // Opcional: Podrías cambiarlo a eliminación lógica (marcar 'activo' a 0 si tuvieras ese campo)
    // Elimina una categoría (¡Ahora es eliminación Lógica!)
    public function eliminar($id)
    {
        $categoriaModel = new CategoriaModel();

        // Verifica si la categoría existe antes de intentar eliminar
        if (!$categoriaModel->find($id)) {
            return redirect()->to(base_url('admin/categorias'))->with('error', 'La categoría no existe.');
        }

        // Marcar la categoría como inactiva (eliminación lógica)
        $categoriaModel->update($id, ['activo' => 0]);

        return redirect()->to(base_url('admin/categorias'))->with('success', 'Categoría eliminada (desactivada) correctamente.');
    }


        // Nuevo método para restaurar una categoría
    public function restaurar($id)
    {
        $categoriaModel = new CategoriaModel();

        // Verifica si la categoría existe antes de intentar restaurar
        if (!$categoriaModel->find($id)) {
            return redirect()->to(base_url('admin/categorias'))->with('error', 'La categoría no existe.');
        }

        // Marcar la categoría como activa (restaurar)
        $categoriaModel->update($id, ['activo' => 1]);

        return redirect()->to(base_url('admin/categorias'))->with('success', 'Categoría restaurada correctamente.');
    }

}


