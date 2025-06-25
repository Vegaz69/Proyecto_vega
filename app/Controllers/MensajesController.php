<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MensajeModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class MensajesController extends BaseController
{
    use ResponseTrait;

    protected $mensajeModel;
    protected $userModel;

    public function __construct()
    {
        $this->mensajeModel = new MensajeModel();
        $this->userModel = new UserModel();
        helper(['form']);
    }

    public function enviarMensaje()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->back()->with('error', 'Método no permitido.');
        }

        $rules = [
            'subject' => 'required|min_length[3]|max_length[255]',
            'message' => 'required|min_length[10]|max_length[1000]',
        ];

        $messages = [
            'subject' => [
                'required'   => 'El asunto es obligatorio.',
                'min_length' => 'El asunto debe tener al menos 3 caracteres.',
                'max_length' => 'El asunto no puede exceder los 255 caracteres.',
            ],
            'message' => [
                'required'   => 'El mensaje es obligatorio.',
                'min_length' => 'El mensaje debe tener al menos 10 caracteres.',
                'max_length' => 'El mensaje no puede exceder los 1000 caracteres.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $idUsuario = session()->get('id');
        $usuario = $this->userModel->find($idUsuario);

        if (!$usuario) {
            return redirect()->back()
                             ->with('error', 'No se pudieron obtener los datos de usuario para enviar el mensaje.');
        }

        $data = [
            'id_usuario'      => $idUsuario,
            'nombre_completo' => $usuario['nombre'] . ' ' . ($usuario['apellido'] ?? ''),
            'email'           => $usuario['email'],
            'telefono'        => $usuario['telefono'] ?? null,
            'asunto'          => $this->request->getPost('subject'),
            'mensaje'         => $this->request->getPost('message'),
            'fecha_envio'     => date('Y-m-d H:i:s'),
            'leido'           => 0,
            'tipo_mensaje'    => 'cliente',
        ];

        if ($this->mensajeModel->insert($data)) {
            return redirect()->back()
                             ->with('success', '¡Mensaje enviado con éxito! Un administrador se pondrá en contacto pronto.');
        } else {
            $modelErrors = $this->mensajeModel->errors();
            $errorMessage = 'No se pudo enviar el mensaje. Intenta de nuevo más tarde.';

            if (!empty($modelErrors)) {
                $errorMessage .= ' Detalles: ' . implode(', ', $modelErrors);
            }

            return redirect()->back()
                             ->withInput()
                             ->with('error', $errorMessage);
        }
    }
}
