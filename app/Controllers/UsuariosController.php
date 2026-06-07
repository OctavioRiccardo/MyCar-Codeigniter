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
     * Muestra el listado de usuarios con rol 'cliente' en el panel del administrador.
     * Restringe el acceso a no-administradores.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function index()
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
            'nombre_usuario'  => 'required|min_length[3]|max_length[50]|is_unique[usuarios.nombre_usuario]',
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

        // Preparar array asociativo de inserción
        $datos = [
            'nombre_usuario'   => $this->request->getPost('nombre_usuario'),
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

    /**
     * Muestra el formulario de edición cargando los datos de un usuario por su ID.
     * Restringe el acceso a no-administradores.
     * 
     * @param int|string $id ID del usuario a editar.
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function editar($id)
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
    public function actualizar($id)
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
    public function eliminar($id)
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
}