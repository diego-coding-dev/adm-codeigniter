<?php

namespace App\Controllers\Authentication;

use App\Controllers\BaseController;

class EmployeeAuthenticationController extends BaseController
{
    private array $dataView;
    private object $auth;

    public function __construct()
    {
        $this->auth = service('auth', 'EmployeeAuthentication');
    }

    /**
     * Exibe o formulário de autenticação
     *
     * @return string
     */
    public function authentication(): string
    {
        $this->dataView = [
            'title' => 'ADM - Área restrita'
        ];

        return view('authentication/employeeAuthentication/authentication', $this->dataView);
    }

    /**
     * Realiza o processo de autenticação
     *
     * @return object
     */
    public function authenticate(): object
    {
        $resultAuthentication = $this->auth->authenticate($this->request->getPost());

        if (array_key_exists('errors', $resultAuthentication)) {
            return redirect()->back()->with('errors', $resultAuthentication['errors']);
        }

        if (array_key_exists('not_found', $resultAuthentication) || array_key_exists('wrong_password', $resultAuthentication)) {
            return redirect()->back()->with('warning', 'Suas credênciais são inválidas!');
        }

        if (array_key_exists('not_active', $resultAuthentication)) {
            return redirect()->back()->with('warning', 'Sua conta não está ativa, contacte o administrador!');
        }

        return redirect()->route('employee.list-search')->with('success', 'Seja bem vindo(a) ' . $resultAuthentication['logged']->name);
    }
}
