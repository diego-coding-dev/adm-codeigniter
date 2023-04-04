<?php

namespace App\Controllers\Activation;

use App\Controllers\BaseController;
use App\Models\Employee;
use App\Models\ActivationTokens;
use App\Libraries\Token;

class EmployeeActivationController extends BaseController
{
    private object $employeeModel;
    private object $activationTokensModel;
    private object $token;
    private object $encrypt;

    public function __construct()
    {
        $this->employeeModel = new Employee();
        $this->activationTokensModel = new ActivationTokens();
        $this->encrypt = service('encrypter');
    }

    /**
     * Inicia verificações antes de ativar a conta
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
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Operação não concluída, contacte o administrador!');
        }

        $viewData = [
            'title' => 'ADM - Ativando conta',
            'employee' => $employee
        ];

        return view('activation/employeeActivation/setPassword', $viewData);
    }

    public function setPassword(): object
    {
        $dataForm = $this->request->getPost();
        $dataForm['employee_id'] = $this->encrypt->decrypt(hex2bin($dataForm['employee_id']));

        if (!$this->employeeModel->validate($dataForm)) {
            return redirect()->back()->with('errors', $this->employeeModel->errors());
        }

        if (!$this->activate($dataForm)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Operação não concluída, contacte o administrador!');
        }

        dd('usuário ativado, fazer o login');
    }

    /**
     * Persisti os dados da ativação no banco de dados
     *
     * @param [type] $employeeData
     * @return boolean
     */
    private function activate($employeeData): bool
    {
        $db = db_connect('default');
        $employee = $this->employeeModel->where('id', $employeeData['employee_id'])->first();

        $db->transBegin();

        $this->employeeModel->where('id', $employeeData['employee_id'])->set([
            'password' => $employeeData['password'],
            'is_active' => true
        ])->update();

        $this->activationTokensModel->where('email', $employee->email)->delete();

        if ($db->transStatus() === false) {
            $db->transRollback();
            return false;
        }

        $db->transCommit();
        return true;
    }

    /**
     * Busca dados do funcionário pelo email
     *
     * @param object $account
     * @return null|object
     */
    private function getEmployeeDataByEmail(object $account): null|object
    {
        return $this->employeeModel->where('email', $account->email)->first();
    }

    /**
     * Busca dados da ativação pelo hash do token
     *
     * @param string $token
     * @return null|object
     */
    private function getActivationDataByToken(string $token): null|object
    {
        $this->token = new Token($token);

        $tokenHash = $this->token->getTokenHash();

        return $this->activationTokensModel->where('token_hash', $tokenHash)->first();
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
