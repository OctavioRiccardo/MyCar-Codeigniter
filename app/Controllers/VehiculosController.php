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

    // Listar todos los vehículos (Admin)
    public function index()
    {
        $data['vehiculos'] = $this->vehiculosModel->findAll();

        return view('Vistas_Administrador/vehiculos_lista', $data);
    }

    // Mostrar detalles de un vehículo (Admin)
    public function show($id = null)
    {
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
        return view('Vistas_Administrador/vehiculos_crear');
    }

    // Guardar nuevo vehículo (Admin)
    public function create()
    {
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
        $vehiculo = $this->vehiculosModel->find($id);

        if (!$vehiculo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Vehículo no encontrado');
        }

        $this->vehiculosModel->delete($id);

        return redirect()->to('/vehiculos');
    }
}
