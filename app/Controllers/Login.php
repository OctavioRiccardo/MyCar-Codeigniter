<?php

namespace App\Controllers;

use App\Models\UsuariosModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    // ============================
    // Validar Login
    // ============================
    public function validar()
    {
        $nombreUsuario = $this->request->getPost('nombre_usuario');
        $claveUsuario  = $this->request->getPost('password');

        $userModel = new UsuariosModel();

        $usuario = $userModel
            ->where('nombre_usuario', $nombreUsuario)
            ->first();

        // Verificar usuario
        if (!$usuario) {

            return redirect()->back()
                ->withInput()
                ->with('error_login', 'El usuario no existe.');
        }

        // Verificar contraseña
        if (!password_verify($claveUsuario, $usuario['password'])) {

            return redirect()->back()
                ->withInput()
                ->with('error_login', 'Contraseña incorrecta.');
        }

        // ============================
        // Crear sesión
        // ============================
        session()->set([

            'id_usuario' => $usuario['id_usuario'],
            'nombre_usuario' => $usuario['nombre_usuario'],
            'apellido_usuario' => $usuario['apellido_usuario'],
            'logueado' => true

        ]);

        // Redirigir al inicio
        return redirect()->to('/');
    }

    // ============================
    // Logout
    // ============================
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }
}