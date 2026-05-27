<?php

namespace App\Controllers;

class AdministradorController extends BaseController
{
    public function index()
    {
        // Verificar sesión iniciada
        if (!session()->get('logueado')) {

            return redirect()->to('/login');
        }

        // Verificar rol administrador
        if (session()->get('rol') != 'administrador') {

            return redirect()->to('/');
        }

        return view('Vistas_Administrador/administrador_inicio');
    }
}