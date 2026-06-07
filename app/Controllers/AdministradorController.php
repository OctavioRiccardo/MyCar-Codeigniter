<?php

namespace App\Controllers;

/**
 * Controlador para la gestión del Panel de Control del Administrador.
 * Restringe el acceso únicamente a usuarios autenticados con rol de administrador.
 */
class AdministradorController extends BaseController
{
    /**
     * Muestra la pantalla de inicio (Dashboard) del administrador.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function index()
    {
        // Verificar que el usuario tenga una sesión activa
        if (!session()->get('logueado')) {
            return redirect()->to('/login');
        }

        // Verificar que el rol del usuario sea estrictamente 'administrador'
        if (session()->get('rol') != 'administrador') {
            return redirect()->to('/');
        }

        // Cargar la vista del dashboard principal del administrador
        return view('Vistas_Administrador/administrador_inicio');
    }
}