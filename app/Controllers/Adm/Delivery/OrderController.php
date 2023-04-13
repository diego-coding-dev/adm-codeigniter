<?php

namespace App\Controllers\Adm\Delivery;

use App\Controllers\BaseController;

class OrderController extends BaseController
{

    private array $dataView;
    private object $orderRepository;
    private object $clientRepository;
    private object $validation;
    private object $auth;

    public function __construct()
    {
        $this->orderRepository = \Config\Services::repository('order');
        $this->clientRepository = \Config\Services::repository('client');
        $this->validation = \Config\Services::validationForm('order');
        $this->auth = \Config\Services::auth('employee');
    }

    /**
     * Retorna a tela com a lista de pedidos efetuados
     * 
     * @return object|string
     */
    public function list(): object|string
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Deliveries',
            'dashboard' => 'Últimas entregas',
            'account' => $this->auth->data()
        ];

        $dataForm = $this->request->getGet();

        // desabilidato, implementar uma pesquisa baseado em datas
        if (count($dataForm) > 0) {
//            if (is_array($errors = $this->validation->onlyName()->run($this->request->getGet()))) {
//                return redirect()->back()->with('errors', $errors);
//            }
//
//            $this->dataView['name'] = $name;
//            $this->dataView['orderList'] = $this->orderRepository->getLike(['name' => $name], true);
        } else {
            $this->dataView['orderList'] = $this->orderRepository->all(true);
        }

        $this->dataView['pager'] = $this->orderRepository->pager();

        return view('adm/delivery/order/listSearch', $this->dataView);
    }

    /**
     * Retorna tela com a lista de clientes disponíveis
     * 
     * @return object|string
     */
    public function listClient(): object|string
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Deliveries',
            'dashboard' => 'Registrando novo pedido',
            'account' => $this->auth->data(),
        ];

        $dataForm = $this->request->getGet();

        if (count($dataForm) > 0) {
            if (is_array($errors = $this->validation->onlyName()->run($dataForm))) {
                return redirect()->back()->with('errors', $errors);
            }

            $this->dataView['name'] = $dataForm['name'];
            $this->dataView['clientList'] = $this->clientRepository->getLike($dataForm);
        } else {
            $this->dataView['clientList'] = $this->clientRepository->all();
        }

        $this->dataView['pager'] = $this->clientRepository->pager();

        return view('adm/delivery/order/listClient', $this->dataView);
    }

    /**
     * Seleciona o cliente e registra um pedido, mas antes verifica se já existe um pedido em aberto
     * 
     * @param string $clientId
     * @return object
     */
    public function selectClient(string $clientId): object
    {
        $decClientId = $this->decryptUrlId($clientId);
        $hasOrderNotSettled = $this->orderRepository->hasOneNotSettled($decClientId);

        if (!$hasOrderNotSettled) {

            $orderData = [
                'client_id' => $decClientId,
                'employee_id' => $this->auth->id(),
                'register' => bin2hex(random_bytes(5))
            ];

            $orderId = $this->orderRepository->add($orderData, true);

            return redirect()->route('order.order-cart-show', [encrypt($orderId)])->with('success', 'Pedido aberto com sucesso!');
        }

        return redirect()->route('order.order-cart-show', [encrypt($hasOrderNotSettled->id)])->with('warning', 'Este cliente possui um pedido em aberto!');
    }

    /**
     * Função para decriptografar o id do cliente
     *
     * @param string $clientId
     * @return int
     */
    private function decryptUrlId(string|array|null $clientId): int
    {
        try {
            return decrypt($clientId);
        } catch (\Exception $th) {
            // echo $th->getMessage();
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Serviço não encontrado!');
        }
    }

}
