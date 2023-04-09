<?php

namespace App\Models;

use CodeIgniter\Model;

class Product extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = \App\Entities\ProductEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'type_product_id',
        'description',
        'image'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'type_product_id' => 'required|string|min_length[1]|max_length[3]',
        'description' => 'required|string|min_length[4]|max_length[150]',
        'image' => 'uploaded[image]|max_size[image, 1024]|mime_in[image,image/png,image/jpeg]|ext_in[image,png,jpg,jpeg]'
    ];
    protected $validationMessages   = [
        'type_product_id' => [
            'required' => '* Este campo é obrigatório!',
            'integer' => '* Este campo não atende aos requisitos mínimos!'
        ],
        'description' => [
            'required' => '* Este campo é obrigatório!',
            'string' => '* Este campo não atende aos requisitos mínimos!1',
            'min_length' => '* Este campo não atende aos requisitos mínimos!2',
            'max_length' => '* Este campo não atende aos requisitos mínimos!3'
        ],
        'image' => [
            'uploaded' => '* Nenhum arquivo carregado'
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

    public function imagesValidationRules()
    {
        $validations = $this->validationRules;
        unset($validations['type_product_id']);
        unset($validations['description']);

        return $validations;
    }

    public function fieldsValidationRules()
    {
        unset($this->validationRules['image']);

        return $this;
    }

    public function forSearchProduct()
    {
        unset($this->validationRules['type_product_id']);
        unset($this->validationRules['image']);

        $this->validationRules['description'] = str_replace('required|', 'permit_empty|', $this->validationRules['description']);

        return $this;
    }

    public function rules()
    {
        return $this->validationRules;
    }
}
