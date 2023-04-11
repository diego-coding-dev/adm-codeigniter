<?php

namespace App\Controllers\Activation;

use App\Controllers\BaseController;
use App\Libraries\Token;

class EmployeeActivationController extends BaseController
{
    private object $employeeRepository;
    private object $activationTokensRepository;
    private object $token;
    private object $encrypt;
    private object $validation;
    private object $authentication;

    public function __construct()
    {
        $this->employeeRepository = \Config\Services::repository('employee');
        $this->activationTokensRepository = \Config\Services::repository('activationToken');
        $this->validation = \Config\Services::validationForm('employee');
        $this->encrypt = \Config\Services::encrypter();
        $this->authentication = \Config\Services::auth('employee');
    }

    /**
     * Inicia verificações para ativar a conta
     *
     * @param string|null $token
     * @return string
     */
    public function check(string $token = null): string
    {
        if (!$token) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Operação abortada!');
        }

        $account = $this->getActivationDataByToken($token);

        if (!$account) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Operação abortada!');
        }

        if (!$this->isExpired($account)) {
            dd('redireciona para o reenvio');
        }

        $employee = $this->getEmployeeDataByEmail($account);

        if (!$employee) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Operação abortada!');
        }

        $viewData = [
            'title' => 'ADM - Ativando conta',
            'employeeId' => $employee->id
        ];

        return view('activation/employeeActivation/setPassword', $viewData);
    }


    public function setPassword(): object
    {
        $dataForm = $this->request->getPost();
        $dataForm['employee_id'] = $this->encrypt->decrypt(hex2bin($dataForm['employee_id']));

        if (is_array($errors = $this->validation->forActivation()->run($dataForm))) {
            return redirect()->back()->with('errors', $errors);
        }

        $result = $this->activate($dataForm);

        if (!$result) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Operação abortada!');
        }

        $this->authentication->authenticate([
            'password' => $dataForm['password'],
            'email' => $result
        ]);

        return redirect()->route('employee.list-search')->with('success', 'Conta ativada, seja bem vindo(a)');
    }

    /**
     * Persiste os dados da ativação no banco de dados
     *
     * @param [type] $employeeData
     * @return string|boolean
     */
    private function activate($employeeData): string|bool
    {
        $db = db_connect('default');

        $employee = $this->employeeRepository->getBy([
            'id' => $employeeData['employee_id']
        ], true);

        $db->transBegin();

        $this->employeeRepository->update($employee->id, [
            'password' => $employeeData['password'],
            'is_active' => true
        ]);

        $this->activationTokensRepository->removeBy([
            'email' => $employee->email
        ]);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return false;
        }

        $db->transCommit();
        return $employee->email;
    }

    /**
     * Busca dados do funcionário pelo email
     *
     * @param object $account
     * @return null|object
     */
    private function getEmployeeDataByEmail(object $account): null|object
    {
        return $this->employeeRepository->getBy([
            'email' => $account->email
        ], true);
    }

    /**
     * Busca dados da ativação pelo hash do token
     *
     * @param string $token
     * @return null|object
     */
    private function getActivationDataByToken(string $token): null|object
    {
        $this->token = \Config\Services::library('token', $token);

        $tokenHash = $this->token->getTokenHash();

        return $this->activationTokensRepository->getBy([
            'token_hash' => $tokenHash
        ], true);
    }

    /**
     * Verifica se o token não expirou
     *
     * @param object $account
     * @return boolean
     */
    private function isExpired(object $account): bool
    {
        return Date('Y-m-d H:i:s') < $account->created_at;
    }
}
