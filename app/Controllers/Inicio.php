<?php

namespace App\Controllers;

use App\Models\VehiculoModel;

class Inicio extends BaseController
{
    public function index()
    {
        $vehiculoModel = new VehiculoModel();

        $data['vehiculos'] = $vehiculoModel->findAll();

        return view('inicio', $data);
    }
}