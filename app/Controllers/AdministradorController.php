<?php

namespace App\Controllers;

use App\Models\UsuariosModel;

class AdministradorController extends BaseController
{
    protected $usuarios;

    public function __construct()
    {
        $this->usuarios = new UsuariosModel();
    }

    // Dashboard del administrador
    public function index()
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/login');
        }

        return view('Vistas_Administrador/administrador_inicio');
    }

    // Lista de clientes
    public function listarUsuarios()
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $data['usuarios'] = $this->usuarios
            ->where('rol', 'cliente')
            ->findAll();

        return view('Vistas_Administrador/administrador_usuarios_lista', $data);
    }

    // Editar cliente (Formulario)
    public function editarUsuario($id)
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $usuario = $this->usuarios->find($id);

        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario no encontrado');
        }

        return view('Vistas_Comunes/registro', [
            'titulo' => 'Editar Usuario',
            'accion' => site_url('usuarios/actualizar/' . $id),
            'usuario' => $usuario
        ]);
    }

    // Procesar actualización de cliente
    public function actualizarUsuario($id)
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $usuario = $this->usuarios->find($id);

        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario no encontrado');
        }

        $rules = [
            'nombre_usuario'  => "required|min_length[3]|max_length[50]|is_unique[usuarios.nombre_usuario,id_usuario,{$id}]",
            'apellido_usuario' => 'required|max_length[100]',
            'direccion'       => 'permit_empty|max_length[100]',
            'telefono'        => 'permit_empty|max_length[20]',
        ];

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

        if ($this->request->getPost('clave_usuario') != '') {
            $datos['password'] = password_hash($this->request->getPost('clave_usuario'), PASSWORD_DEFAULT);
        }

        if (!$this->usuarios->update($id, $datos)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->usuarios->errors());
        }

        return redirect()->to('/usuarios')
            ->with('mensaje', 'Usuario actualizado correctamente.');
    }

    // Baja lógica de cliente
    public function eliminarUsuario($id)
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $usuario = $this->usuarios->find($id);

        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario no encontrado');
        }

        $this->usuarios->delete($id);

        return redirect()->to('/usuarios')
            ->with('mensaje', 'Usuario dado de baja correctamente.');
    }

    // Historial de vehículos alquilados por un cliente
    public function mostrarVehiculos($idUsuario)
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $usuario = $this->usuarios->find($idUsuario);

        if (!$usuario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Usuario no encontrado');
        }

        $alquileresModel = new \App\Models\AlquileresModel();
        $vehiculos = $alquileresModel
            ->select('
                vehiculos.id_vehiculo,
                vehiculos.marca,
                vehiculos.modelo,
                vehiculos.tipo_vehiculo,
                vehiculos.anio,
                alquileres.fecha_desde,
                alquileres.fecha_hasta,
                alquileres.estado
            ')
            ->join('vehiculos', 'vehiculos.id_vehiculo = alquileres.id_vehiculo')
            ->where('alquileres.id_usuario', $idUsuario)
            ->orderBy('alquileres.fecha_desde', 'DESC')
            ->findAll();

        $data['usuario'] = $usuario;
        $data['vehiculos'] = $vehiculos;

        return view('Vistas_Administrador/administrador_usuario_vehiculos', $data);
    }
}