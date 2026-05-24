<?php

namespace App\Models;

use CodeIgniter\Model;

class VehiculosModel extends Model
{
    protected $table = 'vehiculos';
    protected $primaryKey = 'id_vehiculo';

    protected $allowedFields = [
        'tipo_vehiculo',
        'imagen',
        'marca',
        'modelo',
        'anio',
        'numero_plazas',
        'motor',
        'kilometraje',
        'precio_alquiler_dia',
        'disponibilidad'
    ];

    protected $returnType = 'array';

    protected $useAutoIncrement = true;

    protected $useTimestamps = false;
}