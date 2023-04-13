<?php

namespace App\Validations;

class OrderCartValidation extends BaseValidation
{

    private array $rules = [
        'quantity' => [
            'rules' => 'required|min_length[1]|max_length[3]',
            'errors' => [
                'required' => '* Este campo é obrigatório!',
                'min_length' => '* Este campo não atende aos requisitos mínimos!',
                'max_length' => '* Este campo não atende aos requisitos mínimos!'
            ]
        ],
        'description' => [
            'rules' => 'required|string|min_length[4]|max_length[150]',
            'errors' => [
                'required' => '* Este campo é obrigatório!',
                'string' => '* Este campo não atende aos requisitos mínimos!',
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

    public function onlyDescription()
    {
        unset($this->rules['quantity']);

        $this->rules['description']['rules'] = str_replace('required|', 'permit_empty|', $this->rules['description']['rules']);

        return $this;
    }

    public function onlyQuantity()
    {
        unset($this->rules['description']);

        return $this;
    }

}
