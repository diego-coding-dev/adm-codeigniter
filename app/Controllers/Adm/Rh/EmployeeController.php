<?php

namespace App\Controllers\Adm\Rh;

use App\Controllers\BaseController;
use App\Models\Employee;
use App\Models\ActivationTokens;
use App\Libraries\ValidationsTrait\ValidOnlyNameTrait;
use App\Libraries\Token;
use Config\Services;

class EmployeeController extends BaseController
{
    use ValidOnlyNameTrait;

    private array $dataView;
    private object $employeeModel;
    private object $activationTokensModel;
    private object $mail;
    private object $token;
    private object $validation;

    public function __construct()
    {
        $this->employeeModel = new Employee();
        $this->activationTokensModel = new ActivationTokens();
        $this->token = new Token();
        $this->validation = Services::validation();
        $this->mail = Services::email();
    }

    /**
     * Exibe tela com a lista de funcionários
     *
     * @return string|object
     */
    public function listSearch(): string|object
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Funcionários',
            'dashboard' => 'Lista de funcionários'
        ];
        if (!is_null($name = $this->request->getGet('name'))) {

            $this->validation->setRules($this->nameRules());

            if (!$this->validation->run($this->request->getGet())) {
                return redirect()->back()->with('errors', $this->validation->getErrors());
            }

            $this->dataView['name'] = $name;
            $this->dataView['employeeList'] = $this->employeeModel->where('type_user_id', 2)->like('name', $name)->orderBy('id', 'asc')->paginate(10);
        } else {
            $this->dataView['employeeList'] = $this->employeeModel->where('type_user_id', 2)->orderBy('id', 'asc')->paginate(10);
        }

        $this->dataView['pager'] = $this->employeeModel->pager;

        return view('adm/rh/employee/listSearch', $this->dataView);
    }

    /**
     * Exibe tela para registrar um novo funcionário
     *
     * @return string
     */
    public function adding(): string
    {
        // colocar filtro para checar se é get (middleware)
        $this->dataView = [
            'title' => 'ADM - Funcionário',
            'dashboard' => 'Adicionando novo funcionário'
        ];

        return view('adm/rh/employee/adding', $this->dataView);
    }

    /**
     * Inicia a persistência dos dados do novo funcionário no banco
     *
     * @return object
     */
    public function add(): object
    {
        // colocar filtro para checar se é post (middleware)
        $dataForm = $this->request->getPost();
        $dataForm['type_user_id'] = 2;

        if (!$this->employeeModel->validate($dataForm)) {
            return redirect()->back()->with('errors', $this->employeeModel->errors());
        }

        if (!$this->persistNewEmployee($dataForm)) {
            return redirect()->route('employee.list-search')->with('danger', 'Registro não realizado, contacte o administrador!');
        }

        $this->sendActivationEmail($dataForm);

        return redirect()->route('employee.list-search')->with('success', 'Funcionário registrado com sucesso!');
    }

    /**
     * Exibe tela com dados do funcionário
     *
     * @param string|null $employeeId
     * @return string
     */
    public function show(string $employeeId = null): string
    {
        $decEmployee = $this->decryptEmployeeId($employeeId);

        $this->dataView = [
            'title' => 'ADM - Funcionário',
            'dashboard' => 'Dados informacionais',
            'employee' => $this->findEmployeeById($decEmployee)
        ];

        return view('adm/rh/employee/show', $this->dataView);
    }

    /**
     * Exibe a tela para confirmar a desativação da conta do funcionário
     *
     * @param string|null $employeeId
     * @return string
     */
    public function disable(string $employeeId = null): string
    {
        $decEmployee = $this->decryptEmployeeId($employeeId);

        $this->dataView = [
            'title' => 'ADM - Funcionário',
            'dashboard' => 'Desativar conta',
            'employee' => $this->findEmployeeById($decEmployee)
        ];

        return view('adm/rh/employee/confirmDisable', $this->dataView);
    }

    /**
     * Desativa a conta do funcionário no banco
     *
     * @return object
     */
    public function confirmDisable(): object
    {
        $decEmployee = $this->decryptEmployeeId(
            $this->request->getPost('employee_id')
        );

        $this->employeeModel->where('id', $decEmployee)->set(['is_active' => false])->update();

        return redirect()->route('employee.list-search')->with('success', 'Operação realizada com sucesso!');
    }

    /**
     * Exibe a tela para confirmar a reativação da conta do funcionário
     *
     * @param string|null $employeeId
     * @return string
     */
    public function reactivate(string $employeeId = null): string
    {
        $decEmployee = $this->decryptEmployeeId($employeeId);

        $this->dataView = [
            'title' => 'ADM - Funcionário',
            'dashboard' => 'Reativar conta',
            'employee' => $this->findEmployeeById($decEmployee)
        ];

        return view('adm/rh/employee/confirmReactivate', $this->dataView);
    }

    /**
     * Reativa a conta do funcionário no banco
     *
     * @return object
     */
    public function confirmReactivate(): object
    {
        $decEmployee = $this->decryptEmployeeId(
            $this->request->getPost('employee_id')
        );

        $this->employeeModel->where('id', $decEmployee)->set(['is_active' => true])->update();

        return redirect()->route('employee.list-search')->with('success', 'Operação realizada com sucesso!');
    }

    /**
     * Persiste os dados do novo funcionário usando transaction
     *
     * @param array $employeeData
     * @return boolean
     */
    private function persistNewEmployee(array $employeeData): bool
    {
        $db = db_connect('default');

        $activationData = [
            'email' => $employeeData['email'],
            'token_hash' => $this->token->getTokenHash(),
            'created_at' => Date('Y-m-d H:i:s', time() + 3600)
        ];

        $db->transBegin();

        $this->employeeModel->skipValidation()->insert($employeeData);
        $this->activationTokensModel->insert($activationData);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return false;
        }

        $db->transCommit();
        return true;
    }

    /**
     * Envia o email com link para ativação da conta
     *
     * @param [type] $employeeData
     * @return void
     */
    private function sendActivationEmail($employeeData)
    {
        $this->mail->setFrom(env('email.fromEmail'), env('email.fromName'));
        $this->mail->setTo($employeeData['email']);
        $this->mail->setSubject('Email de teste');

        $employeeData['token'] = $this->token->getToken();
        $message = view('adm/rh/employee/components/emailActivation', $employeeData);

        $this->mail->setMessage($message);
        $this->mail->send();
    }

    /**
     * Função para decriptografar o id do funcionário
     *
     * @param string $employeeId
     * @return int
     */
    private function decryptEmployeeId(string|array|null $employeeId): int
    {
        $encrypt = Services::encrypter();

        try {
            return $encrypt->decrypt(hex2bin($employeeId));
        } catch (\Exception $th) {
            // echo $th->getMessage();
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Serviço não encontrado!');
        }
    }

    /**
     * Recupera dados do funcionário pelo id
     *
     * @param integer $employeeId
     * @return null|object
     */
    private function findEmployeeById(int $employeeId): null|object
    {
        return $this->employeeModel->find($employeeId);
    }
}
