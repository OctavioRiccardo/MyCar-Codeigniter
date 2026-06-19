<?php

namespace App\Controllers;

use App\Models\AlquileresModel;
use App\Models\VehiculosModel;
use CodeIgniter\Controller;

class AlquileresController extends Controller
{
    protected $alquileresModel;
    protected $vehiculosModel;

    public function __construct()
    {
        $this->alquileresModel = new AlquileresModel();
        $this->vehiculosModel = new VehiculosModel();
    }

    // Guarda reserva directa (Legacy/General)
    public function guardarAlquiler()
    {
        $fechaDesde = $this->request->getPost('fecha_desde');
        $cantidadDias = $this->request->getPost('cantidad_dias');
        $metodoPago = $this->request->getPost('metodopago');
        $idVehiculo = $this->request->getPost('id_vehiculo');

        $idUsuario = session()->get('id_usuario');

        if (!$idUsuario) {
            return redirect()->back()->with('error', 'Debe iniciar sesión.');
        }

        $fechaHasta = date('Y-m-d', strtotime($fechaDesde . ' + ' . ($cantidadDias - 1) . ' days'));

        $this->alquileresModel->save([
            'fecha_desde' => $fechaDesde,
            'cantidad_dias' => $cantidadDias,
            'metodopago' => $metodoPago,
            'fecha_hasta' => $fechaHasta,
            'id_vehiculo' => $idVehiculo,
            'id_usuario' => $idUsuario,
            'estado' => 'reserva'
        ]);

        $this->vehiculosModel->update($idVehiculo, [
            'disponibilidad' => 'no_disponible'
        ]);

        return redirect()->to('/mis-alquileres')->with('success', 'Alquiler realizado correctamente.');
    }

    // Lista de alquileres del cliente
    public function mostrarAlquileres()
    {
        $idUsuario = session()->get('id_usuario');

        if (!$idUsuario) {
            return redirect()->to('/login');
        }

        $alquileres = $this->alquileresModel
            ->select('
                alquileres.*,
                vehiculos.marca,
                vehiculos.modelo,
                vehiculos.imagen,
                vehiculos.tipo_vehiculo,
                vehiculos.precio_alquiler_dia
            ')
            ->join('vehiculos', 'vehiculos.id_vehiculo = alquileres.id_vehiculo')
            ->where('alquileres.id_usuario', $idUsuario)
            ->orderBy('alquileres.id_alquiler', 'DESC')
            ->findAll();

        $data['alquileres'] = $alquileres;

        return view('Vistas_Cliente/cliente_ver_alquileres', $data);
    }

    // Ver resumen de un alquiler (Cliente)
    public function verResumen($idAlquiler)
    {
        $idUsuario = session()->get('id_usuario');

        if (!$idUsuario) {
            return redirect()->to('/login');
        }

        $alquiler = $this->alquileresModel
            ->select('
                alquileres.*,
                vehiculos.marca,
                vehiculos.modelo,
                vehiculos.imagen,
                vehiculos.tipo_vehiculo,
                vehiculos.precio_alquiler_dia
            ')
            ->join('vehiculos', 'vehiculos.id_vehiculo = alquileres.id_vehiculo')
            ->where('alquileres.id_alquiler', $idAlquiler)
            ->where('alquileres.id_usuario', $idUsuario)
            ->first();

        if (!$alquiler) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $precioTotal = $alquiler['cantidad_dias'] * $alquiler['precio_alquiler_dia'];

        $data['alquiler'] = $alquiler;
        $data['precioTotal'] = $precioTotal;

        return view('Vistas_Cliente/cliente_ver_resumen', $data);
    }

    // Listado de alquileres (Admin)
    public function listarAlquileresAdmin()
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $alquileres = $this->alquileresModel
            ->select('
                alquileres.*,
                vehiculos.marca,
                vehiculos.modelo,
                vehiculos.tipo_vehiculo,
                usuarios.nombre_usuario,
                usuarios.apellido_usuario
            ')
            ->join('vehiculos', 'vehiculos.id_vehiculo = alquileres.id_vehiculo')
            ->join('usuarios', 'usuarios.id_usuario = alquileres.id_usuario')
            ->orderBy('alquileres.id_alquiler', 'DESC')
            ->findAll();

        $data['alquileres'] = $alquileres;

        return view('Vistas_Administrador/administrador_alquileres_lista', $data);
    }

    // Aprobar una reserva (Admin)
    public function aprobarReserva($idAlquiler)
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $alquiler = $this->alquileresModel->find($idAlquiler);

        if (!$alquiler) {
            return redirect()->back()->with('error', 'Reserva no encontrada.');
        }

        $this->alquileresModel->update($idAlquiler, [
            'estado' => 'alquiler'
        ]);

        return redirect()->back()->with('success', 'Reserva aprobada.');
    }

    // Registrar devolución de vehículo (Admin)
    public function devolucionVehiculo($idAlquiler)
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $alquiler = $this->alquileresModel->find($idAlquiler);

        if (!$alquiler) {
            return redirect()->back()->with('error', 'Registro no encontrado.');
        }

        $this->alquileresModel->update($idAlquiler, [
            'estado' => 'devuelto'
        ]);

        $this->vehiculosModel->update($alquiler['id_vehiculo'], [
            'disponibilidad' => 'disponible'
        ]);

        return redirect()->back()->with('success', 'Vehículo devuelto.');
    }

    // Alquileres activos actuales (Admin)
    public function listarAlquileresActivos()
    {
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $alquileresActivos = $this->alquileresModel
            ->select('
                alquileres.*,
                vehiculos.marca,
                vehiculos.modelo,
                vehiculos.tipo_vehiculo,
                usuarios.nombre_usuario,
                usuarios.apellido_usuario,
                usuarios.telefono
            ')
            ->join('vehiculos', 'vehiculos.id_vehiculo = alquileres.id_vehiculo')
            ->join('usuarios', 'usuarios.id_usuario = alquileres.id_usuario')
            ->where('alquileres.estado', 'alquiler')
            ->orderBy('alquileres.id_alquiler', 'DESC')
            ->findAll();

        $data['alquileres'] = $alquileresActivos;

        return view('Vistas_Administrador/administrador_alquileres_activos', $data);
    }
}
