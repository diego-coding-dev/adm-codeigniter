<?php

namespace App\Controllers\Adm\Delivery;

use App\Controllers\BaseController;

class OrderCartController extends BaseController
{

    private array $dataView;
    private object $orderRepository;
    private object $orderCartRepository;
    private object $storageRepository;
    private object $validation;
    private object $auth;

    public function __construct()
    {
        $this->orderRepository = \Config\Services::repository('order');
        $this->storageRepository = \Config\Services::repository('storage');
        $this->orderCartRepository = \Config\Services::repository('orderCart');
        $this->validation = \Config\Services::validationForm('orderCart');
        $this->auth = \Config\Services::auth('employee');
    }

    /**
     * Exibe tela com os dados do cliente e do pedido
     * 
     * @param string $orderId
     * @return string
     */
    public function show(string $orderId): string
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Carrinho de itens',
            'dashboard' => 'Registrando novo pedido',
            'orderId' => $orderId,
            'account' => $this->auth->data(),
            'client' => $this->orderRepository->belongsOneClient($this->decrypt($orderId)),
            'cartItens' => $this->orderCartRepository->getWhere([
                'order_id' => $this->decrypt($orderId)
                    ], true)
        ];

        return view('adm/delivery/orderCart/show', $this->dataView);
    }

    /**
     * Exibe tela com a lista de itens disponíveis no estoque
     * 
     * @param string $orderId
     * @return string
     */
    public function addingItem(string $orderId): string
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Estoque',
            'dashboard' => 'Lista de itens no estoque',
            'orderId' => $orderId,
            'account' => $this->auth->data()
        ];

        $dataForm = $this->request->getGet();

        if (count($dataForm) > 0) {
            if (is_array($errors = $this->validation->onlyDescription()->run($dataForm))) {
                return redirect()->back()->with('errors', $errors);
            }

            $this->dataView['description'] = $dataForm['description'];
            $this->dataView['storageList'] = $this->storageRepository->getLike($dataForm, true);
            $this->dataView['pager'] = $this->storageRepository->pager(true);
        } else {
            $this->dataView['storageList'] = $this->storageRepository->all(true);
            $this->dataView['pager'] = $this->storageRepository->pager(true);
        }

        session()->setTempdata('order_id', $orderId, 2400);

        return view('adm/delivery/orderCart/addingItem', $this->dataView);
    }

    /**
     * Exibe tela para adicionar a quantidade de determinado item
     * 
     * @param string $storageId
     * @return string
     */
    public function addItemQuantity(string $storageId): string
    {
        $decStorageId = $this->decrypt($storageId);

        $storageData = $this->storageRepository->find($decStorageId);

        if ($storageData->quantity < 1) {
            return redirect()->back()->with('warning', 'Não há estoque para este item!');
        }

        $orderCartExists = $this->orderCartRepository->getWhereFirst(['storage_id' => $decStorageId]);

        if (!$orderCartExists) {
            $this->dataView = [
                'title' => 'ADM - Carrinho de itens',
                'dashboard' => 'Adicionando a quantidade',
                'storageId' => $storageId,
                'account' => $this->auth->data()
            ];

            return view('adm/delivery/orderCart/addItem', $this->dataView);
        }

        return redirect()->back()->with('warning', 'Produto já está adicionado, tente excluí-lo primeiro!');
    }

    /**
     * Adiciona item no carrinho
     * 
     * @param string $storageId
     * @return string
     * @throws type
     */
    public function addItem(string $storageId): string
    {
        $formData = $this->request->getPost();

        if (is_array($errors = $this->validation->onlyQuantity()->run($formData))) {
            return redirect()->back()->with('errors', $errors);
        }

        $cartItemData = [
            'order_id' => $this->decrypt($formData['order_id']),
            'storage_id' => $this->decrypt($storageId),
            'quantity' => $formData['quantity']
        ];

        if (!$this->orderCartRepository->add($cartItemData)) {
            session()->remove('order_id');
            session()->setFlashdata('route', 'order.list');
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $orderId = session()->getTempdata('order_id');
        session()->remove('order_id');
        return redirect()->route('order.order-cart-show', [$orderId])->with('success', 'Produto adicionado ao carrinho!');
    }

    /**
     * Remove item do carrinho
     * 
     * @param string $itemId
     * @return string
     * @throws type
     */
    public function removeItem(string $itemId): string
    {
        $decItemId = $this->decrypt($itemId);

        if (!$this->orderCartRepository->remove($decItemId)) {
            session()->remove('order_id');
            session()->setFlashdata('route', 'order.list');
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return redirect()->back()->with('success', 'Item removido!');
    }

    /**
     * Função para descriptografar determinado valor
     *
     * @param string $value
     * @return int
     */
    private function decrypt(string|array|null $value): int
    {
        try {
            return decrypt($value);
        } catch (\Exception $th) {
            // echo $th->getMessage();
            session()->setFlashdata('route', 'order.list');
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Serviço não encontrado!');
        }
    }

}
