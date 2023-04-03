<?php

namespace App\Models;

use CodeIgniter\Model;

class Employee extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'employees';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\EmployeeEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'type_user_id',
        'name',
        'email',
        'password',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name' => 'required|string|min_length[4]|max_length[220]',
        'email' => 'required|valid_email|string|min_length[5]|max_length[100]'
    ];
    protected $validationMessages   = [
        'name' => [
            'required' => '* Este campo é obrigatório!',
            'string' => '* Este campo não atende aos requisitos mínimos!',
            'min_length' => '* Este campo não atende aos requisitos mínimos!',
            'max_length' => '* Este campo não atende aos requisitos mínimos!'
        ],
        'email' => [
            'required' => '* Este campo é obrigatório!',
            'valid_email' => '* Forneça um email válido!',
            'string' => '* Este campo não atende aos requisitos mínimos!',
            'min_length' => '* Este campo não atende aos requisitos mínimos!',
            'max_length' => '* Este campo não atende aos requisitos mínimos!'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
