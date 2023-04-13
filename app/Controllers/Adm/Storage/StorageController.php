<?php

namespace App\Controllers\Adm\Storage;

use App\Controllers\BaseController;

class StorageController extends BaseController
{

    private array $dataView;
    private object $storageRepository;
    private object $validation;
    private object $auth;

    public function __construct()
    {
        $this->storageRepository = \Config\Services::repository('storage');
        $this->validation = \Config\Services::validationForm('storage');
        $this->auth = \Config\Services::auth('employee');
    }

    /**
     * Exibe tela com a lista de produtos no estoque
     *
     * @return string|object
     */
    public function listSearch()
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Estoque',
            'dashboard' => 'Lista de itens no estoque',
            'account' => $this->auth->data()
        ];

        $dataForm = $this->request->getGet();

        if (count($dataForm) > 0) {
            if (is_array($errors = $this->validation->onlyDescription(true)->run($dataForm))) {
                return redirect()->back()->with('errors', $errors);
            }

            $this->dataView['description'] = $dataForm['description'];
            $this->dataView['storageList'] = $this->storageRepository->getLike($dataForm, true);
            $this->dataView['pager'] = $this->storageRepository->pager(true);
        } else {
            $this->dataView['storageList'] = $this->storageRepository->all(true);
            $this->dataView['pager'] = $this->storageRepository->pager(true);
        }

        return view('adm/storage/storage/listSearch', $this->dataView);
    }

    public function show(string $storageId = null)
    {
        $decStorageId = $this->decryptTypeProductId($storageId);

        $storage = $this->storageRepository->find($decStorageId, true);

        $this->dataView = [
            'title' => 'ADM - Produtos',
            'dashboard' => 'Dados informacionais',
            'storage' => $storage,
            'active' => 'show',
            'storageId' => $storageId,
            'typeProduct' => $this->storageRepository->category($storage->type_product_id),
            'account' => $this->auth->data()
        ];

        return view('adm/storage/storage/show', $this->dataView);
    }

    function add(string $storageId)
    {
        $decStorageId = $this->decryptTypeProductId($storageId);

        $storage = $this->storageRepository->find($decStorageId, true);

        $this->dataView = [
            'title' => 'ADM - Produtos',
            'dashboard' => 'Dados informacionais',
            'storage' => $storage,
            'active' => 'add',
            'storageId' => $storageId,
            'typeProduct' => $this->storageRepository->category($storage->type_product_id),
            'account' => $this->auth->data()
        ];

        return view('adm/storage/storage/add', $this->dataView);
    }

    public function addUnits(string $storageId)
    {
        $decStorageId = $this->decryptTypeProductId($storageId);
        $dataForm = $this->request->getPost();

        if (is_array($errors = $this->validation->onlyQuantity()->run($dataForm))) {
            return redirect()->back()->with('errors', $errors);
        }

        $this->storageRepository->update(['id' => $decStorageId], $dataForm);

        return redirect()->route('storage.list-search')->with('success', '* Estoque adicionado com sucesso!');
    }

    /**
     * Função para decriptografar o id do produto
     *
     * @param string $productId
     * @return int
     */
    private function decryptTypeProductId(string|array|null $productId): int
    {
        try {
            return decrypt($productId);
        } catch (\Exception $th) {
            throw \CodeIgniter\Encryption\Exceptions\EncryptionException::forEncryptionFailed();
        }
    }

}
