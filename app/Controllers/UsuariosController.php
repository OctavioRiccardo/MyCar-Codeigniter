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

    // LISTAR USUARIOS (VISTA ADMINISTRADOR)
    public function index()
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $data['usuarios'] = $this->usuarios->findAll();

        return view('Vistas_Administrador/usuarios_lista', $data);
    }

    // FORMULARIO ALTA
    public function crear()
    {
        return view('Vistas_Comunes/registro', [
            'titulo' => 'Crear Usuario',
            'accion' => site_url('usuarios/guardar'),
            'usuario' => null
        ]);
    }


    // GUARDAR NUEVO USUARIO
    public function guardar()
    {
        // Reglas de validación sobre entradas de texto plano (Controlador)
        $rules = [
            'nombre_usuario'  => 'required|min_length[3]|max_length[50]|is_unique[usuarios.nombre_usuario]',
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

        $datos = [
            'nombre_usuario'   => $this->request->getPost('nombre_usuario'),
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

    // FORMULARIO EDICIÓN
    public function editar($id)
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $usuario = $this->usuarios->find($id);

        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Usuario no encontrado'
            );
        }

        // Los campos ya vienen como nombre_usuario y apellido_usuario de la base de datos

        return view('Vistas_Comunes/registro', [
            'titulo' => 'Editar Usuario',
            'accion' => site_url('usuarios/actualizar/' . $id),
            'usuario' => $usuario
        ]);
    }

    // ACTUALIZAR USUARIO
    public function actualizar($id)
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $usuario = $this->usuarios->find($id);

        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Usuario no encontrado'
            );
        }

        // Reglas de validación para la edición
        $rules = [
            'nombre_usuario'  => "required|min_length[3]|max_length[50]|is_unique[usuarios.nombre_usuario,id_usuario,{$id}]",
            'apellido_usuario' => 'required|max_length[100]',
            'direccion'       => 'permit_empty|max_length[100]',
            'telefono'        => 'permit_empty|max_length[20]',
        ];

        // Validar contraseña solo si se escribió una nueva
        if ($this->request->getPost('clave_usuario') != '') {
            $rules['clave_usuario'] = 'required|min_length[6]|max_length[255]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $datos = [
            'nombre_usuario'   => $this->request->getPost('nombre_usuario'),
            'rol'              => $this->request->getPost('rol') ?? $usuario['rol'],
            'apellido_usuario' => $this->request->getPost('apellido_usuario'),
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
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

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