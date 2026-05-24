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

    // LISTAR USUARIOS
    public function index()
    {
        $data['usuarios'] = $this->usuarios->findAll();

        return view('usuarios/index', $data);
    }

    // FORMULARIO ALTA
    public function crear()
    {
        return view('usuarios/formulario', [
            'titulo' => 'Crear Usuario',
            'accion' => site_url('usuarios/guardar'),
            'usuario' => null
        ]);
    }

    // GUARDAR NUEVO USUARIO
    public function guardar()
    {
        $datos = [
            'nombre_usuario' => $this->request->getPost('nombre_usuario'),
            'password'       => password_hash($this->request->getPost('clave_usuario'),PASSWORD_DEFAULT),
            'rol'             => 'cliente',
            'apellido_usuario'=> $this->request->getPost('nombre_apellido'),
            'direccion'       => $this->request->getPost('direccion'),
            'telefono'        => $this->request->getPost('telefono'),
            'fecha_alta'      => date('Y-m-d')
        ];

        if (!$this->usuarios->insert($datos)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->usuarios->errors());
        }

        return redirect()->to('/usuarios')
            ->with('mensaje', 'Usuario creado correctamente.');
    }

    // FORMULARIO EDICIÓN
    public function editar($id)
    {
        $usuario = $this->usuarios->find($id);

        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Usuario no encontrado'
            );
        }

        // Mapeamos el campo de la BD al nombre esperado por la vista del formulario
        $usuario['nombre_apellido'] = $usuario['apellido_usuario'];

        return view('usuarios/formulario', [
            'titulo' => 'Editar Usuario',
            'accion' => site_url('usuarios/actualizar/' . $id),
            'usuario' => $usuario
        ]);
    }

    // ACTUALIZAR USUARIO
    public function actualizar($id)
    {
        $usuario = $this->usuarios->find($id);

        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Usuario no encontrado'
            );
        }

        $datos = [
            'nombre_usuario'   => $this->request->getPost('nombre_usuario'),
            'rol'              => $this->request->getPost('rol'),
            'apellido_usuario' => $this->request->getPost('nombre_apellido'),
            'direccion'        => $this->request->getPost('direccion'),
            'telefono'         => $this->request->getPost('telefono')
        ];

        // Solo actualizar contraseña si se escribió una nueva
        if ($this->request->getPost('clave_usuario') != '') {
            $datos['password'] = password_hash(
                $this->request->getPost('clave_usuario'),
                PASSWORD_DEFAULT
            );
        }

        if (!$this->usuarios->update($id, $datos)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->usuarios->errors());
        }

        return redirect()->to('/usuarios')
            ->with('mensaje', 'Usuario actualizado correctamente.');
    }

    // ELIMINAR USUARIO (Baja Lógica integrada)
    public function eliminar($id)
    {
        $usuario = $this->usuarios->find($id);

        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Usuario no encontrado'
            );
        }

        // Esto ejecutará un Soft Delete debido a la configuración del modelo
        $this->usuarios->delete($id);

        return redirect()->to('/usuarios')
            ->with('mensaje', 'Usuario dado de baja correctamente.');
    }
}