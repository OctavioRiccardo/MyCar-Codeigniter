<?php

namespace App\Controllers;

use App\Models\UsuariosModel;

class UsuariosController extends BaseController
{
    protected $usuarios;

    public function __construct()
    {
        $this->usuarios = new UsuariosModel();
    }

    // Muestra formulario de registro
    public function crear()
    {
        return view('Vistas_Comunes/registro', [
            'titulo' => 'Crear Usuario',
            'accion' => site_url('usuarios/guardar'),
            'usuario' => null
        ]);
    }

    // Guarda el nuevo usuario (registro o creación por admin)
    public function guardar()
    {
        $rules = [
            'nombre_usuario'  => 'required|min_length[3]|max_length[50]',
            'clave_usuario'   => 'required|min_length[6]|max_length[255]',
            'apellido_usuario' => 'required|max_length[100]',
            'direccion'       => 'permit_empty|max_length[100]',
            'telefono'        => 'permit_empty|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $nombre_usuario = $this->request->getPost('nombre_usuario');

        // Si ya existe un usuario activo con ese nombre
        $usuarioActivo = $this->usuarios->where('nombre_usuario', $nombre_usuario)->first();
        if ($usuarioActivo) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['nombre_usuario' => 'El nombre de usuario ya está en uso.']);
        }

        // Si existía un usuario pero estaba dado de baja (soft delete), lo reactivamos
        $usuarioEliminado = $this->usuarios->onlyDeleted()->where('nombre_usuario', $nombre_usuario)->first();
        if ($usuarioEliminado) {
            $datos = [
                'password'         => password_hash($this->request->getPost('clave_usuario'), PASSWORD_DEFAULT),
                'rol'              => 'cliente',
                'apellido_usuario' => $this->request->getPost('apellido_usuario'),
                'direccion'        => $this->request->getPost('direccion'),
                'telefono'         => $this->request->getPost('telefono'),
                'fecha_alta'       => date('Y-m-d'),
                'deleted_at'       => null
            ];

            if ($this->usuarios->update($usuarioEliminado['id_usuario'], $datos)) {
                if (session()->get('logueado')) {
                    return redirect()->to('/usuarios')
                        ->with('mensaje', 'Usuario reactivado y actualizado correctamente.');
                }
                return redirect()->to('/login')
                    ->with('mensaje', 'Su cuenta ha sido reactivada con éxito. Por favor, inicie sesión.');
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->usuarios->errors());
            }
        }

        $datos = [
            'nombre_usuario'   => $nombre_usuario,
            'password'         => password_hash($this->request->getPost('clave_usuario'), PASSWORD_DEFAULT),
            'rol'              => 'cliente',
            'apellido_usuario' => $this->request->getPost('apellido_usuario'),
            'direccion'        => $this->request->getPost('direccion'),
            'telefono'         => $this->request->getPost('telefono'),
            'fecha_alta'       => date('Y-m-d')
        ];

        if (!$this->usuarios->insert($datos)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->usuarios->errors());
        }

        if (session()->get('logueado')) {
            return redirect()->to('/usuarios')
                ->with('mensaje', 'Usuario creado correctamente.');
        }

        return redirect()->to('/login')
            ->with('mensaje', 'Registro exitoso. Por favor, inicia sesión.');
    }
}