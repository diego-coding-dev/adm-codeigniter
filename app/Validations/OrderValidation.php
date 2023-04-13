<?php

namespace App\Validations;

class OrderValidation extends BaseValidation
{

    private array $rules = [
        'name' => [
            'rules' => 'required|string|min_length[4]|max_length[220]',
            'errors' => [
                'required' => '* Este campo é obrigatório!',
                'string' => '* Este campo não atende aos requisitos mínimos!',
                'min_length' => '* Este campo não atende aos requisitos mínimos!',
                'max_length' => '* Este campo não atende aos requisitos mínimos!'
            ]
        ],
        'quantity' => [
            'rules' => 'required|min_length[1]|max_length[3]',
            'errors' => [
                'required' => '* Este campo é obrigatório!',
                'min_length' => '* Este campo não atende aos requisitos mínimos!',
                'max_length' => '* Este campo não atende aos requisitos mínimos!'
            ]
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function run(array $data)
    {
        return parent::validate($this->rules, $data);
    }

    public function onlyName(): object
    {
        unset($this->rules['quantity']);
        
        $this->rules['name']['rules'] = str_replace('required|', 'permit_empty|', $this->rules['name']['rules']);

        return $this;
    }
    
    public function onlyQuantity()
    {
        unset($this->rules['name']);
        
        $this->rules['quantity']['rules'] = str_replace('required|', 'permit_empty|', $this->rules['quantity']['rules']);

        return $this;
    }

}
