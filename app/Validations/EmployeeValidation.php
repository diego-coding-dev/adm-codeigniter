<?php

namespace App\Validations;

class EmployeeValidation extends BaseValidation
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
            'rules' => 'required|valid_email|string|min_length[5]|max_length[100]|is_unique[employees.email]',
            'errors' => [
                'is_unique' => '* Este email já está em uso.',
                'required' => '* Este campo é obrigatório!',
                'valid_email' => '* Forneça um email válido!',
                'string' => '* Este campo não atende aos requisitos mínimos!',
                'min_length' => '* Este campo não atende aos requisitos mínimos!',
                'max_length' => '* Este campo não atende aos requisitos mínimos!'
            ]
        ],
        'password' => [
            'rules' => 'required|string|min_length[8]|max_length[100]|regex_match[/^.*([a-zA-Z][0-9]).*$/]',
            'errors' => [
                'required' => '* Este campo é obrigatório!',
                'string' => '* Este campo não atende aos requisitos mínimos!',
                'min_length' => '* Este campo não atende aos requisitos mínimos!',
                'max_length' => '* Este campo não atende aos requisitos mínimos!',
                'regex_match' => '* Este campo não atende aos requisitos mínimos!'
            ]
        ],
        'password_confirm' => [
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => '* Este campo é obrigatório!',
                'matches' => '* A senha não é igual!'
            ]
        ],
        'current_password' => [
            'rules' => 'required|string|min_length[8]|max_length[100]|regex_match[/^.*([a-zA-Z][0-9]).*$/]',
            'errors' => [
                'required' => '* Este campo é obrigatório!',
                'string' => '* Este campo não atende aos requisitos mínimos!',
                'min_length' => '* Este campo não atende aos requisitos mínimos!',
                'max_length' => '* Este campo não atende aos requisitos mínimos!',
                'regex_match' => '* Este campo não atende aos requisitos mínimos!'
            ]
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function run(array $data): bool|array
    {
        return parent::validate($this->rules, $data);
    }

    /**
     * Retorna regras para cadastrar senha na atiavação
     *
     * @return object
     */
    public function forActivation(): object
    {
        unset($this->rules['name']);
        unset($this->rules['email']);
        unset($this->rules['current_password']);

        return $this;
    }

    /**
     * Remove algumas regras necessárias para validar os dados do login
     *
     * @return object
     */
    public function forAuthValidation(): object
    {
        foreach ($this->rules as $key => $value) {
            if (strpos($value['rules'], 'is_unique[employees.email]')) {
                $this->rules[$key]['rules'] = str_replace('|is_unique[employees.email]', '', $value['rules']);
                break;
            }
        }

        unset($this->rules['name']);
        unset($this->rules['password_confirm']);
        unset($this->rules['current_password']);

        return $this;
    }

    /**
     * Seleciona somente as rules necessárias para registrar novo funcionário
     *
     * @return object
     */
    public function forAddEmployee(): object
    {
        unset($this->rules['password']);
        unset($this->rules['password_confirm']);
        unset($this->rules['current_password']);

        return $this;
    }

    /**
     * Seleciona somente as rules necessárias para buscar funcionário pelo nome
     *
     * @return object
     */
    public function forSearchEmployee(): object
    {
        unset($this->rules['email']);
        unset($this->rules['password']);
        unset($this->rules['password_confirm']);
        unset($this->rules['current_password']);

        $this->rules['name']['rules'] = str_replace('required|', 'permit_empty|', $this->rules['name']['rules']);

        return $this;
    }

    /**
     * Seleciona somente a rule de email
     *
     * @return object
     */
    public function onlyEmail(): object
    {
        unset($this->rules['name']);
        unset($this->rules['password']);
        unset($this->rules['password_confirm']);
        unset($this->rules['current_password']);

        return $this;
    }

    /**
     * Seleciona somente a rule de password
     *
     * @return object
     */
    public function onlyPassword(): object
    {
        unset($this->rules['name']);
        unset($this->rules['email']);

        return $this;
    }
}
