<?php 
namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function register()
    {
        $model = new UsuarioModel();

        $rules = [
            'nombre' => 'required|min_length[3]|max_length[255]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'password' => 'required|min_length[3]|max_length[255]',
            'confirm_password' => 'matches[password]'
        ];

        if ($this->validate($rules)) {
            $model->save([
                'nombre' => $this->request->getPost('nombre'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'rol' => 'cliente', // Por defecto, los nuevos registros son 'clientes'
                'activo' => 1 // Activo por defecto
            ]);
            return redirect()->to(base_url('principal'))->with('success', 'Registro exitoso. ¡Ahora puedes iniciar sesión!');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function login()
    {
        $model = new UsuarioModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $session = session();
            $session->set([
                'id_usuario' => $user['id_usuario'],
                'nombre' => $user['nombre'],
                'email' => $user['email'],
                'rol' => $user['rol'],
                'isLoggedIn' => true,
            ]);
            return redirect()->to(base_url('principal'))->with('success', '¡Bienvenido de nuevo!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Correo electrónico o contraseña incorrectos.');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('principal'))->with('success', 'Has cerrado sesión correctamente.');
    }

}