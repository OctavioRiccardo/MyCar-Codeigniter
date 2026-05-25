<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class TestDBController extends Controller
{
    // Test de conexión a la base de datos
    public function index()
    {
        try {
            $db = Database::connect();
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
            $data['estado'] = false;
            $data['mensaje'] = "Error: " . $e->getMessage();
        }

        return view('test_db', $data);
    }
}
