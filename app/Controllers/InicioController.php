<?php

namespace App\Controllers;

use App\Models\VehiculosModel;

class InicioController extends BaseController
{
    // Menú principal (listado de vehículos disponibles)
    public function index()
    {
        $vehiculosModel = new VehiculosModel();
        $data['vehiculos'] = $vehiculosModel->findAll();

        return view('Vistas_Comunes/inicio', $data);
    }
}
