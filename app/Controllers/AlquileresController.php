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

    // Guardar alquiler en la base de datos
    public function guardarAlquiler()
    {
        $fechaDesde = $this->request->getPost('fecha_desde');
        $cantidadDias = $this->request->getPost('cantidad_dias');
        $metodoPago = $this->request->getPost('metodopago');
        $idVehiculo = $this->request->getPost('id_vehiculo');

        $idUsuario = session()->get('id_usuario');

        if (!$idUsuario) {
            return redirect()->back()->with(
                'error',
                'Debe iniciar sesión para alquilar un vehículo.'
            );
        }

        // Calcular fecha de finalización
        $fechaHasta = date(
            'Y-m-d',
            strtotime($fechaDesde . ' + ' . ($cantidadDias - 1) . ' days')
        );

        $this->alquileresModel->save([
            'fecha_desde' => $fechaDesde,
            'cantidad_dias' => $cantidadDias,
            'metodopago' => $metodoPago,
            'fecha_hasta' => $fechaHasta,
            'id_vehiculo' => $idVehiculo,
            'id_usuario' => $idUsuario,
            'estado' => 'reserva'
        ]);

        // Cambiar disponibilidad del vehículo a no disponible
        $this->vehiculosModel->update($idVehiculo, [
            'disponibilidad' => 'no_disponible'
        ]);

        return redirect()->to('/mis-alquileres')->with(
            'success',
            'Alquiler realizado correctamente.'
        );
    }

    // Mostrar listado de alquileres del cliente logueado
    public function mostrarAlquileres()
    {
        $idUsuario = session()->get('id_usuario');

        if (!$idUsuario) {
            return redirect()->to('/login');
        }

        // Obtener alquileres con información detallada del vehículo
        $alquileres = $this->alquileresModel
            ->select('
                alquileres.*,
                vehiculos.marca,
                vehiculos.modelo,
                vehiculos.imagen,
                vehiculos.tipo_vehiculo,
                vehiculos.precio_alquiler_dia
            ')
            ->join(
                'vehiculos',
                'vehiculos.id_vehiculo = alquileres.id_vehiculo'
            )
            ->where('alquileres.id_usuario', $idUsuario)
            ->orderBy('alquileres.id_alquiler', 'DESC')
            ->findAll();

        $data['alquileres'] = $alquileres;

        return view(
            'Vistas_Cliente/cliente_ver_alquileres',
            $data
        );
    }

    // Ver resumen detallado del alquiler
    public function verResumen($idAlquiler)
    {
        $idUsuario = session()->get('id_usuario');

        if (!$idUsuario) {
            return redirect()->to('/login');
        }

        // Obtener alquiler y datos del vehículo asociado
        $alquiler = $this->alquileresModel
            ->select('
                alquileres.*,
                vehiculos.marca,
                vehiculos.modelo,
                vehiculos.imagen,
                vehiculos.tipo_vehiculo,
                vehiculos.precio_alquiler_dia
            ')
            ->join(
                'vehiculos',
                'vehiculos.id_vehiculo = alquileres.id_vehiculo'
            )
            ->where('alquileres.id_alquiler', $idAlquiler)
            ->where('alquileres.id_usuario', $idUsuario)
            ->first();

        if (!$alquiler) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Calcular costo total
        $precioTotal = $alquiler['cantidad_dias'] * $alquiler['precio_alquiler_dia'];

        $data['alquiler'] = $alquiler;
        $data['precioTotal'] = $precioTotal;

        return view(
            'Vistas_Cliente/cliente_ver_resumen',
            $data
        );
    }

    // Mostrar todos los alquileres en el panel de administración
    public function listarAlquileresAdmin()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login');
        }

        if (session()->get('rol') != 'administrador') {
            return redirect()->to('/');
        }

        // Obtener todos los alquileres con datos del vehículo y cliente
        $alquileres = $this->alquileresModel
            ->select('
                alquileres.*,
                vehiculos.marca,
                vehiculos.modelo,
                vehiculos.tipo_vehiculo,
                usuarios.nombre_usuario,
                usuarios.apellido_usuario
            ')
            ->join(
                'vehiculos',
                'vehiculos.id_vehiculo = alquileres.id_vehiculo'
            )
            ->join(
                'usuarios',
                'usuarios.id_usuario = alquileres.id_usuario'
            )
            ->orderBy('alquileres.id_alquiler', 'DESC')
            ->findAll();

        $data['alquileres'] = $alquileres;

        return view(
            'Vistas_Administrador/administrador_alquileres_lista',
            $data
        );
    }
}
