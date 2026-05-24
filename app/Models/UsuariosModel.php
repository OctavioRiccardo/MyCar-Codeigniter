<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
    protected $table = 'usuarios';

    protected $primaryKey = 'id_usuario';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nombre_usuario',
        'clave_usuario',
        'rol',
        'nombre_apellido',
        'direccion',
        'telefono',
        'fecha_alta'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'nombre_usuario' => 'required|min_length[3]|max_length[50]|is_unique[usuarios.nombre_usuario,id_usuario,{id_usuario}]',
        'clave_usuario' => 'required|min_length[6]|max_length[255]',
        'rol' => 'required|in_list[administrador,cliente]',
        'nombre_apellido' => 'required|max_length[100]',
        'direccion' => 'permit_empty|max_length[100]',
        'telefono' => 'permit_empty|max_length[20]',
        'fecha_alta' => 'permit_empty|valid_date'
    ];

    protected $validationMessages = [
        'nombre_usuario' => [
            'required' => 'El nombre de usuario es obligatorio.',
            'is_unique' => 'El nombre de usuario ya existe.'
        ],

        'clave_usuario' => [
            'required' => 'La clave es obligatoria.',
            'min_length' => 'La clave debe tener al menos 6 caracteres.'
        ],

        'rol' => [
            'required' => 'El rol es obligatorio.',
            'in_list' => 'El rol debe ser administrador o cliente.'
        ],

        'nombre_apellido' => [
            'required' => 'El nombre y apellido es obligatorio.'
        ]
    ];

    protected $skipValidation = false;
}