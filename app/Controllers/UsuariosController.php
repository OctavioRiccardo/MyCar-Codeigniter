<?php

namespace App\Controllers;

use App\Models\UsuariosModel;

/**
 * Controlador de Usuarios (Clientes).
 * Administra el listado de clientes en el panel del administrador, el registro público,
 * y las operaciones de creación, edición, actualización y baja lógica.
 */
class UsuariosController extends BaseController
{
    /**
     * @var UsuariosModel Modelo de base de datos para interactuar con la tabla de usuarios.
     */
    protected $usuarios;

    /**
     * Constructor del controlador. Inicializa el modelo de usuarios.
     */
    public function __construct()
    {
        $this->usuarios = new UsuariosModel();
    }



    /**
     * Muestra el formulario de registro de usuario común (público o creación por admin).
     * 
     * @return string
     */
    public function crear()
    {
        return view('Vistas_Comunes/registro', [
            'titulo' => 'Crear Usuario',
            'accion' => site_url('usuarios/guardar'),
            'usuario' => null
        ]);
    }

    /**
     * Procesa y valida los datos enviados por método POST para registrar un nuevo usuario en la base de datos.
     * Cifra la contraseña y asigna el rol de 'cliente' de forma predeterminada.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function guardar()
    {
        // Reglas de validación de entradas de texto plano (Controlador)
        $rules = [
            'nombre_usuario'  => 'required|min_length[3]|max_length[50]',
            'clave_usuario'   => 'required|min_length[6]|max_length[255]',
            'apellido_usuario' => 'required|max_length[100]',
            'direccion'       => 'permit_empty|max_length[100]',
            'telefono'        => 'permit_empty|max_length[20]',
        ];

        // Retornar al formulario si la validación falla
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $nombre_usuario = $this->request->getPost('nombre_usuario');

        // Verificar si el nombre de usuario está siendo usado por un usuario ACTIVO
        $usuarioActivo = $this->usuarios->where('nombre_usuario', $nombre_usuario)->first();
        if ($usuarioActivo) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['nombre_usuario' => 'El nombre de usuario ya está en uso.']);
        }

        // Verificar si el nombre de usuario pertenecía a un usuario DADO DE BAJA (Soft Deleted)
        $usuarioEliminado = $this->usuarios->onlyDeleted()->where('nombre_usuario', $nombre_usuario)->first();
        if ($usuarioEliminado) {
            // Reactivar y actualizar datos
            $datos = [
                'password'         => password_hash($this->request->getPost('clave_usuario'), PASSWORD_DEFAULT),
                'rol'              => 'cliente',
                'apellido_usuario' => $this->request->getPost('apellido_usuario'),
                'direccion'        => $this->request->getPost('direccion'),
                'telefono'         => $this->request->getPost('telefono'),
                'fecha_alta'       => date('Y-m-d'),
                'deleted_at'       => null // Quitar fecha de baja lógica
            ];

            if ($this->usuarios->update($usuarioEliminado['id_usuario'], $datos)) {
                // Si el creador ya está logueado (admin), redirigir al panel de usuarios
                if (session()->get('logueado')) {
                    return redirect()->to('/usuarios')
                        ->with('mensaje', 'Usuario reactivado y actualizado correctamente.');
                }
                // Redirigir a login para usuarios recién auto-registrados
                return redirect()->to('/login')
                    ->with('mensaje', 'Su cuenta ha sido reactivada con éxito. Por favor, inicie sesión.');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->usuarios->errors());
            }
        }

        // Preparar array asociativo de inserción para nuevo usuario
        $datos = [
            'nombre_usuario'   => $nombre_usuario,
            'password'         => password_hash($this->request->getPost('clave_usuario'), PASSWORD_DEFAULT),
            'rol'              => 'cliente',
            'apellido_usuario' => $this->request->getPost('apellido_usuario'),
            'direccion'        => $this->request->getPost('direccion'),
            'telefono'         => $this->request->getPost('telefono'),
            'fecha_alta'       => date('Y-m-d')
        ];

        // Insertar en la tabla
        if (!$this->usuarios->insert($datos)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->usuarios->errors());
        }

        // Si el creador ya está logueado (admin), redirigir al panel de usuarios
        if (session()->get('logueado')) {
            return redirect()->to('/usuarios')
                ->with('mensaje', 'Usuario creado correctamente.');
        }

        // Redirigir a login para usuarios recién auto-registrados
        return redirect()->to('/login')
            ->with('mensaje', 'Registro exitoso. Por favor, inicia sesión.');
    }

}