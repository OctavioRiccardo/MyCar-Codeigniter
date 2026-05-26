<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    // Habilitar baja lógica (Soft Deletes)
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';

    // Campos permitidos para inserción/actualización
    protected $allowedFields = [
        'nombre_usuario',
        'password',
        'rol',
        'apellido_usuario',
        'direccion',
        'telefono',
        'fecha_alta',
        'deleted_at'
    ];

    protected $useTimestamps = false;

    // Validación básica de base de datos.
    // La validación detallada de entradas se delega al controlador.
    protected $validationRules = [
        'nombre_usuario'   => 'required|min_length[3]|max_length[50]|is_unique[usuarios.nombre_usuario,id_usuario,{id_usuario}]',
        'rol'              => 'required|in_list[administrador,cliente]',
        'apellido_usuario' => 'required|max_length[100]',
    ];

    protected $validationMessages = [
        'nombre_usuario' => [
            'required' => 'El nombre de usuario es obligatorio.',
            'is_unique' => 'El nombre de usuario ya existe.'
        ],
        'rol' => [
            'required' => 'El rol es obligatorio.',
            'in_list' => 'El rol debe ser administrador o cliente.'
        ],
        'apellido_usuario' => [
            'required' => 'El apellido es obligatorio.'
        ]
    ];

    protected $skipValidation = false;
}
