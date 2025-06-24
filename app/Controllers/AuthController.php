<?php
namespace App\Controllers;
use App\Models\UserModel;

class AuthController extends BaseController {

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form']); 
    }

    public function loginView() {
        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function register()
    {
    

        // ✅ Usar las reglas de validación definidas en el UserModel
        $rules = [
            'nombre'           => 'required|alpha_space|min_length[3]|max_length[255]',
            'apellido'         => 'required|alpha_space|min_length[3]|max_length[255]',
            // Aquí en AuthController, la regla is_unique no necesita {id_usuario}
            // porque siempre es para un nuevo registro.
            'email'            => 'required|valid_email|is_unique[usuarios.email]',
            'password'         => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
        ];

        // ✅ Usar los mensajes de validación definidos en el UserModel
        // y añadir los específicos para AuthController si los hay (ej. confirm_password)
        $messages = $this->userModel->getValidationMessages(); // Obtener los mensajes base del modelo

        // Añadir mensajes específicos para el campo 'confirm_password' aquí si no están en el modelo
        $messages['confirm_password'] = [
            'required' => 'La confirmación de contraseña es obligatoria.',
            'matches'  => 'Las contraseñas no coinciden.',
        ];

        // Realizar la validación
        if (!$this->validate($rules, $messages)) {
            // Si la validación falla, redirigir al formulario con los errores detallados
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'nombre'    => $this->request->getPost('nombre'),
            'apellido'  => $this->request->getPost('apellido'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol'       => 'cliente', // Por defecto 'cliente'
            'activo'    => 1,
        ];

        // ✅ Manejar el resultado de la inserción
        $insertedId = $this->userModel->insert($userData);

        if ($insertedId) {
            // La inserción fue exitosa, ahora podemos buscar al usuario
            $user = $this->userModel->find($insertedId); // Buscar por ID para asegurar que es el usuario recién creado

            if ($user) {
                // Autologin tras registro
                session()->set([
                    'id'        => $user['id_usuario'],
                    'rol'       => $user['rol'],
                    'email'     => $user['email'],
                    'nombre'    => $user['nombre'],
                    'apellido'  => $user['apellido'],
                    'isLoggedIn'=> true
                ]);

                return redirect()->to('/')->with('success', '¡Registro exitoso! Bienvenido/a, ' . esc($user['nombre']) . '.');
            } else {
                // Esto es un caso raro, si se insertó pero no se encontró.
                // Podría indicar un problema con la PK o la búsqueda.
                log_message('error', 'Auth Controller: Usuario con ID ' . $insertedId . ' no encontrado después de la inserción.');
                return redirect()->to('/register')->with('error', 'Hubo un problema al iniciar sesión automáticamente. Por favor, intenta iniciar sesión manualmente.');
            }
        } else {
            // La inserción falló
            $errors = $this->userModel->errors(); // Obtener errores del modelo si los hay
            $errorMessage = 'No se pudo completar el registro del usuario.';
            if (!empty($errors)) {
                $errorMessage .= ' Detalles: ' . implode(', ', $errors);
                log_message('error', 'Auth Controller: Errores del modelo al insertar usuario: ' . json_encode($errors));
            } else {
                // Caso donde insert() devuelve false pero no hay errores explícitos del modelo (ej. problema de DB)
                $errorMessage .= ' Posible error interno o de base de datos desconocido.';
                log_message('error', 'Auth Controller: Fallo de inserción sin errores explícitos del modelo.');
            }
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }
    }

    public function doLogin()
    {
        // ... (Tu código existente para doLogin no necesita cambios para este problema) ...
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Credenciales inválidas');
        }

        if ($user['activo'] == 0) {
            session()->setFlashdata('error', 'Tu cuenta está inactiva. Por favor, contacta al administrador.');
            return redirect()->back()->withInput();
        }

        session()->set([
            'id'         => $user['id_usuario'],
            'email'      => $user['email'],
            'rol'        => $user['rol'],
            'nombre'     => $user['nombre'],
            'apellido'   => $user['apellido'],
            'isLoggedIn' => true
        ]);
            
        if ($user['rol'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        return redirect()->to('/principal');
    }

    public function registroView()
    {
        return view('auth/registro');
    }

    public function miCuenta()
    {
        $id_usuario = session()->get('id');

        if (!$id_usuario) {
            session()->setFlashdata('error', 'Debes iniciar sesión para acceder a tu cuenta.');
            return redirect()->to(base_url('login'));
        }

        $usuario = $this->userModel->find($id_usuario);

        if (!$usuario) {
            session()->destroy();
            return redirect()->to(base_url('login'))->with('error', 'Tu cuenta no fue encontrada. Por favor, inicia sesión de nuevo.');
        }

        $data['titulo'] = 'Mi Cuenta';
        $data['usuario'] = $usuario;

        return view('auth/mi_cuenta', $data);
    }

    public function actualizarPerfil()
    {
        $id_usuario = session()->get('id');

        if (!$id_usuario) {
            return redirect()->to(base_url('login'));
        }

        $user = $this->userModel->find($id_usuario);
        if (!$user) {
            session()->destroy();
            return redirect()->to(base_url('login'))->with('error', 'Tu cuenta no fue encontrada. Por favor, inicia sesión de nuevo.');
        }

        $currentEmail = $user['email'];

        $newEmail = $this->request->getPost('email');
        $newPassword = $this->request->getPost('password');
        $confirmNewPassword = $this->request->getPost('confirm_password');
        $currentPasswordForEmailChange = $this->request->getPost('email_current_password');

        $rules = [];
        $data_to_update = [];
        $isEmailChanged = false;
        $isPasswordChanged = false;

        // Reglas y mensajes de validación para el formulario de perfil
        $validationMessages = [ // Reutilizamos los mensajes del modelo y añadimos los específicos de esta vista
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Por favor, introduce un correo electrónico válido (ej. usuario@dominio.com).',
                'is_unique'   => 'Este correo electrónico ya está registrado. Por favor, usa otro.',
            ],
            'password' => [
                'required'   => 'La contraseña es obligatoria.',
                'min_length' => 'La contraseña debe tener al menos 8 caracteres.',
            ],
            'confirm_password' => [
                'required' => 'La confirmación de contraseña es obligatoria.',
                'matches'  => 'Las contraseñas no coinciden.',
            ],
            'email_current_password' => [
                'required' => 'Debes ingresar tu contraseña actual para cambiar el correo electrónico.',
            ],
        ];

        if ($newEmail !== $currentEmail) {
            $isEmailChanged = true;
            $rules['email'] = 'required|valid_email|is_unique[usuarios.email,id_usuario,' . $id_usuario . ']';
            $rules['email_current_password'] = 'required';
            $data_to_update['email'] = $newEmail;
        } else {
             // Es importante limpiar este campo para que no se valide si el email no cambió
             $this->request->setGlobal('request', array_merge($this->request->getPost(), ['email_current_password' => '']));
        }

        if (!empty($newPassword)) {
            $isPasswordChanged = true;
            $rules['password'] = 'required|min_length[8]'; // Cambiado a 8 para consistencia con UserModel
            $rules['confirm_password'] = 'required|matches[password]';
            $data_to_update['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        if (!$isEmailChanged && !$isPasswordChanged) {
            return redirect()->to(base_url('mi-cuenta'))->with('info', 'No se detectaron cambios para guardar.');
        }

        if (!$this->validate($rules, $validationMessages)) { // Pasamos los mensajes de validación
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($isEmailChanged) {
            if (!password_verify($currentPasswordForEmailChange, $user['password'])) {
                return redirect()->back()->withInput()->with('error', 'La contraseña actual ingresada para cambiar el correo es incorrecta.');
            }
        }

        if ($this->userModel->update($id_usuario, $data_to_update)) {
            if ($isEmailChanged) {
                session()->set('email', $newEmail);
            }
            return redirect()->to(base_url('mi-cuenta'))->with('success', 'Tus datos de acceso han sido actualizados exitosamente.');
        } else {
             $modelErrors = $this->userModel->errors();
             $errorMessage = 'No se pudo actualizar tu perfil.';
             if (!empty($modelErrors)) {
                 $errorMessage .= ' Detalles: ' . implode(', ', $modelErrors);
             }
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }
    }
}