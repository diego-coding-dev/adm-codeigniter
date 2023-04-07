<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeProduct extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'type_products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\TypeProductEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'type_product'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'type_product' => 'required|string|min_length[4]|max_length[30]'
    ];
    protected $validationMessages   = [
        'type_product' => [
            'required' => '* Este campo é obrigatório!',
            'string' => '* Este campo não atende aos requisitos mínimos!',
            'min_length' => '* Este campo não atende aos requisitos mínimos!',
            'max_length' => '* Este campo não atende aos requisitos mínimos!'
        ],
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
     * Seleciona somente as rules necessárias para buscar a categoria do produto
     *
     * @return object
     */
    public function forSearchTypeProduct(): object
    {
        $this->validationRules['type_product'] = str_replace('required|', 'permit_empty|', $this->validationRules['type_product']);

        return $this;
    }
}
