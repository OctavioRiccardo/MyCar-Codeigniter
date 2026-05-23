<?php

namespace App\Models;

use CodeIgniter\Model;

class VehiculosModel extends Model
{
    protected $table = 'vehiculos';
    protected $primaryKey = 'id_vehiculo';

    protected $allowedFields = [
        'marca',
        'modelo',
        'anio',
        'numero_plazas',
        'motor',
        'kilometraje',
        'precio_alquiler_dia'
    ];

    protected $returnType = 'array';

    protected $useAutoIncrement = true;

    protected $useTimestamps = false;
}