<?php

namespace App\Models;

use CodeIgniter\Model;

class VehiculosModel extends Model
{
    protected $table = 'vehiculos';
    protected $primaryKey = 'id_vehiculo';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    // Habilitar baja lógica (Soft Deletes)
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';

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
        'disponibilidad',
        'deleted_at'
    ];

    protected $useTimestamps = false;
}
