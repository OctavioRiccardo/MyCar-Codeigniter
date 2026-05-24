<?php

namespace App\Controllers;

use App\Models\VehiculosModel;

class Inicio extends BaseController
{
    public function index()
    {
        $vehiculosModel = new VehiculosModel();

        $data['vehiculos'] = $vehiculosModel->findAll();

        return view('Vistas_Comunes/inicio', $data);
    }
}