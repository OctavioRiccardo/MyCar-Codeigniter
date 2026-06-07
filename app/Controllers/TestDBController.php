<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

/**
 * Controlador de Diagnóstico de Base de Datos.
 * Permite probar de manera aislada la conexión con la base de datos MySQL configurada en el framework.
 */
class TestDBController extends Controller
{
    /**
     * Realiza un test de conexión y ejecuta una consulta de prueba.
     * 
     * @return string
     */
    public function index()
    {
        try {
            // Conectar al servicio de base de datos
            $db = Database::connect();
            
            // Consultar el nombre de la base de datos activa
            $query = $db->query("SELECT DATABASE()");

            if ($query) {
                $resultado = $query->getRow();
                $data['estado'] = true;
                $data['mensaje'] = "Conexión exitosa a la base de datos: " . $resultado->{'DATABASE()'};
            } else {
                $data['estado'] = false;
                $data['mensaje'] = "No se pudo ejecutar la consulta.";
            }
        } catch (\Exception $e) {
            // Capturar cualquier fallo de red o credenciales incorrectas
            $data['estado'] = false;
            $data['mensaje'] = "Error: " . $e->getMessage();
        }

        // Cargar vista de reporte de diagnóstico
        return view('test_db', $data);
    }
}
