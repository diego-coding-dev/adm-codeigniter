<?php

namespace App\Controllers\Adm\Rh;

use App\Controllers\BaseController;

class EmployeeController extends BaseController
{
    private array $dataView;
    private object $employeeRepository;
    private object $validation;
    private object $email;
    private object $auth;

    public function __construct()
    {
        $this->employeeRepository = \Config\Services::repository('employee');
        $this->validation = \Config\Services::validationForm('employee');
        $this->email = \Config\Services::mail('employee');
        $this->auth = \Config\Services::auth('employee');
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
            'dashboard' => 'Lista de funcionários',
            'account' => $this->auth->data()
        ];

        $name = strval($this->request->getGet('name'));

        if (strlen($name) > 0) {

            if (is_array($errors = $this->validation->forSearchEmployee()->run($this->request->getGet()))) {
                return redirect()->back()->with('errors', $errors);
            }

            $this->dataView['name'] = $name;
            $this->dataView['employeeList'] = $this->employeeRepository->getLike(['name' => $name]);
        } else {
            $this->dataView['employeeList'] = $this->employeeRepository->all();
        }

        $this->dataView['pager'] = $this->employeeRepository->pager();

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
            'dashboard' => 'Adicionando novo funcionário',
            'account' => $this->auth->data()
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

        if (is_array($errors = $this->validation->forAddEmployee()->run($dataForm))) {
            return redirect()->back()->with('errors', $errors);
        }

        $result = $result = $this->employeeRepository->add($dataForm);

        if (!$result) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $dataForm['token'] = $result;

        $this->email->sendActivationEmail($dataForm);

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
        $decEmployeeId = $this->decryptEmployeeId($employeeId);

        $this->dataView = [
            'title' => 'ADM - Funcionário',
            'dashboard' => 'Dados informacionais',
            'account' => $this->auth->data(),
            'employee' => $this->employeeRepository->find($decEmployeeId)
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
        $decEmployeeId = $this->decryptEmployeeId($employeeId);

        $this->dataView = [
            'title' => 'ADM - Funcionário',
            'dashboard' => 'Desativar conta',
            'employeeId' => $employeeId,
            'account' => $this->auth->data(),
            'employee' => $this->employeeRepository->find($decEmployeeId)
        ];

        return view('adm/rh/employee/confirmDisable', $this->dataView);
    }

    /**
     * Desativa a conta do funcionário no banco
     *
     * @return object
     */
    public function confirmDisable(string $employeeId = null): object
    {
        $decEmployeeId = $this->decryptEmployeeId($employeeId);

        $this->employeeRepository->update($decEmployeeId, ['is_active' => false]);

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
        $decEmployeeId = $this->decryptEmployeeId($employeeId);

        $this->dataView = [
            'title' => 'ADM - Funcionário',
            'dashboard' => 'Reativar conta',
            'employeeId' => $employeeId,
            'account' => $this->auth->data(),
            'employee' => $this->employeeRepository->find($decEmployeeId)
        ];

        return view('adm/rh/employee/confirmReactivate', $this->dataView);
    }

    /**
     * Reativa a conta do funcionário no banco
     *
     * @return object
     */
    public function confirmReactivate(string $employeeId = null): object
    {
        $decEmployeeId = $this->decryptEmployeeId($employeeId);

        $this->employeeRepository->update($decEmployeeId, ['is_active' => true]);

        return redirect()->route('employee.list-search')->with('success', 'Operação realizada com sucesso!');
    }

    /**
     * Função para decriptografar o id do funcionário
     *
     * @param string $employeeId
     * @return int
     */
    private function decryptEmployeeId(string|array|null $employeeId): int
    {
        try {
            return decrypt($employeeId);
        } catch (\Exception $th) {
            // echo $th->getMessage();
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Serviço não encontrado!');
        }
    }
}
