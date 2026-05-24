<?php

namespace App\Models;

use CodeIgniter\Model;

class AlquileresModel extends Model
{
    protected $table = 'alquileres';
    protected $primaryKey = 'id_alquiler';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'fecha_desde',
        'cantidad_dias',
        'fecha_hasta',
        'id_vehiculo',
        'id_usuario',
        'estado'
    ];

    protected $useTimestamps = false;
}
