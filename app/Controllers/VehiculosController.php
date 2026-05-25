<?php

namespace App\Controllers;

use App\Models\VehiculosModel;
use CodeIgniter\Controller;

class VehiculosController extends Controller
{
    protected $vehiculosModel;

    public function __construct()
    {
        $this->vehiculosModel = new VehiculosModel();
    }

    // Listar todos los vehículos
    public function index()
    {
        $data['vehiculos'] = $this->vehiculosModel->findAll();

        // Si es administrador, muestra la vista de administración
        if (session()->get('logueado') && session()->get('rol') === 'administrador') {
            return view('Vistas_Administrador/vehiculos_lista', $data);
        }

        // De lo contrario (cliente o visitante), muestra la vista común de inicio
        return view('Vistas_Comunes/inicio', $data);
    }

    // Mostrar detalles de un vehículo (Admin)
    public function show($id = null)
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $vehiculo = $this->vehiculosModel->find($id);

        if (!$vehiculo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Vehículo no encontrado');
        }

        $data['vehiculo'] = $vehiculo;

        return view('Vistas_Administrador/vehiculos_mostrar', $data);
    }

    // Formulario de alta (Admin)
    public function new()
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        return view('Vistas_Administrador/vehiculos_crear');
    }

    // Guardar nuevo vehículo (Admin)
    public function create()
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

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

    // Formulario de edición (Admin)
    public function edit($id = null)
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $vehiculo = $this->vehiculosModel->find($id);

        if (!$vehiculo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Vehículo no encontrado');
        }

        $data['vehiculo'] = $vehiculo;

        return view('Vistas_Administrador/vehiculos_editar', $data);
    }

    // Actualizar datos del vehículo (Admin)
    public function update($id = null)
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

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

    // Baja lógica de vehículo (Admin)
    public function delete($id = null)
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $vehiculo = $this->vehiculosModel->find($id);

        if (!$vehiculo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Vehículo no encontrado');
        }

        $this->vehiculosModel->delete($id);

        return redirect()->to('/vehiculos');
    }

    // Mostrar detalle del vehículo para clientes / invitados
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
