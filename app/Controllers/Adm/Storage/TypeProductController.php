<?php

namespace App\Controllers\Adm\Storage;

use App\Controllers\BaseController;

class TypeProductController extends BaseController
{
    private array $dataView;
    private object $typeProductRepository;
    private object $validation;
    private object $auth;

    /**
     * Exibe tela com a lista de categorias de produto
     *
     * @return string|object
     */
    public function __construct()
    {
        $this->typeProductRepository =\Config\Services::repository('typeProduct');
        $this->validation =\Config\Services::validationForm('typeProduct');
        $this->auth =\Config\Services::auth('EmployeeAuthentication');
    }

    /**
     * Exibe tela com a lista de categoria de produtos
     *
     * @return string|object
     */
    public function listSearch(): string| object
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Categorias de produto',
            'dashboard' => 'Lista de categorias',
            'account' => $this->auth->data()
        ];

        $typeProduct = strval($this->request->getGet('type_product'));

        if (strlen($typeProduct) > 0) {

            if (is_array($errors = $this->validation->forSearchTypeProduct()->run($this->request->getGet()))) {
                return redirect()->back()->with('errors', $errors);
            }

            $this->dataView['typeProduct'] = $typeProduct;
            $this->dataView['typeProductList'] = $this->typeProductRepository->getLike(['type_product' => $typeProduct]);
        } else {
            $this->dataView['typeProductList'] = $this->typeProductRepository->all();
        }

        $this->dataView['pager'] = $this->typeProductRepository->pager();

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

        if (is_array($errors = $this->validation->run($dataForm))) {
            return redirect()->back()->with('errors', $errors);
        }

        $this->typeProductRepository->add($dataForm);

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
            'typeProduct' => $this->typeProductRepository->find($decTypeProductId)
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
            'typeCategoryId' => $typeCategoryId,
            'account' => $this->auth->data(),
            'typeProduct' => $this->typeProductRepository->find($decTypeProductId)
        ];

        return view('adm/storage/typeProduct/confirmRemove', $this->dataView);
    }

    /**
     * Remove a categoria de produto no banco
     *
     * @return object
     */
    public function confirmRemove(string $typeCategoryId = null): object
    {
        $decTypeProductId = $this->decryptTypeProductId($typeCategoryId);

        $this->typeProductRepository->remove($decTypeProductId);

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
            throw \CodeIgniter\Encryption\Exceptions\EncryptionException::forEncryptionFailed();
        }
    }
}
