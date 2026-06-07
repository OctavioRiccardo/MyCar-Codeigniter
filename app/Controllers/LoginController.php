<?php

namespace App\Controllers;

use App\Models\UsuariosModel;

/**
 * Controlador de Autenticación (Login / Logout).
 * Administra el inicio de sesión, la verificación de credenciales cifradas y la destrucción de la sesión.
 */
class LoginController extends BaseController
{
    /**
     * Muestra la pantalla del formulario de inicio de sesión.
     * 
     * @return string
     */
    public function index()
    {
        return view('Vistas_Comunes/login');
    }

    /**
     * Procesa y valida las credenciales enviadas por método POST en el formulario de login.
     * Si las credenciales coinciden, genera las variables de sesión del usuario.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function validar()
    {
        // Obtener datos enviados desde el formulario
        $nombreUsuario = $this->request->getPost('nombre_usuario');
        $claveUsuario  = $this->request->getPost('password');

        $userModel = new UsuariosModel();

        // Buscar el usuario por su nombre de usuario único en la base de datos
        $usuario = $userModel
            ->where('nombre_usuario', $nombreUsuario)
            ->first();

        // Si no se encuentra el usuario, retornar con un error
        if (!$usuario) {
            return redirect()->back()
                ->withInput()
                ->with('error_login', 'El usuario no existe.');
        }

        // Verificar si la contraseña en texto plano coincide con el hash cifrado de la base de datos
        if (!password_verify($claveUsuario, $usuario['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error_login', 'Contraseña incorrecta.');
        }

        // Registrar datos esenciales de sesión en la sesión activa del servidor
        session()->set([
            'id_usuario'       => $usuario['id_usuario'],
            'nombre_usuario'   => $usuario['nombre_usuario'],
            'apellido_usuario' => $usuario['apellido_usuario'],
            'rol'              => $usuario['rol'],
            'logueado'         => true
        ]);

        // Redirigir al panel correspondiente según el rol del usuario
        if ($usuario['rol'] == 'administrador') {
            return redirect()->to('/administrador')
                ->with(
                    'toast_success',
                    'Bienvenido administrador ' . $usuario['nombre_usuario']
                );
        }

        // Redirección para clientes normales de vuelta a la página principal
        return redirect()->to('/')
            ->with(
                'toast_success',
                '¡Bienvenido/a de nuevo, ' .
                $usuario['nombre_usuario'] .
                '! Has iniciado sesión con éxito.'
            );
    }

    /**
     * Destruye la sesión del usuario actual y lo redirige a la página de inicio.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout()
    {
        // Destruir todas las variables almacenadas en sesión
        session()->destroy();

        // Redirigir a inicio mostrando mensaje de cierre seguro
        return redirect()->to('/')
            ->with(
                'toast_warning',
                'Has cerrado tu sesión de forma segura.'
            );
    }
}