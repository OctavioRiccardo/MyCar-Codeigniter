<?php

namespace App\Controllers;

use App\Models\VehiculosModel;

/**
 * Controlador de la Página de Inicio Pública.
 * Se encarga de listar y desplegar la flota de vehículos disponibles para clientes e invitados.
 */
class InicioController extends BaseController
{
    /**
     * Muestra la página de inicio con la lista completa de vehículos del catálogo.
     * 
     * @return string
     */
    public function index()
    {
        $vehiculosModel = new VehiculosModel();
        
        // Obtener todos los vehículos registrados
        $data['vehiculos'] = $vehiculosModel->findAll();

        // Cargar el catálogo común de inicio
        return view('Vistas_Comunes/inicio', $data);
    }
}
