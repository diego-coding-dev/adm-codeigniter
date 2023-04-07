<?php

namespace App\Models;

use CodeIgniter\Model;

class Client extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'clients';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\ClientEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'type_user_id',
        'name',
        'email'
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
        'email' => 'required|valid_email|string|min_length[5]|max_length[100]|is_unique[employees.email]',
    ];
    protected $validationMessages   = [
        'name' => [
            'required' => '* Este campo é obrigatório!',
            'string' => '* Este campo não atende aos requisitos mínimos!',
            'min_length' => '* Este campo não atende aos requisitos mínimos!',
            'max_length' => '* Este campo não atende aos requisitos mínimos!'
        ],
        'email' => [
            'is_unique' => '* Este email já está em uso.',
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

    /**
     * Seleciona somente as rules necessárias para buscar o nome do cliente
     *
     * @return object
     */
    public function forSearchCliente(): object
    {
        unset($this->validationRules['email']);

        $this->validationRules['name'] = str_replace('required|', 'permit_empty|', $this->validationRules['name']);

        return $this;
    }
}
