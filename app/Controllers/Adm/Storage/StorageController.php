<?php

namespace App\Controllers\Adm\Storage;

use App\Controllers\BaseController;

class StorageController extends BaseController
{
    private array $dataView;
    private object $storageModel;
    private object $typeProductModel;
    private object $image;
    private object $auth;
    private object $pager;

    public function __construct()
    {
        $this->storageModel = service('model', 'Storage');
        $this->auth = service('auth', 'EmployeeAuthentication');
        $this->pager = service('pager');
    }

    public function listSearch()
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Produtos',
            'dashboard' => 'Lista de produtos',
            'account' => $this->auth->data()
        ];

        if (!is_null($description = $this->request->getGet('description'))) {

            // if (!$this->productModel->forSearchProduct()->validate($this->request->getGet())) {
            //     return redirect()->back()->with('errors', $this->productModel->errors());
            // }

            $this->dataView['description'] = $description;
            $this->dataView['storageList'] = $this->getItensFromStorage($description);
        } else {
            $this->dataView['storageList'] = $this->getItensFromStorage();
        }

        $this->dataView['pager'] = $this->createPagerLinks();

        return view('adm/storage/storage/listSearch', $this->dataView);
    }

    private function getItensFromStorage(string $description = null)
    {
        $db = db_connect('default');

        $page = (int)($this->request->getGet('page') ?? 1);

        $offset = abs(($page - 1) * 2);

        if (!$description) {
            return $db->table('storages')
                ->select('storages.*, products.description, products.image')
                ->join('products', 'products.id = storages.product_id')
                ->limit(2)
                ->orderBy('storages.product_id', 'asc')
                ->offset($offset)
                ->get()
                ->getResultObject();
        }

        return $db->table('storages')
            ->select('storages.*, products.description, products.image')
            ->join('products', 'products.id = storages.product_id')
            ->like('description', $description)
            ->orderBy('storages.product_id', 'asc')
            ->limit(2)
            ->offset($offset)
            ->get()
            ->getResultObject();
    }

    private function createPagerLinks()
    {
        $page = (int)($this->request->getGet('page') ?? 1);

        $perPage = 2; // como se fosse offset

        $total = 5; // recuperar o total de registros baseado na cláusula da consulta

        return $this->pager->makeLinks($page, $perPage, $total);
    }
}
