<?php

namespace App\Libraries\Authentication;

use App\Libraries\Authentication\AuthenticationInterface;

class EmployeeAuthentication implements AuthenticationInterface
{
    private ?object $employeeData = null;
    private object $employeeModel;

    public function __construct(\CodeIgniter\Model $model)
    {
        $this->employeeModel = $model;
    }

    /**
     * Realiza o processo de autenticação
     *
     * @param array $credentials
     * @return array
     */
    public function authenticate(array $credentials): array
    {
        if (!$this->employeeModel->forAuthValidation()->validate($credentials)) {
            return ['errors' => $this->employeeModel->errors()];
        }

        $accountData = $this->employeeModel->where('email', $credentials['email'])->first();

        if (!$accountData) {
            return ['not_found' => true];
        }

        if (!$accountData->verifyPassword($credentials['password'])) {
            return ['wrong_password' => true];
        }

        if (!$accountData->isActive()) {
            return ['not_active' => true];
        }

        $this->login($accountData);

        return ['logged' => $accountData];
    }

    /**
     * Solicita os dados da conta
     *
     * @return null|object
     */
    public function data(): null|object
    {
        if (empty($this->employeeData)) {
            $this->employeeData = $this->getAuthDataFromSession();
        }

        return $this->employeeData;
    }

    public function id(): int
    {
        return session()->get('employee_id');
    }

    /**
     * Realiza o logout da conta
     *
     * @return boolean
     */
    public function logout(): bool
    {
        session()->destroy();

        return true;
    }

    /**
     * Registra o ID da conta na sessão
     *
     * @param object $account
     * @return boolean
     */
    private function login(object $account): bool
    {
        session()->regenerate();
        session()->set('employee_id', $account->id);

        return true;
    }

    /**
     * Solicita os dados da conta com base no id registrado na sessão
     *
     * @return null|object
     */
    private function getAuthDataFromSession(): null|object
    {
        if (!session()->has('employee_id')) {
            return null;
        }

        return $this->employeeModel->where('is_active', true)->where('id', session()->get('employee_id'))->first();
    }
}
