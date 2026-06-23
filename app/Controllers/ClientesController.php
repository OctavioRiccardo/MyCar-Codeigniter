<?php

namespace App\Controllers;

use App\Models\VehiculosModel;
use App\Models\AlquileresModel;

class ClientesController extends BaseController
{
    protected $vehiculosModel;
    protected $alquileresModel;

    public function __construct()
    {
        $this->vehiculosModel = new VehiculosModel();
        $this->alquileresModel = new AlquileresModel();
    }

    // Solicitar reserva (Formulario)
    public function solicitarReserva($id_vehiculo)
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login')->with('error_login', 'Debes iniciar sesión para realizar una reserva.');
        }

        $vehiculo = $this->vehiculosModel->find($id_vehiculo);

        if (!$vehiculo || $vehiculo['disponibilidad'] !== 'disponible') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Vehículo no disponible.');
        }

        return view('Vistas_Cliente/cliente_reserva_vehiculo', [
            'vehiculo' => $vehiculo
        ]);
    }

    // Validar y procesar datos del formulario
    public function procesarReserva()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login')->with('error_login', 'Debes iniciar sesión.');
        }

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

        $hoy = date('Y-m-d');
        if ($fecha_desde < $hoy) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['fecha_desde' => 'La fecha de inicio no puede ser anterior a hoy.']);
        }

        $vehiculo = $this->vehiculosModel->find($id_vehiculo);

        if (!$vehiculo || $vehiculo['disponibilidad'] !== 'disponible') {
            return redirect()->to('/')->with('toast_warning', 'El vehículo no está disponible.');
        }

        $date = new \DateTime($fecha_desde);
        $date->modify('+' . $cantidad_dias . ' days');
        $fecha_hasta = $date->format('Y-m-d');

        $precio_total = $vehiculo['precio_alquiler_dia'] * $cantidad_dias;

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

    // Mostrar el resumen temporal
    public function resumenReserva()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login')->with('error_login', 'Debes iniciar sesión.');
        }

        $temp = session()->get('temp_reserva');

        if (!$temp) {
            return redirect()->to('/')->with('toast_warning', 'No hay reserva activa.');
        }

        $vehiculo = $this->vehiculosModel->find($temp['id_vehiculo']);

        if (!$vehiculo) {
            return redirect()->to('/')->with('toast_warning', 'Vehículo no encontrado.');
        }

        return view('Vistas_Cliente/cliente_resumen_reserva', [
            'vehiculo' => $vehiculo,
            'reserva'  => $temp
        ]);
    }

    // Confirmar y guardar definitivamente
    public function confirmarReserva()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login')->with('error_login', 'Debes iniciar sesión.');
        }

        $temp = session()->get('temp_reserva');

        if (!$temp) {
            return redirect()->to('/')->with('toast_warning', 'No hay reserva activa.');
        }

        $vehiculo = $this->vehiculosModel->find($temp['id_vehiculo']);
        if (!$vehiculo || $vehiculo['disponibilidad'] !== 'disponible') {
            session()->remove('temp_reserva');
            return redirect()->to('/')->with('toast_warning', 'El vehículo ya no está disponible.');
        }

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
            $this->vehiculosModel->update($temp['id_vehiculo'], [
                'disponibilidad' => 'no_disponible'
            ]);

            session()->remove('temp_reserva');

            return redirect()->to('/mis-alquileres')->with('toast_success', 'Reserva confirmada con éxito.');
        } else {
            return redirect()->back()->with('toast_warning', 'Error al procesar la reserva.');
        }
    }

    // Perfil del cliente
    public function perfil()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login')->with('error_login', 'Debes iniciar sesión.');
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
