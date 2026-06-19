<?php

namespace App\Controllers;

use App\Models\AlquileresModel;
use App\Models\VehiculosModel;
use CodeIgniter\Controller;

/**
 * Controlador de Alquileres y Reservas.
 * Permite a los clientes gestionar sus solicitudes de alquiler y resúmenes de pago,
 * y permite al administrador listar y monitorear todos los alquileres del sistema.
 */
class AlquileresController extends Controller
{
    /**
     * @var AlquileresModel Modelo para interactuar con la tabla de alquileres.
     */
    protected $alquileresModel;

    /**
     * @var VehiculosModel Modelo para interactuar con la tabla de vehículos.
     */
    protected $vehiculosModel;

    /**
     * Constructor del controlador. Inicializa los modelos de alquileres y vehículos.
     */
    public function __construct()
    {
        $this->alquileresModel = new AlquileresModel();
        $this->vehiculosModel = new VehiculosModel();
    }

    /**
     * Procesa la solicitud de alquiler de un vehículo por método POST.
     * Calcula la fecha de finalización, persiste la reserva y actualiza la disponibilidad del vehículo.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function guardarAlquiler()
    {
        $fechaDesde = $this->request->getPost('fecha_desde');
        $cantidadDias = $this->request->getPost('cantidad_dias');
        $metodoPago = $this->request->getPost('metodopago');
        $idVehiculo = $this->request->getPost('id_vehiculo');

        $idUsuario = session()->get('id_usuario');

        // Validar que el usuario esté logueado
        if (!$idUsuario) {
            return redirect()->back()->with(
                'error',
                'Debe iniciar sesión para alquilar un vehículo.'
            );
        }

        // Calcular fecha de finalización basada en cantidad de días de alquiler
        $fechaHasta = date(
            'Y-m-d',
            strtotime($fechaDesde . ' + ' . ($cantidadDias - 1) . ' days')
        );

        // Guardar registro de alquiler con estado inicial 'reserva'
        $this->alquileresModel->save([
            'fecha_desde' => $fechaDesde,
            'cantidad_dias' => $cantidadDias,
            'metodopago' => $metodoPago,
            'fecha_hasta' => $fechaHasta,
            'id_vehiculo' => $idVehiculo,
            'id_usuario' => $idUsuario,
            'estado' => 'reserva'
        ]);

        // Cambiar la disponibilidad del vehículo a 'no_disponible'
        $this->vehiculosModel->update($idVehiculo, [
            'disponibilidad' => 'no_disponible'
        ]);

        return redirect()->to('/mis-alquileres')->with(
            'success',
            'Alquiler realizado correctamente.'
        );
    }

    /**
     * Muestra el listado histórico de reservas y alquileres del cliente autenticado.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function mostrarAlquileres()
    {
        $idUsuario = session()->get('id_usuario');

        // Restringir acceso solo a usuarios logueados
        if (!$idUsuario) {
            return redirect()->to('/login');
        }

        // Obtener alquileres con información unida (JOIN) del vehículo
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

    /**
     * Muestra el resumen detallado de costo, fechas y estado de un alquiler específico para el cliente.
     * 
     * @param int|string $idAlquiler ID del alquiler.
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function verResumen($idAlquiler)
    {
        $idUsuario = session()->get('id_usuario');

        if (!$idUsuario) {
            return redirect()->to('/login');
        }

        // Obtener datos del alquiler específico verificando pertenencia al cliente logueado
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

        // Calcular costo total del servicio (días * precio diario)
        $precioTotal = $alquiler['cantidad_dias'] * $alquiler['precio_alquiler_dia'];

        $data['alquiler'] = $alquiler;
        $data['precioTotal'] = $precioTotal;

        return view(
            'Vistas_Cliente/cliente_ver_resumen',
            $data
        );
    }

    /**
     * Muestra a nivel administrativo todos los alquileres del sistema ordenados cronológicamente.
     * Restringe el acceso a no-administradores.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function listarAlquileresAdmin()
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado')) {
            return redirect()->to('/login');
        }

        if (session()->get('rol') != 'administrador') {
            return redirect()->to('/');
        }

        // Obtener todos los alquileres con datos del vehículo y cliente asociados (JOINs múltiples)
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

    /**
     * Aprueba una reserva pasándola al estado de 'alquiler' activo.
     * Restringe el acceso a no-administradores.
     * 
     * @param int|string $idAlquiler ID del alquiler/reserva.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function aprobarReserva($idAlquiler)
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $alquiler = $this->alquileresModel->find($idAlquiler);

        if (!$alquiler) {
            return redirect()->back()->with('error', 'Reserva no encontrada.');
        }

        // Cambiar el estado a 'alquiler'
        $this->alquileresModel->update($idAlquiler, [
            'estado' => 'alquiler'
        ]);

        return redirect()->back()->with('success', 'La reserva ha sido aprobada e iniciada como alquiler activo.');
    }

    /**
     * Registra la devolución de un vehículo al finalizar el alquiler.
     * Cambia el estado a 'devuelto' y vuelve a habilitar la disponibilidad del auto.
     * Restringe el acceso a no-administradores.
     * 
     * @param int|string $idAlquiler ID del alquiler.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function devolucionVehiculo($idAlquiler)
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        $alquiler = $this->alquileresModel->find($idAlquiler);

        if (!$alquiler) {
            return redirect()->back()->with('error', 'Registro de alquiler no encontrado.');
        }

        // Cambiar el estado a 'devuelto'
        $this->alquileresModel->update($idAlquiler, [
            'estado' => 'devuelto'
        ]);

        // Cambiar disponibilidad del vehículo a 'disponible'
        $this->vehiculosModel->update($alquiler['id_vehiculo'], [
            'disponibilidad' => 'disponible'
        ]);

        return redirect()->back()->with('success', 'El vehículo ha sido devuelto con éxito y puesto en disponibilidad.');
    }

    /**
     * Muestra el listado de vehículos actualmente alquilados con los datos del cliente que lo ha alquilado.
     * Restringe el acceso a no-administradores.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function listarAlquileresActivos()
    {
        // Validar privilegios de administrador
        if (!session()->get('logueado') || session()->get('rol') !== 'administrador') {
            return redirect()->to('/');
        }

        // Obtener solo alquileres activos ('alquiler')
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
