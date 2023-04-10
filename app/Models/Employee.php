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
    protected $validationRules      = [];
    protected $validationMessages   = [
        
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

    /**
     * Seleciona somente as rules necessárias para buscar o nome do funcionário
     *
     * @return object
     */
    public function forSearchEmployee(): object
    {
        unset($this->validationRules['email']);

        $this->validationRules['name'] = str_replace('required|', 'permit_empty|', $this->validationRules['name']);

        return $this;
    }
}
