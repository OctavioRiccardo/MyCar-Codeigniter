<?php

namespace App\Controllers;

use App\Models\UsuariosModel;

class LoginController extends BaseController
{
    // Mostrar formulario de login
    public function index()
    {
        return view('Vistas_Comunes/login');
    }

    // Procesar inicio de sesión
    public function validar()
    {
        $nombreUsuario = $this->request->getPost('nombre_usuario');
        $claveUsuario  = $this->request->getPost('password');

        $userModel = new UsuariosModel();

        $usuario = $userModel
            ->where('nombre_usuario', $nombreUsuario)
            ->first();

        if (!$usuario) {
            return redirect()->back()
                ->withInput()
                ->with('error_login', 'El usuario no existe.');
        }

        if (!password_verify($claveUsuario, $usuario['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error_login', 'Contraseña incorrecta.');
        }

        session()->set([
            'id_usuario'       => $usuario['id_usuario'],
            'nombre_usuario'   => $usuario['nombre_usuario'],
            'apellido_usuario' => $usuario['apellido_usuario'],
            'rol'              => $usuario['rol'],
            'logueado'         => true
        ]);

        if ($usuario['rol'] == 'administrador') {
            return redirect()->to('/administrador')
                ->with('toast_success', 'Bienvenido administrador ' . $usuario['nombre_usuario']);
        }

        return redirect()->to('/')
            ->with('toast_success', '¡Bienvenido/a de nuevo, ' . $usuario['nombre_usuario'] . '! Has iniciado sesión con éxito.');
    }

    // Cerrar sesión
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/')
            ->with('toast_warning', 'Has cerrado tu sesión de forma segura.');
    }
}