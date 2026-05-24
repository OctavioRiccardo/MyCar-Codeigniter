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
            'nombre_apellido' => 'required|max_length[100]',
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
            'apellido_usuario' => $this->request->getPost('nombre_apellido'),
            'direccion'        => $this->request->getPost('direccion'),
            'telefono'         => $this->request->getPost('telefono'),
            'fecha_alta'       => date('Y-m-d')
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

        return view('Vistas_Comunes/registro', [
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

        // Reglas de validación para la edición
        $rules = [
            'nombre_usuario'  => "required|min_length[3]|max_length[50]|is_unique[usuarios.nombre_usuario,id_usuario,{$id}]",
            'nombre_apellido' => 'required|max_length[100]',
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

    // PANTALLA DE LOGIN
    public function login()
    {
        return view('Vistas_Comunes/login');
    }
}