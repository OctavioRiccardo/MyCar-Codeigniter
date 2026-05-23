<?php

namespace App\Models;

use CodeIgniter\Model;

class AlquileresModel extends Model
{
    protected $table = 'alquileres';
    protected $primaryKey = 'id_alquiler';

    protected $allowedFields = [
        'fecha_desde',
        'cantidad_dias',
        'fecha_hasta',
        'id_vehiculo',
        'id_cliente'
    ];

    protected $returnType = 'array';

    protected $useAutoIncrement = true;

    protected $useTimestamps = false;
}