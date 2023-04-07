<?php

namespace App\Controllers\Adm\Rh;

use App\Controllers\BaseController;

class ClientController extends BaseController
{
    private array $dataView;
    private object $clientModel;
    private object $auth;

    public function __construct()
    {
        $this->clientModel = service('model', 'Client');
        $this->auth = service('auth', 'EmployeeAuthentication');
    }

    /**
     * Exibe tela com a lista de clientes
     *
     * @return string|object
     */
    public function listSearch()
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Clientes',
            'dashboard' => 'Lista de clientes',
            'account' => $this->auth->data()
        ];

        if (!is_null($name = $this->request->getGet('name'))) {

            if (!$this->clientModel->forSearchCliente()->validate($this->request->getGet())) {
                return redirect()->back()->with('errors', $this->clientModel->errors());
            }

            $this->dataView['name'] = $name;
            $this->dataView['clientList'] = $this->clientModel->where('type_user_id', 1)->like('name', $name)->orderBy('id', 'asc')->paginate(10);
        } else {
            $this->dataView['clientList'] = $this->clientModel->where('type_user_id', 1)->orderBy('id', 'asc')->paginate(10);
        }

        $this->dataView['pager'] = $this->clientModel->pager;

        return view('adm/rh/client/listSearch', $this->dataView);
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
            'title' => 'ADM - Cliente',
            'dashboard' => 'Adicionando novo cliente',
            'account' => $this->auth->data()
        ];

        return view('adm/rh/client/adding', $this->dataView);
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
        $dataForm['type_user_id'] = 1;

        if (!$this->clientModel->validate($dataForm)) {
            return redirect()->back()->with('errors', $this->clientModel->errors());
        }

        $this->clientModel->insert($dataForm);

        return redirect()->route('client.list-search')->with('success', 'Cliente registrado com sucesso!');
    }

     /**
     * Exibe tela com dados do cliente
     *
     * @param string|null $clientId
     * @return string
     */
    public function show(string $clientId = null): string
    {
        $decClientId = $this->decryptClientId($clientId);

        $this->dataView = [
            'title' => 'ADM - Funcionário',
            'dashboard' => 'Dados informacionais',
            'account' => $this->auth->data(),
            'client' => $this->findClientById($decClientId)
        ];

        return view('adm/rh/client/show', $this->dataView);
    }

    /**
     * Exibe a tela para confirmar a remoção do cliente
     *
     * @param string|null $clientId
     * @return string
     */
    public function remove(string $clientId = null): string
    {
        $decClientID = $this->decryptClientId($clientId);

        $this->dataView = [
            'title' => 'ADM - Funcionário',
            'dashboard' => 'Desativar conta',
            'account' => $this->auth->data(),
            'client' => $this->findClientById($decClientID)
        ];

        return view('adm/rh/client/confirmRemove', $this->dataView);
    }

    /**
     * Remove a conta do cliente no banco
     *
     * @return object
     */
    public function confirmRemove(): object
    {
        $encClientId = $this->request->getPost('client_id');
        $decClientID = $this->decryptClientId($encClientId);

        $this->clientModel->where('id', $decClientID)->delete();

        return redirect()->route('client.list-search')->with('success', 'Operação realizada com sucesso!');
    }

    /**
     * Função para decriptografar o id do cliente
     *
     * @param string $clientId
     * @return int
     */
    private function decryptClientId(string|array|null $clientId): int
    {
        try {
            return decrypt($clientId);
        } catch (\Exception $th) {
            // echo $th->getMessage();
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Serviço não encontrado!');
        }
    }

    /**
     * Recupera dados do cliente pelo id
     *
     * @param integer $clientId
     * @return null|object
     */
    private function findClientById(int $clientId): null|object
    {
        return $this->clientModel->find($clientId);
    }
}
