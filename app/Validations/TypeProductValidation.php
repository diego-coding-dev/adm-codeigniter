<?php

namespace App\Validations;

class TypeProductValidation extends BaseValidation
{
    private array $rules = [
        'type_product' => [
            'rules' => 'required|string|min_length[4]|max_length[30]',
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

    /**
     * Seleciona somente as rules necessárias para buscar a categoria do produto
     *
     * @return object
     */
    public function forSearchTypeProduct(): object
    {
        $this->rules['type_product']['rules'] = str_replace('required|', 'permit_empty|', $this->rules['type_product']['rules']);

        return $this;
    }
}
