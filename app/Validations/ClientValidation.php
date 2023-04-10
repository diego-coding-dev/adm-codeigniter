<?php

namespace App\Validations;

class ClientValidation extends BaseValidation
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
        'email' => [
            'rules' => 'required|valid_email|string|min_length[5]|max_length[100]|is_unique[clients.email]',
            'errors' => [
                'is_unique' => '* Este email já está em uso.',
                'required' => '* Este campo é obrigatório!',
                'valid_email' => '* Forneça um email válido!',
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
     * Seleciona somente as rules necessárias para buscar o nome do cliente
     *
     * @return object
     */
    public function forSearchCliente(): object
    {
        unset($this->rules['email']);

        $this->rules['name']['rules'] = str_replace('required|', 'permit_empty|', $this->rules['name']['rules']);

        return $this;
    }
}
