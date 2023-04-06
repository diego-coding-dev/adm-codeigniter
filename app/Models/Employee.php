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
        'email' => 'required|valid_email|string|min_length[5]|max_length[100]|is_unique[employees.email]',
        'password' => 'required|string|min_length[8]|max_length[100]|regex_match[/^.*([a-zA-Z][0-9]).*$/]',
        'password_confirm' => 'required|matches[password]'
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
        ],
        'password' => [
            'required' => '* Este campo é obrigatório!',
            'string' => '* Este campo não atende aos requisitos mínimos!',
            'min_length' => '* Este campo não atende aos requisitos mínimos!',
            'max_length' => '* Este campo não atende aos requisitos mínimos!',
            'regex_match' => '* Este campo não atende aos requisitos mínimos!'
        ],
        'password_confirm' => [
            'required' => '* Este campo é obrigatório!',
            'matches' => '* A senha não é igual!'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [
        'hashPassword'
    ];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Criptografa a senha
     *
     * @param array $data
     * @return array
     */
    protected function hashPassword(array $data): array
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }

    /**
     * Remove algumas regras necessárias para validar os dados do login
     *
     * @return object
     */
    public function forAuthValidation(): object
    {
        foreach ($this->validationRules as $key => $value) {
            if (strpos($value, 'is_unique[employees.email]')) {
                $this->validationRules[$key] = str_replace('|is_unique[employees.email]', '', $value);
                break;
            }
        }

        return $this;
    }
}
