<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class UsuarioController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [];
        $data['usuarios'] = $this->usuarioModel->where('activo', 1)->findAll();
        $data['usuariosInactivos'] = $this->usuarioModel->where('activo', 0)->findAll();
        return view('usuarios/listar', $data);
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
        // <-- CAMBIO CLAVE AQUÍ: Los roles posibles deben ser los valores exactos del ENUM
        $data['roles_posibles'] = ['admin', 'cliente']; // <-- CAMBIO: 'admin' y 'cliente'

        return view('usuarios/editar', $data);
    }

    public function guardar()
    {
        $id_usuario = $this->request->getPost('id_usuario');

        $rules = $this->usuarioModel->getValidationRules();
        $messages = $this->usuarioModel->getValidationMessages();

        if (!empty($id_usuario)) {
            $rules['password'] = 'permit_empty|min_length[8]';
            $rules['email'] = 'required|valid_email|is_unique[usuarios.email,id_usuario,' . $id_usuario . ']';
        } else {
            $rules['password'] = 'required|min_length[8]';
            $rules['email'] = 'required|valid_email|is_unique[usuarios.email]';
        }

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'rol' => $this->request->getPost('rol'),
            'activo' => $this->request->getPost('activo') ?? 0,
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        }

        if ($id_usuario) {
            $this->usuarioModel->update($id_usuario, $data);
            return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario actualizado correctamente.');
        } else {
            $this->usuarioModel->insert($data);
            return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario creado correctamente.');
        }
    }

    public function desactivar($id_usuario = null)
    {
        if ($id_usuario === null) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'ID de usuario no proporcionado para desactivar.');
        }
        if (!$this->usuarioModel->find($id_usuario)) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'El usuario no existe.');
        }
        $this->usuarioModel->update($id_usuario, ['activo' => 0]);
        return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario desactivado correctamente.');
    }

    public function activar($id_usuario = null)
    {
        if ($id_usuario === null) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'ID de usuario no proporcionado para activar.');
        }
        if (!$this->usuarioModel->find($id_usuario)) {
            return redirect()->to(base_url('admin/usuarios'))->with('error', 'El usuario no existe.');
        }
        $this->usuarioModel->update($id_usuario, ['activo' => 1]);
        return redirect()->to(base_url('admin/usuarios'))->with('success', 'Usuario activado correctamente.');
    }
}