<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UsuarioController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UserModel();    
        helper(['form', 'url']);
    }

    public function listar()
    {    
        $busqueda = $this->request->getGet('busqueda');
        $orden = $this->request->getGet('orden') ?? 'asc';
        $orden_apellido = $this->request->getGet('orden_apellido') ?? 'asc';    

        $orden = ($orden === 'desc') ? 'desc' : 'asc';
        $orden_apellido = ($orden_apellido === 'desc') ? 'desc' : 'asc';

        $query = $this->usuarioModel;

        if (!empty($busqueda)) {
            $query = $query->groupStart()
                ->like('nombre', $busqueda)
                ->orLike('apellido', $busqueda)
                ->orLike('email', $busqueda)
                ->groupEnd();
        }

        $data['usuarios'] = $query->where('activo', 1)->orderBy('apellido', $orden_apellido)->findAll();

        $queryInactivos = $this->usuarioModel;

        if (!empty($busqueda)) {
            $queryInactivos = $queryInactivos->groupStart()
                ->like('nombre', $busqueda)
                ->orLike('apellido', $busqueda)
                ->orLike('email', $busqueda)
                ->groupEnd();
        }

        $data['usuariosInactivos'] = $queryInactivos->where('activo', 0)->orderBy('apellido', $orden_apellido)->findAll();

        // Valores para la vista
        $data['busqueda'] = $busqueda;
        $data['orden'] = $orden;
        $data['orden_apellido'] = $orden_apellido; // Pasar el nuevo orden a la vista

        return view('admin/usuarios/listar', $data);
    }



    public function editar($id_usuario = null)
    {
        if ($id_usuario === null) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'ID de usuario no proporcionado.');
        }

        $usuario = $this->usuarioModel->find($id_usuario);

        if (!$usuario) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'El usuario no existe.');
        }

        $data['usuario'] = $usuario;
        $data['roles_posibles'] = ['admin', 'cliente'];

        // --- INICIO: Lógica para deshabilitar campos en la vista ---
        $disableFieldsForAdmin = false;
        $loggedInUserId = session()->get('id');
        $loggedInUserRole = session()->get('rol');

        // Si el usuario logueado es admin, el usuario a editar es admin, Y NO es el mismo usuario
        if ($loggedInUserRole === 'admin' && $usuario['rol'] === 'admin' && (string)$id_usuario !== (string)$loggedInUserId) {
            $disableFieldsForAdmin = true;
        }
        $data['disableFieldsForAdmin'] = $disableFieldsForAdmin;
        // --- FIN: Lógica para deshabilitar campos en la vista ---

        return view('admin/usuarios/editar', $data);
    }

    public function guardar()
    {
        $id_usuario = $this->request->getPost('id_usuario');

        // Obtener las reglas de validación del modelo usando la nueva función
        $rules = $this->usuarioModel->getValidationRulesForUser($id_usuario);
        // Los mensajes de validación se obtienen directamente de la propiedad del modelo
        $messages = $this->usuarioModel->getValidationMessages(); 

        // Ajustar la regla de contraseña para edición (permit_empty si no se cambia)
        if (!empty($id_usuario)) {
            $rules['password'] = 'permit_empty|min_length[8]';
            // Para la edición, si no se proporciona una contraseña nueva, no necesitamos validar confirm_password
            unset($rules['confirm_password']); 
        } else {
            // Para creación (nuevo usuario), la contraseña es obligatoria y se requiere confirmación
            $rules['password'] = 'required|min_length[8]';
            // Añadir la regla para confirmar la contraseña solo en la creación
            $rules['confirm_password'] = 'required|matches[password]';
        }

        // --- Agregar mensajes de validación para 'confirm_password' si no están ya en el modelo ---
        // (Asegúrate de que estos mensajes estén en tu UserModel::validationMessages)
        // Por si acaso, los agregamos aquí si no estuvieran ya en el modelo, aunque lo ideal es que estén centralizados
        if (!isset($messages['confirm_password'])) {
            $messages['confirm_password'] = [
                'required' => 'La confirmación de contraseña es obligatoria.',
                'matches'  => 'Las contraseñas no coinciden.',
            ];
        }


        // Realizar la validación del formulario
        if (!$this->validate($rules, $messages)) {
            log_message('debug', 'Errores de validación: ' . json_encode($this->validator->getErrors()));
            // Si la validación falla, redirigir al formulario con los errores
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // --- Lógica de restricción: Un admin no puede cambiar el rol, ni otros campos de otro admin ---
        if ($id_usuario) { // Solo aplica si estamos editando un usuario existente
            $loggedInUserId = session()->get('id'); // ID del admin que está realizando la acción
            $loggedInUserRole = session()->get('rol'); // Rol del admin que está realizando la acción
            
            $originalUser = $this->usuarioModel->find($id_usuario); // Datos originales del usuario que se edita

            // Si el usuario logueado es un admin, el usuario a editar es un admin, Y NO es el mismo usuario
            if ($originalUser && $loggedInUserRole === 'admin' && $originalUser['rol'] === 'admin' && (string)$id_usuario !== (string)$loggedInUserId) {
                
                $hasChangedRestrictedField = false;
                // Campos de texto y select para verificar cambios
                $restrictedFields = ['nombre', 'apellido', 'email', 'rol']; 
                
                // Verificación de campos de texto/select
                foreach ($restrictedFields as $field) {
                    $postedValue = $this->request->getPost($field);
                    $originalValue = $originalUser[$field];

                    if ($postedValue !== $originalValue) {
                        $hasChangedRestrictedField = true;
                        break; // Salir del bucle si se detecta un cambio
                    }
                }

                // Verificación de Contraseña (si se ha introducido algo)
                $newPassword = $this->request->getPost('password');
                if (!empty($newPassword)) { 
                    $hasChangedRestrictedField = true;
                }

                // Verificación de Estado Activo/Inactivo
                $postedActivo = ($this->request->getPost('activo') === '1') ? 1 : 0;
                $originalActivo = ($originalUser['activo'] == 1) ? 1 : 0;

                if ($postedActivo !== $originalActivo) {
                    $hasChangedRestrictedField = true;
                }

                if ($hasChangedRestrictedField) {
                    session()->setFlashdata('error', 'Un administrador no puede editar el nombre, apellido, correo, contraseña, rol o estado activo/inactivo de otro administrador.');
                    return redirect()->back()->withInput();
                }
            }
        }
        // --- FIN: Lógica de restricción ---

        // Preparar los datos para guardar
        $data = [
            'nombre'    => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email'    => $this->request->getPost('email'),
            'rol'      => $this->request->getPost('rol'),
            'activo'   => $this->request->getPost('activo') ?? 0,
        ];

        // Hashear la contraseña si se proporciona
        // NOTA: Si confirm_password no se valida aquí, y solo password se usa para hashear,
        // esto es correcto. La validación ya se hizo antes.
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $result = false;
        $message = '';
        $redirectUrl = base_url('admin/usuarios');

        try {
            if ($id_usuario) {
                // Actualizar usuario existente
                $result = $this->usuarioModel->update($id_usuario, $data);
                $message = 'Usuario actualizado correctamente.';
            } else {
                // Insertar nuevo usuario
                $result = $this->usuarioModel->insert($data);
                $message = 'Usuario creado correctamente.';
            }
            log_message('debug', 'Resultado de la operación de base de datos (insert/update): ' . ($result ? 'Éxito' : 'Fallo'));

        } catch (\ReflectionException $e) { 
            log_message('error', 'Excepción al guardar/actualizar usuario: ' . $e->getMessage());
            $result = false;
            $message = 'Error interno al procesar la solicitud: ' . $e->getMessage();
        }

        // Verificar si la operación fue exitosa
        if ($result) {
            return redirect()->to($redirectUrl)->with('success', $message);
        } else {
            $modelErrors = $this->usuarioModel->errors();
            $errorMessage = 'No se pudo completar la operación.';

            if (!empty($modelErrors)) {
                $errorMessage .= ' Detalles: ' . implode(', ', $modelErrors);
            } else {
                $errorMessage .= ' Posible error interno o de base de datos desconocido.';
            }
            log_message('error', 'Fallo al guardar/actualizar usuario: ' . $errorMessage);
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }
    }

    public function desactivar($id_usuario = null)
    {
        $loggedInUserId = session()->get('id');
        $loggedInUserRole = session()->get('rol');

        if ($id_usuario === null) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'ID de usuario no proporcionado.');
        }

        $targetUser = $this->usuarioModel->find($id_usuario);

        if (!$targetUser) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'Usuario no válido.');
        }

        // --- INICIO: Lógica de restricción para desactivar admin ---
        // Si el usuario logueado es admin, el usuario objetivo es admin, Y NO es el mismo usuario
        if ($loggedInUserRole === 'admin' && $targetUser['rol'] === 'admin' && (string)$id_usuario !== (string)$loggedInUserId) {
            session()->setFlashdata('error', 'Un administrador no puede desactivar a otro administrador.');
            return redirect()->to(base_url('admin/usuarios'));
        }
        // --- FIN: Lógica de restricción para desactivar admin ---

        $this->usuarioModel->update($id_usuario, ['activo' => 0]);
        return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario desactivado correctamente.');
    }

    public function activar($id_usuario = null)
    {
        $loggedInUserId = session()->get('id');
        $loggedInUserRole = session()->get('rol');

        if ($id_usuario === null) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'ID de usuario no proporcionado.');
        }

        $targetUser = $this->usuarioModel->find($id_usuario);

        if (!$targetUser) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'Usuario no válido.');
        }

        // --- INICIO: Lógica de restricción para activar admin ---
        // Si el usuario logueado es admin, el usuario objetivo es admin, Y NO es el mismo usuario
        // Esta restricción es menos común para "activar", pero la incluimos por consistencia en la política.
        if ($loggedInUserRole === 'admin' && $targetUser['rol'] === 'admin' && (string)$id_usuario !== (string)$loggedInUserId) {
            session()->setFlashdata('error', 'Un administrador no puede activar/desactivar a otro administrador.'); // Mensaje más genérico
            return redirect()->to(base_url('admin/usuarios'));
        }
        // --- FIN: Lógica de restricción para activar admin ---

        $this->usuarioModel->update($id_usuario, ['activo' => 1]);
        return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario activado correctamente.');
    }

    public function crear()
    {
        $data['roles_posibles'] = ['admin', 'cliente'];    
        return view('admin/usuarios/crear', $data);
    }
}