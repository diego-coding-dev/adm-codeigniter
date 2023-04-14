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

        $this->dataView['orderList'] = $this->orderRepository->all();
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
        $decClientId = $this->decrypt($clientId);
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

    public function details(string $orderId)
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Pedido',
            'dashboard' => 'Detalhes do pedido',
            'orderId' => $orderId,
            'account' => $this->auth->data(),
            'client' => $this->orderRepository->belongsOneClient($this->decrypt($orderId)),
            'orderItens' => $this->orderRepository->hasManyItens($this->decrypt($orderId), true)
        ];

        return view('adm/delivery/order/details', $this->dataView);
    }

    /**
     * Exibe tela para confirmar o cancelamento do pedido
     * 
     * @return string
     */
    public function finish(string $orderId): string
    {
        $decOrderId = $this->decrypt($orderId);

        $this->dataView = [
            'title' => 'ADM - Deliveries',
            'dashboard' => 'Confirmar pedido',
            'client' => $this->orderRepository->belongsOneClient($decOrderId),
            'account' => $this->auth->data(),
            'orderId' => $orderId
        ];

        return view('adm/delivery/order/finish', $this->dataView);
    }

    /**
     * Efetua o registro do pedido
     * 
     * @param string $orderId
     * @return object
     * @throws type
     */
    public function finishConfirm(string $orderId): object
    {
        $decOrderId = $this->decrypt($orderId);

        if (!$this->orderRepository->finish($decOrderId)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Operação não realizada, contacte o administrador!');
        }

        return redirect()->route('order.list')->with('success', 'Pedidos registrado com sucesso!');
    }

    /**
     * Exibe tela para confirmar o cancelamento do pedido
     * 
     * @return string
     */
    public function cancel(string $orderId): string
    {
        $this->dataView = [
            'title' => 'ADM - Deliveries',
            'dashboard' => 'Cancelar pedido',
            'account' => $this->auth->data(),
            'orderId' => $orderId
        ];

        return view('adm/delivery/order/cancel', $this->dataView);
    }

    /**
     * Efetua o cancelamento do pedido
     * 
     * @param string $orderId
     * @return object
     * @throws type
     */
    public function cancelConfirm(string $orderId): object
    {
        $decOrderId = $this->decrypt($orderId);

        if (!$this->orderRepository->cancel($decOrderId)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Operação não realizada, contacte o administrador!');
        }

        return redirect()->route('order.list')->with('success', 'Pedidos cancelado com sucesso!');
    }

    /**
     * Função para decriptografar o id do cliente
     *
     * @param string $clientId
     * @return int
     */
    private function decrypt(string|array|null $clientId): int
    {
        try {
            return decrypt($clientId);
        } catch (\Exception $th) {
            // echo $th->getMessage();
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Serviço não encontrado!');
        }
    }

}
