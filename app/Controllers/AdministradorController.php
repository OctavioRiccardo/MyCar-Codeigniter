<?php

namespace App\Controllers;

use App\Models\UsuariosModel;

/**
 * Controlador para la gestión del Panel de Control del Administrador.
 * Restringe el acceso únicamente a usuarios autenticados con rol de administrador.
 */
class AdministradorController extends BaseController
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
     * Muestra la pantalla de inicio (Dashboard) del administrador.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function index()
    {
        // Verificar que el usuario tenga una sesión activa
        if (!session()->get('logueado')) {
            return redirect()->to('/login');
        }

        // Verificar que el rol del usuario sea estrictamente 'administrador'
        if (session()->get('rol') != 'administrador') {
            return redirect()->to('/');
        }

        // Cargar la vista del dashboard principal del administrador
        return view('Vistas_Administrador/administrador_inicio');
    }

    /**
     * Muestra el listado de usuarios con rol 'cliente' en el panel del administrador.
     * Restringe el acceso a no-administradores.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function listarUsuarios()
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        // Recuperar solo los usuarios con el rol 'cliente'
        $data['usuarios'] = $this->usuarios
            ->where('rol', 'cliente')
            ->findAll();

        return view('Vistas_Administrador/administrador_usuarios_lista', $data);
    }

    /**
     * Muestra el formulario de edición cargando los datos de un usuario por su ID.
     * Restringe el acceso a no-administradores.
     * 
     * @param int|string $id ID del usuario a editar.
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function editarUsuario($id)
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $usuario = $this->usuarios->find($id);

        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Usuario no encontrado'
            );
        }

        // Cargar vista de edición reutilizando la plantilla de registro
        return view('Vistas_Comunes/registro', [
            'titulo' => 'Editar Usuario',
            'accion' => site_url('usuarios/actualizar/' . $id),
            'usuario' => $usuario
        ]);
    }

    /**
     * Actualiza la información modificada de un usuario en la base de datos.
     * Restringe el acceso a no-administradores.
     * 
     * @param int|string $id ID del usuario a actualizar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function actualizarUsuario($id)
    {
        // Validar privilegios de administrador
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

        // Preparar los datos actualizados
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

    /**
     * Da de baja lógica (Soft Delete) a un usuario utilizando la propiedad soft-deletes del modelo.
     * Restringe el acceso a no-administradores.
     * 
     * @param int|string $id ID del usuario a dar de baja.
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function eliminarUsuario($id)
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $usuario = $this->usuarios->find($id);

        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Usuario no encontrado'
            );
        }

        // Esto ejecutará un Soft Delete debido a la propiedad $useSoftDeletes en UsuariosModel
        $this->usuarios->delete($id);

        return redirect()->to('/usuarios')
            ->with('mensaje', 'Usuario dado de baja correctamente.');
    }

    /**
     * Muestra la lista de vehículos alquilados por un usuario específico (cliente).
     * Restringe el acceso a no-administradores.
     * 
     * @param int|string $idUsuario ID del usuario.
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function mostrarVehiculos($idUsuario)
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $usuario = $this->usuarios->find($idUsuario);

        if (!$usuario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Usuario no encontrado');
        }

        // Instanciar el modelo de alquileres para realizar la consulta
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