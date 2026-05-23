<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientesModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';

    protected $allowedFields = [
        'nombre_apellido',
        'direccion',
        'telefono',
        'fecha_alta'
    ];

    protected $returnType = 'array';

    protected $useAutoIncrement = true;

    protected $useTimestamps = false;
}