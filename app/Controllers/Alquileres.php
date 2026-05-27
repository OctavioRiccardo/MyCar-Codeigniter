<?php

namespace App\Controllers;

use App\Models\AlquileresModel;
use App\Models\VehiculosModel;
use CodeIgniter\Controller;

class Alquileres extends Controller
{
    protected $alquileresModel;
    protected $vehiculosModel;

    public function __construct()
    {
        $this->alquileresModel = new AlquileresModel();
        $this->vehiculosModel = new VehiculosModel();
    }

    /*
    |--------------------------------------------------------------------------
    | Guardar alquiler
    |--------------------------------------------------------------------------
    */
    public function guardarAlquiler()
    {
        // Obtener datos del formulario
        $fechaDesde = $this->request->getPost('fecha_desde');
        $cantidadDias = $this->request->getPost('cantidad_dias');
        $metodoPago = $this->request->getPost('metodopago');
        $idVehiculo = $this->request->getPost('id_vehiculo');

        // Usuario logueado
        $idUsuario = session()->get('id_usuario');

        // Validar usuario
        if (!$idUsuario) {

            return redirect()->back()->with(
                'error',
                'Debe iniciar sesión para alquilar un vehículo.'
            );
        }

        // Calcular fecha hasta
        $fechaHasta = date(
            'Y-m-d',
            strtotime($fechaDesde . ' + ' . ($cantidadDias - 1) . ' days')
        );

        // Guardar alquiler
        $this->alquileresModel->save([
            'fecha_desde' => $fechaDesde,
            'cantidad_dias' => $cantidadDias,
            'metodopago' => $metodoPago,
            'fecha_hasta' => $fechaHasta,
            'id_vehiculo' => $idVehiculo,
            'id_usuario' => $idUsuario,
            'estado' => 'reserva'
        ]);

        // Opcional:
        // cambiar disponibilidad del vehículo

        $this->vehiculosModel->update($idVehiculo, [
            'disponibilidad' => 'no_disponible'
        ]);

        return redirect()->to('/mis-alquileres')->with(
            'success',
            'Alquiler realizado correctamente.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Mostrar alquileres del cliente
    |--------------------------------------------------------------------------
    */
    public function mostrarAlquileres()
    {
        $idUsuario = session()->get('id_usuario');

        // Validar sesión
        if (!$idUsuario) {

            return redirect()->to('/login');
        }

        /*
        |--------------------------------------------------------------------------
        | Obtener alquileres + información del vehículo
        |--------------------------------------------------------------------------
        */
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

    /*
    |--------------------------------------------------------------------------
    | Ver resumen completo del alquiler
    |--------------------------------------------------------------------------
    */
    public function verResumen($idAlquiler)
    {
        $idUsuario = session()->get('id_usuario');

        // Validar sesión
        if (!$idUsuario) {

            return redirect()->to('/login');
        }

        /*
        |--------------------------------------------------------------------------
        | Obtener alquiler + vehículo
        |--------------------------------------------------------------------------
        */
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

        // Validar alquiler existente
        if (!$alquiler) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        /*
        |--------------------------------------------------------------------------
        | Calcular total
        |--------------------------------------------------------------------------
        */
        $precioTotal =
            $alquiler['cantidad_dias'] *
            $alquiler['precio_alquiler_dia'];

        /*
        |--------------------------------------------------------------------------
        | Enviar datos
        |--------------------------------------------------------------------------
        */
        $data['alquiler'] = $alquiler;

        $data['precioTotal'] = $precioTotal;

        return view(
            'Vistas_Cliente/cliente_ver_resumen',
            $data
        );
    }
    
    /*
    |--------------------------------------------------------------------------
    | Mostrar TODOS los alquileres (Administrador)
    |--------------------------------------------------------------------------
    */
    public function listarAlquileresAdmin()
    {
        // Validar sesión
        if (!session()->get('logueado')) {

            return redirect()->to('/login');
        }

        // Validar rol administrador
        if (session()->get('rol') != 'administrador') {

            return redirect()->to('/');
        }

        /*
        |--------------------------------------------------------------------------
        | Obtener alquileres completos
        |--------------------------------------------------------------------------
        */
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
            'Vistas_Administrador/alquileres_lista',
            $data
        );
    }

}