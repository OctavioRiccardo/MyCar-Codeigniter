<?php

namespace App\Controllers;

use App\Models\VehiculosModel;
use CodeIgniter\Controller;

/**
 * Controlador de Vehículos (Flota).
 * Administra el catálogo público de vehículos y el ABM (Alta, Baja, Modificación)
 * de la flota desde el panel de administración.
 */
class VehiculosController extends Controller
{
    /**
     * @var VehiculosModel Modelo para interactuar con la tabla de vehículos.
     */
    protected $vehiculosModel;

    /**
     * Constructor del controlador. Inicializa el modelo de vehículos.
     */
    public function __construct()
    {
        $this->vehiculosModel = new VehiculosModel();
    }

    /**
     * Lista todos los vehículos. Redirige a la vista administrativa o
     * de inicio pública dependiendo del rol del usuario autenticado.
     * 
     * @return string
     */
    public function index()
    {
        // Obtener todos los vehículos registrados
        $data['vehiculos'] = $this->vehiculosModel->findAll();

        // Si es administrador, mostrar el listado administrativo
        if (session()->get('logueado') && session()->get('rol') === 'administrador') {
            return view('Vistas_Administrador/administrador_vehiculos_lista', $data);
        }

        // De lo contrario (cliente o visitante), mostrar la vista común del catálogo
        return view('Vistas_Comunes/inicio', $data);
    }

    /**
     * Muestra la ficha técnica detallada de un vehículo específico en el panel administrativo.
     * Restringe el acceso a no-administradores.
     * 
     * @param int|string|null $id ID del vehículo.
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function show($id = null)
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $vehiculo = $this->vehiculosModel->find($id);

        if (!$vehiculo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Vehículo no encontrado');
        }

        $data['vehiculo'] = $vehiculo;

        return view('Vistas_Administrador/administrador_vehiculos_mostrar', $data);
    }

    /**
     * Muestra el formulario para registrar un nuevo vehículo.
     * Restringe el acceso a no-administradores.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function new()
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        return view('Vistas_Administrador/administrador_vehiculos_crear');
    }

    /**
     * Procesa y valida el envío del formulario para crear e insertar un nuevo vehículo.
     * Restringe el acceso a no-administradores.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function create()
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        // Guardar la entidad en base de datos
        $this->vehiculosModel->save([
            'tipo_vehiculo'       => $this->request->getPost('tipo_vehiculo'),
            'imagen'              => $this->request->getPost('imagen'),
            'marca'               => $this->request->getPost('marca'),
            'modelo'              => $this->request->getPost('modelo'),
            'anio'                => $this->request->getPost('anio'),
            'numero_plazas'       => $this->request->getPost('numero_plazas'),
            'motor'               => $this->request->getPost('motor'),
            'kilometraje'         => $this->request->getPost('kilometraje'),
            'precio_alquiler_dia' => $this->request->getPost('precio_alquiler_dia'),
            'disponibilidad'      => $this->request->getPost('disponibilidad')
        ]);

        return redirect()->to('/vehiculos');
    }

    /**
     * Muestra el formulario de edición de datos de un vehículo específico.
     * Restringe el acceso a no-administradores.
     * 
     * @param int|string|null $id ID del vehículo a editar.
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function edit($id = null)
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $vehiculo = $this->vehiculosModel->find($id);

        if (!$vehiculo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Vehículo no encontrado');
        }

        $data['vehiculo'] = $vehiculo;

        return view('Vistas_Administrador/administrador_vehiculos_editar', $data);
    }

    /**
     * Procesa y valida el envío del formulario para actualizar un vehículo existente.
     * Restringe el acceso a no-administradores.
     * 
     * @param int|string|null $id ID del vehículo a actualizar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function update($id = null)
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        // Actualizar datos del registro
        $this->vehiculosModel->update($id, [
            'tipo_vehiculo'       => $this->request->getPost('tipo_vehiculo'),
            'imagen'              => $this->request->getPost('imagen'),
            'marca'               => $this->request->getPost('marca'),
            'modelo'              => $this->request->getPost('modelo'),
            'anio'                => $this->request->getPost('anio'),
            'numero_plazas'       => $this->request->getPost('numero_plazas'),
            'motor'               => $this->request->getPost('motor'),
            'kilometraje'         => $this->request->getPost('kilometraje'),
            'precio_alquiler_dia' => $this->request->getPost('precio_alquiler_dia'),
            'disponibilidad'      => $this->request->getPost('disponibilidad')
        ]);

        return redirect()->to('/vehiculos');
    }

    /**
     * Da de baja lógica (Soft Delete) a un vehículo en el sistema.
     * Restringe el acceso a no-administradores.
     * 
     * @param int|string|null $id ID del vehículo a eliminar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function delete($id = null)
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $vehiculo = $this->vehiculosModel->find($id);

        if (!$vehiculo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Vehículo no encontrado');
        }

        // Soft Delete (baja lógica) del vehículo
        $this->vehiculosModel->delete($id);

        return redirect()->to('/vehiculos');
    }

    /**
     * Muestra la ficha de detalles de un vehículo orientada a clientes e invitados públicos.
     * 
     * @param int|string|null $id ID del vehículo.
     * @return string
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function detalle($id = null)
    {
        $vehiculo = $this->vehiculosModel->find($id);

        if (!$vehiculo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Vehículo no encontrado');
        }

        $data['vehiculo'] = $vehiculo;

        return view('Vistas_Cliente/cliente_detalle_vehiculo', $data);
    }
}
