<?php

namespace App\Controllers;

use App\Models\UsuariosModel;

class LoginController extends BaseController
{
    // Mostrar pantalla de Login
    public function index()
    {
        return view('Vistas_Comunes/login');
    }

    // Validar credenciales de acceso
    public function validar()
    {
        $nombreUsuario = $this->request->getPost('nombre_usuario');
        $claveUsuario  = $this->request->getPost('password');

        $userModel = new UsuariosModel();
        $usuario = $userModel->where('nombre_usuario', $nombreUsuario)->first();

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

        // Crear datos de sesión
        session()->set([
            'id_usuario'       => $usuario['id_usuario'],
            'nombre_usuario'   => $usuario['nombre_usuario'],
            'apellido_usuario' => $usuario['apellido_usuario'],
            'logueado'         => true
        ]);

        return redirect()->to('/')->with('toast_success', '¡Bienvenido/a de nuevo, ' . $usuario['nombre_usuario'] . '! Has iniciado sesión con éxito.');
    }

    // Cerrar sesión
    public function logout()
    {
        session()->remove(['id_usuario', 'nombre_usuario', 'apellido_usuario', 'logueado']);

        return redirect()->to('/')->with('toast_warning', 'Has cerrado tu sesión de forma segura. ¡Esperamos verte pronto!');
    }
}
