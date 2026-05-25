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

    // 1. Mostrar formulario de reserva
    public function solicitarReserva($id_vehiculo)
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login')->with('error_login', 'Debes iniciar sesión para realizar una reserva.');
        }

        $vehiculo = $this->vehiculosModel->find($id_vehiculo);

        if (!$vehiculo || $vehiculo['disponibilidad'] !== 'disponible') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Vehículo no disponible o no encontrado.');
        }

        return view('Vistas_Cliente/cliente_reserva_vehiculo', [
            'vehiculo' => $vehiculo
        ]);
    }

    // 2. Procesar el formulario de reserva
    public function procesarReserva()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login')->with('error_login', 'Debes iniciar sesión para realizar una reserva.');
        }

        $rules = [
            'id_vehiculo'   => 'required|is_natural_no_zero',
            'fecha_desde'   => 'required|valid_date[Y-m-d]',
            'cantidad_dias' => 'required|is_natural_no_zero|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $id_vehiculo = $this->request->getPost('id_vehiculo');
        $fecha_desde = $this->request->getPost('fecha_desde');
        $cantidad_dias = (int) $this->request->getPost('cantidad_dias');

        // Validar que la fecha no sea anterior a hoy
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

        // Calcular fecha_hasta
        $date = new \DateTime($fecha_desde);
        $date->modify('+' . $cantidad_dias . ' days');
        $fecha_hasta = $date->format('Y-m-d');

        // Calcular costo total
        $precio_total = $vehiculo['precio_alquiler_dia'] * $cantidad_dias;

        // Guardar temporalmente en sesión
        session()->set('temp_reserva', [
            'id_vehiculo'   => $id_vehiculo,
            'fecha_desde'   => $fecha_desde,
            'cantidad_dias' => $cantidad_dias,
            'fecha_hasta'   => $fecha_hasta,
            'precio_total'  => $precio_total
        ]);

        return redirect()->to('cliente/resumen');
    }

    // 3. Mostrar resumen de reserva
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

    // 4. Confirmar la reserva final
    public function confirmarReserva()
    {
        if (!session()->get('logueado')) {
            return redirect()->to('/login')->with('error_login', 'Debes iniciar sesión para confirmar la reserva.');
        }

        $temp = session()->get('temp_reserva');

        if (!$temp) {
            return redirect()->to('/')->with('toast_warning', 'No hay ninguna sesión de reserva activa para confirmar.');
        }

        // Verificar disponibilidad una última vez
        $vehiculo = $this->vehiculosModel->find($temp['id_vehiculo']);
        if (!$vehiculo || $vehiculo['disponibilidad'] !== 'disponible') {
            session()->remove('temp_reserva');
            return redirect()->to('/')->with('toast_warning', 'El vehículo ya no está disponible para reserva.');
        }

        // Insertar nuevo alquiler
        $alquilerDatos = [
            'fecha_desde'   => $temp['fecha_desde'],
            'cantidad_dias' => $temp['cantidad_dias'],
            'fecha_hasta'   => $temp['fecha_hasta'],
            'id_vehiculo'   => $temp['id_vehiculo'],
            'id_usuario'    => session()->get('id_usuario'),
            'estado'        => 'reserva'
        ];

        if ($this->alquileresModel->insert($alquilerDatos)) {
            // Actualizar disponibilidad de vehículo a no_disponible
            $this->vehiculosModel->update($temp['id_vehiculo'], [
                'disponibilidad' => 'no_disponible'
            ]);

            // Limpiar sesión temporal
            session()->remove('temp_reserva');

            return redirect()->to('/')->with('toast_success', '¡Reserva confirmada con éxito! Tu alquiler en estado de reserva ha sido registrado.');
        } else {
            return redirect()->back()->with('toast_warning', 'Hubo un problema al procesar tu reserva. Inténtalo de nuevo.');
        }
    }
}
