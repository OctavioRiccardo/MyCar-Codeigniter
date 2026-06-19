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

    // Listado de vehículos
    public function index()
    {
        $data['vehiculos'] = $this->vehiculosModel->findAll();

        if (session()->get('logueado') && session()->get('rol') === 'administrador') {
            return view('Vistas_Administrador/administrador_vehiculos_lista', $data);
        }

        return view('Vistas_Comunes/inicio', $data);
    }

    // Ficha del vehículo (Admin)
    public function mostrar($id = null)
    {
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

    // Crear vehículo (Formulario)
    public function crear()
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        return view('Vistas_Administrador/administrador_vehiculos_crear');
    }

    // Guardar nuevo vehículo
    public function guardar()
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

    // Editar vehículo (Formulario)
    public function editar($id = null)
    {
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

    // Actualizar datos del vehículo
    public function actualizar($id = null)
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

    // Baja lógica de vehículo
    public function eliminar($id = null)
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

    // Detalle del vehículo para el cliente
    public function detalle($id = null)
    {
        $vehiculo = $this->vehiculosModel->find($id);

        if (!$vehiculo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Vehículo no encontrado');
        }

        $data['vehiculo'] = $vehiculo;

        return view('Vistas_Cliente/cliente_detalle_vehiculo', $data);
    }

    // Historial de clientes de un vehículo
    public function mostrarClientes($idVehiculo)
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $vehiculo = $this->vehiculosModel->find($idVehiculo);

        if (!$vehiculo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Vehículo no encontrado');
        }

        $alquileresModel = new \App\Models\AlquileresModel();
        $clientes = $alquileresModel
            ->select('
                usuarios.id_usuario,
                usuarios.nombre_usuario,
                usuarios.apellido_usuario,
                usuarios.telefono,
                usuarios.direccion,
                alquileres.fecha_desde,
                alquileres.fecha_hasta,
                alquileres.estado
            ')
            ->join('usuarios', 'usuarios.id_usuario = alquileres.id_usuario')
            ->where('alquileres.id_vehiculo', $idVehiculo)
            ->orderBy('alquileres.fecha_desde', 'DESC')
            ->findAll();

        $data['vehiculo'] = $vehiculo;
        $data['clientes'] = $clientes;

        return view('Vistas_Administrador/administrador_vehiculo_clientes', $data);
    }
}
