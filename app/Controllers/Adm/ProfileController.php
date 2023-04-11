<?php

namespace App\Controllers\Adm;

use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    private array $dataView;
    private object $employeeRepository;
    private object $validation;
    private object $auth;

    public function __construct()
    {
        $this->auth =\Config\Services::auth('employee');
        $this->employeeRepository =\Config\Services::repository('employee');
        $this->validation =\Config\Services::validationForm('employee');
    }

    /**
     * Retorna tela com informações da conta
     *
     * @return string
     */
    public function myProfile(): string
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Profile',
            'dashboard' => 'Profile',
            'account' => $this->auth->data()
        ];

        return view('adm/profile/myProfile', $this->dataView);
    }

    /**
     * Exibe tela de configurações da conta
     *
     * @return string
     */
    public function profileSettings(): string
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Profile',
            'dashboard' => 'Profile',
            'account' => $this->auth->data()
        ];

        return view('adm/profile/profileSettings', $this->dataView);
    }

    /**
     * Exibe tela de editar dados da conta
     *
     * @return string
     */
    public function edit(): string
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Profile',
            'dashboard' => 'Profile',
            'active' => 'edit',
            'account' => $this->auth->data()
        ];

        return view('adm/profile/edit', $this->dataView);
    }

    /**
     * Atualiza dados da conta
     *
     * @return object
     */
    public function saveEdit(): object
    {
        $dataForm = $this->checkEmptyFields($this->request->getPost());

        if (count($dataForm) < 1) {
            return redirect()->back()->with('warning', 'Não há dados para atualizar!');
        }

        if (is_array($errors = $this->validation->onlyEmail()->run($dataForm))) {
            return redirect()->back()->with('errors', $errors);
        }

        $this->employeeRepository->update($this->auth->id(), $dataForm);

        return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
    }

    /**
     * Exibe tela para atualizar a senha da conta
     *
     * @return string
     */
    public function password(): string
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Profile',
            'dashboard' => 'Profile',
            'active' => 'password',
            'account' => $this->auth->data()
        ];

        return view('adm/profile/password', $this->dataView);
    }

    /**
     * Atualiza a senha
     *
     * @return object
     */
    public function savePassword(): object
    {
        $dataForm = $this->request->getPost();

        $account = $this->employeeRepository->find($this->auth->id());

        if (is_array($errors = $this->validation->onlyPassword()->run($dataForm))) {
            return redirect()->back()->with('errors', $errors);
        }

        if (!$account->verifyPassword($dataForm['current_password'])) {
            return redirect()->back()->with('errors', ['current_password' => '* Senha atual não é igual!']);
        }

        $this->employeeRepository->update($account->id, ['password' => $dataForm['password']]);

        return redirect()->back()->with('success', 'Senha atualizada com sucesso!');
    }

    /**
     * Realiza o logout da conta
     *
     * @return object
     */
    public function logout(): object
    {
        $this->auth->logout();

        return redirect()->route('authentication');
    }

    /**
     * FUnção para verificar campos vazios
     *
     * @param array $fields
     * @return array
     */
    private function checkEmptyFields(array $fields): array
    {
        foreach ($fields as $key => $field) {
            if (strlen($field) < 1) {
                unset($fields[$key]);
            }
        }

        return $fields;
    }
}
