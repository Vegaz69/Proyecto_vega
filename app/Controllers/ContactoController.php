<?php

namespace App\Controllers;

use App\Models\MensajeModel;
use CodeIgniter\API\ResponseTrait;

class ContactoController extends BaseController
{
    use ResponseTrait;

    protected $mensajeModel;

    public function __construct()
    {
        $this->mensajeModel = new MensajeModel();
        helper(['form']);
    }

    public function enviarConsulta()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->back()->with('error', 'Método no permitido.');
        }

        $rules = [
            'nombre_completo' => 'required|min_length[3]|max_length[100]',
            'email'           => 'required|valid_email|max_length[255]',
            'asunto'          => 'required|min_length[3]|max_length[255]',
            'mensaje'         => 'required|min_length[10]|max_length[1000]',
        ];

        $messages = [
            'nombre_completo' => [
                'required'   => 'El nombre completo es obligatorio.',
                'min_length' => 'El nombre completo debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre completo no puede exceder los 100 caracteres.',
            ],
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Debes ingresar un correo electrónico válido.',
                'max_length'  => 'El correo electrónico no puede exceder los 255 caracteres.',
            ],
            'asunto' => [
                'required'   => 'El asunto es obligatorio.',
                'min_length' => 'El asunto debe tener al menos 3 caracteres.',
                'max_length' => 'El asunto no puede exceder los 255 caracteres.',
            ],
            'mensaje' => [
                'required'   => 'El mensaje es obligatorio.',
                'min_length' => 'El mensaje debe tener al menos 10 caracteres.',
                'max_length' => 'El mensaje no puede exceder los 1000 caracteres.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_usuario'      => null,
            'nombre_completo' => $this->request->getPost('nombre_completo'),
            'email'           => $this->request->getPost('email'),
            'telefono'        => null, // <-- Aseguramos que sea NULL para contactos si no se recoge
            'asunto'          => $this->request->getPost('asunto'),
            'mensaje'         => $this->request->getPost('mensaje'),
            'fecha_envio'     => date('Y-m-d H:i:s'),
            'leido'           => 0,
            'tipo_mensaje'    => 'contacto',
        ];

        if ($this->mensajeModel->insert($data)) {
            return redirect()->back()->with('success', '¡Tu consulta ha sido enviada con éxito! Nos pondremos en contacto contigo pronto.');
        } else {
            $modelErrors = $this->mensajeModel->errors();
            $errorMessage = 'No se pudo enviar tu consulta. Por favor, intenta de nuevo más tarde.';
            if (!empty($modelErrors)) {
                $errorMessage .= ' Detalles: ' . implode(', ', $modelErrors);
            }
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }
    }
}