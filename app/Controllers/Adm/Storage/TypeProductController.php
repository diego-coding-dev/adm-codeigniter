<?php

namespace App\Controllers\Adm\Storage;

use App\Controllers\BaseController;

class TypeProductController extends BaseController
{
    private array $dataView;
    private object $typeProductModel;
    private object $auth;

    /**
     * Exibe tela com a lista de categorias de produto
     *
     * @return string|object
     */
    public function __construct()
    {
        $this->typeProductModel = service('model', 'TypeProduct');
        $this->auth = service('auth', 'EmployeeAuthentication');
    }

    public function listSearch()
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Categorias de produto',
            'dashboard' => 'Lista de categorias',
            'account' => $this->auth->data()
        ];

        if (!is_null($typeProduct = $this->request->getGet('type_product'))) {

            if (!$this->typeProductModel->forSearchTypeProduct()->validate($this->request->getGet())) {
                return redirect()->back()->with('errors', $this->typeProductModel->errors());
            }

            $this->dataView['typeProduct'] = $typeProduct;
            $this->dataView['typeProductList'] = $this->typeProductModel->like('type_product', $typeProduct)->orderBy('id', 'asc')->paginate(10);
        } else {
            $this->dataView['typeProductList'] = $this->typeProductModel->orderBy('id', 'asc')->paginate(10);
        }

        $this->dataView['pager'] = $this->typeProductModel->pager;

        return view('adm/storage/typeProduct/listSearch', $this->dataView);
    }

    /**
     * Exibe tela para registrar uma nova categoria
     *
     * @return string
     */
    public function adding(): string
    {
        // colocar filtro para checar se é get (middleware)
        $this->dataView = [
            'title' => 'ADM - Categorias de produto',
            'dashboard' => 'Adicionando nova categoria',
            'account' => $this->auth->data()
        ];

        return view('adm/storage/typeProduct/adding', $this->dataView);
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

        if (!$this->typeProductModel->validate($dataForm)) {
            return redirect()->back()->with('errors', $this->typeProductModel->errors());
        }

        $this->typeProductModel->insert($dataForm);

        return redirect()->route('type-product.list-search')->with('success', 'Categoria registrada com sucesso!');
    }

    /**
     * Exibe tela com dados da categoria d o produto
     *
     * @param string|null $typeCategoryId
     * @return string
     */
    public function show(string $typeCategoryId = null): string
    {
        $decTypeProductId = $this->decryptTypeProductId($typeCategoryId);

        $this->dataView = [
            'title' => 'ADM - Categorias de produto',
            'dashboard' => 'Dados informacionais',
            'account' => $this->auth->data(),
            'typeProduct' => $this->findTypeProductById($decTypeProductId)
        ];

        return view('adm/storage/typeProduct/show', $this->dataView);
    }

    /**
     * Exibe a tela para confirmar a remoção da categoria de produto
     *
     * @param string|null $typeCategoryId
     * @return string
     */
    public function remove(string $typeCategoryId = null): string
    {
        $decTypeProductId = $this->decryptTypeProductId($typeCategoryId);

        $this->dataView = [
            'title' => 'ADM - Categorias de produto',
            'dashboard' => 'Remover categoria',
            'account' => $this->auth->data(),
            'typeProduct' => $this->findTypeProductById($decTypeProductId)
        ];

        return view('adm/storage/typeProduct/confirmRemove', $this->dataView);
    }

    /**
     * Remove a categoria de produto no banco
     *
     * @return object
     */
    public function confirmRemove(): object
    {
        $encTypeProductId = $this->request->getPost('type_product_id');
        $decTypeProductId = $this->decryptTypeProductId($encTypeProductId);

        $this->typeProductModel->where('id', $decTypeProductId)->delete();

        return redirect()->route('type-product.list-search')->with('success', 'Operação realizada com sucesso!');
    }

    /**
     * Função para decriptografar o id da categoria
     *
     * @param string $typeProductId
     * @return int
     */
    private function decryptTypeProductId(string|array|null $typeProductId): int
    {
        try {
            return decrypt($typeProductId);
        } catch (\Exception $th) {
            // echo $th->getMessage();
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Serviço não encontrado!');
        }
    }

    /**
     * Recupera dados da categoria do produto pelo id
     *
     * @param integer $typeProductId
     * @return null|object
     */
    private function findTypeProductById(int $typeProductId): null|object
    {
        return $this->typeProductModel->find($typeProductId);
    }
}
