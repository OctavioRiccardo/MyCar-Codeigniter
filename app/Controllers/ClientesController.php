<?php

namespace App\Controllers;

use App\Models\VehiculosModel;
use App\Models\AlquileresModel;

/**
 * Controlador de Gestión de Clientes.
 * Administra todo el flujo de reserva de vehículos (formulario, procesamiento, resumen y confirmación)
 * y el perfil personal del cliente.
 */
class ClientesController extends BaseController
{
    /**
     * @var VehiculosModel Modelo para interactuar con la tabla de vehículos.
     */
    protected $vehiculosModel;

    /**
     * @var AlquileresModel Modelo para interactuar con la tabla de alquileres.
     */
    protected $alquileresModel;

    /**
     * Constructor del controlador. Inicializa los modelos de vehículos y alquileres.
     */
    public function __construct()
    {
        $this->vehiculosModel = new VehiculosModel();
        $this->alquileresModel = new AlquileresModel();
    }

    /**
     * Muestra el formulario para solicitar la reserva de un vehículo.
     * Restringe el acceso a usuarios no autenticados.
     * 
     * @param int|string $id_vehiculo ID del vehículo que se desea reservar.
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function solicitarReserva($id_vehiculo)
    {
        // Validar sesión activa de usuario
        if (!session()->get('logueado')) {
            return redirect()->to('/login')->with('error_login', 'Debes iniciar sesión para realizar una reserva.');
        }

        $vehiculo = $this->vehiculosModel->find($id_vehiculo);

        // Verificar que el vehículo exista y esté disponible
        if (!$vehiculo || $vehiculo['disponibilidad'] !== 'disponible') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Vehículo no disponible o no encontrado.');
        }

        return view('Vistas_Cliente/cliente_reserva_vehiculo', [
            'vehiculo' => $vehiculo
        ]);
    }

    /**
     * Valida y procesa los datos del formulario de reserva enviados por método POST.
     * Si los datos son válidos, calcula el total y guarda la información temporal en la sesión.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function procesarReserva()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login')->with('error_login', 'Debes iniciar sesión para realizar una reserva.');
        }

        // Reglas de validación para el formulario
        $rules = [
            'id_vehiculo'   => 'required|is_natural_no_zero',
            'fecha_desde'   => 'required|valid_date[Y-m-d]',
            'cantidad_dias' => 'required|is_natural_no_zero|greater_than[0]',
            'metodopago'    => 'required|in_list[efectivo,tarjeta,transferencia]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $id_vehiculo = $this->request->getPost('id_vehiculo');
        $fecha_desde = $this->request->getPost('fecha_desde');
        $cantidad_dias = (int) $this->request->getPost('cantidad_dias');
        $metodopago = $this->request->getPost('metodopago');

        // Validar que la fecha de reserva no sea del pasado
        $hoy = date('Y-m-d');
        if ($fecha_desde < $hoy) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['fecha_desde' => 'La fecha de inicio no puede ser anterior a la fecha de hoy.']);
        }

        $vehiculo = $this->vehiculosModel->find($id_vehiculo);

        if (!$vehiculo || $vehiculo['disponibilidad'] !== 'disponible') {
            return redirect()->to('/')->with('toast_warning', 'El vehículo no está disponible para reserva en este momento.');
        }

        // Calcular fecha de finalización (fecha_hasta)
        $date = new \DateTime($fecha_desde);
        $date->modify('+' . $cantidad_dias . ' days');
        $fecha_hasta = $date->format('Y-m-d');

        // Calcular costo final estimado
        $precio_total = $vehiculo['precio_alquiler_dia'] * $cantidad_dias;

        // Registrar de forma temporal los datos en sesión del cliente para el paso de confirmación
        session()->set('temp_reserva', [
            'id_vehiculo'   => $id_vehiculo,
            'fecha_desde'   => $fecha_desde,
            'cantidad_dias' => $cantidad_dias,
            'fecha_hasta'   => $fecha_hasta,
            'precio_total'  => $precio_total,
            'metodopago'    => $metodopago
        ]);

        return redirect()->to('cliente/resumen');
    }

    /**
     * Muestra la pantalla intermedia con el resumen del costo y fechas de la reserva temporal
     * antes de proceder con el guardado final en base de datos.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function resumenReserva()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login')->with('error_login', 'Debes iniciar sesión para ver el resumen de reserva.');
        }

        $temp = session()->get('temp_reserva');

        if (!$temp) {
            return redirect()->to('/')->with('toast_warning', 'No hay ninguna sesión de reserva activa.');
        }

        $vehiculo = $this->vehiculosModel->find($temp['id_vehiculo']);

        if (!$vehiculo) {
            return redirect()->to('/')->with('toast_warning', 'El vehículo de la reserva no fue encontrado.');
        }

        return view('Vistas_Cliente/cliente_resumen_reserva', [
            'vehiculo' => $vehiculo,
            'reserva'  => $temp
        ]);
    }

    /**
     * Guarda de forma definitiva el registro de alquiler en la base de datos a partir de la
     * información de reserva almacenada en la sesión temporal y cambia la disponibilidad del auto.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function confirmarReserva()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login')->with('error_login', 'Debes iniciar sesión para confirmar la reserva.');
        }

        $temp = session()->get('temp_reserva');

        if (!$temp) {
            return redirect()->to('/')->with('toast_warning', 'No hay ninguna sesión de reserva activa para confirmar.');
        }

        // Validar disponibilidad por segunda vez (control de concurrencia)
        $vehiculo = $this->vehiculosModel->find($temp['id_vehiculo']);
        if (!$vehiculo || $vehiculo['disponibilidad'] !== 'disponible') {
            session()->remove('temp_reserva');
            return redirect()->to('/')->with('toast_warning', 'El vehículo ya no está disponible para reserva.');
        }

        // Armar el payload de inserción de alquiler
        $alquilerDatos = [
            'fecha_desde'   => $temp['fecha_desde'],
            'cantidad_dias' => $temp['cantidad_dias'],
            'fecha_hasta'   => $temp['fecha_hasta'],
            'id_vehiculo'   => $temp['id_vehiculo'],
            'id_usuario'    => session()->get('id_usuario'),
            'estado'        => 'reserva',
            'metodopago'    => $temp['metodopago'] ?? 'efectivo'
        ];

        if ($this->alquileresModel->insert($alquilerDatos)) {
            // Marcar disponibilidad del auto a 'no_disponible'
            $this->vehiculosModel->update($temp['id_vehiculo'], [
                'disponibilidad' => 'no_disponible'
            ]);

            // Limpiar la estructura temporal de sesión
            session()->remove('temp_reserva');

            return redirect()->to('/mis-alquileres')->with('toast_success', '¡Reserva confirmada con éxito! Tu alquiler en estado de reserva ha sido registrado.');
        } else {
            return redirect()->back()->with('toast_warning', 'Hubo un problema al procesar tu reserva. Inténtalo de nuevo.');
        }
    }

    /**
     * Muestra la información personal y datos de perfil del cliente autenticado.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function perfil()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login')->with('error_login', 'Debes iniciar sesión para ver tu perfil.');
        }

        $usuariosModel = new \App\Models\UsuariosModel();
        $idUsuario = session()->get('id_usuario');
        $usuario = $usuariosModel->find($idUsuario);

        if (!$usuario) {
            return redirect()->to('/')->with('toast_warning', 'Usuario no encontrado.');
        }

        return view('Vistas_Cliente/cliente_perfil', [
            'usuario' => $usuario
        ]);
    }
}

