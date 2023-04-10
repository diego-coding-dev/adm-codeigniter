<?php

namespace App\Controllers\Adm\Storage;

use App\Controllers\BaseController;
use CodeIgniter\Files\Exceptions\FileNotFoundException;

class ProductController extends BaseController
{
    private array $dataView;
    private object $productRepository;
    private object $validation;
    private object $file;
    private object $auth;

    public function __construct()
    {
        $this->productRepository = service('repository', 'product');
        $this->validation = service('validationForm', 'product');
        $this->file = service('file', 'images');
        $this->auth = service('auth', 'EmployeeAuthentication');
    }

    /**
     * Exibe tela com a lista de produtos
     *
     * @return string|object
     */
    public function listSearch(): string| object
    {
        // colocar filtro para saber se é ajax (middleware)
        $this->dataView = [
            'title' => 'ADM - Produtos',
            'dashboard' => 'Lista de produtos',
            'account' => $this->auth->data()
        ];

        if (!is_null($description = $this->request->getGet('description'))) {

            if (is_array($errors = $this->validation->forSearchProduct()->run($this->request->getGet()))) {
                return redirect()->back()->with('errors', $errors);
            }

            $this->dataView['description'] = $description;
            $this->dataView['productList'] = $this->productRepository->getLike($description);
        } else {
            $this->dataView['productList'] = $this->productRepository->all();
        }

        $this->dataView['pager'] = $this->productRepository->pager();

        return view('adm/storage/product/listSearch', $this->dataView);
    }

    /**
     * Exibe tela para registrar um novo produto
     *
     * @return string
     */
    public function adding(): string
    {
        // colocar filtro para checar se é get (middleware)
        $this->dataView = [
            'title' => 'ADM - Produtos',
            'dashboard' => 'Adicionando novo produto',
            'account' => $this->auth->data(),
            'typeProductList' => $this->productRepository->allCategories()
        ];

        return view('adm/storage/product/adding', $this->dataView);
    }

    /**
     * Registra um novo produto
     *
     * @return object
     */
    public function add(): object
    {
        // colocar filtro para checar se é post (middleware)
        $file = $this->request->getFile('image');

        $imageValidationRules = $this->validation->imagesValidationRules();

        if (!$this->validate($imageValidationRules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $dataForm = $this->request->getPost();

        if (is_array($errors = $this->validation->fieldsValidationRules()->run($dataForm))) {
            return redirect()->back()->with('errors', $errors);
        }

        $dataForm['file'] = $file;

        if (!$this->addProduct($dataForm)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Operação não realizada, contacte o administrador!');
        }

        return redirect()->route('product.list-search')->with('success', 'Produto registrado com sucesso!');
    }

    /**
     * Exibe tela com dados sobre produto
     *
     * @param string|null $productId
     * @return string
     */
    public function show(string $productId = null): string
    {
        $decProductId = $this->decryptTypeProductId($productId);

        $product = $this->productRepository->find($decProductId);

        $this->dataView = [
            'title' => 'ADM - Produtos',
            'dashboard' => 'Dados informacionais',
            'product' => $product,
            'active' => 'show',
            'productId' => $productId,
            'typeProduct' => $this->productRepository->category($product->type_product_id),
            'account' => $this->auth->data()
        ];

        return view('adm/storage/product/show', $this->dataView);
    }

    /**
     * Exibe tela para alterar imagem do produto
     *
     * @param string|null $productId
     * @return string
     */
    public function changeImage(string $productId = null): string
    {
        $decProductId = $this->decryptTypeProductId($productId);

        $product = $this->productRepository->find($decProductId);

        $this->dataView = [
            'title' => 'ADM - Produtos',
            'dashboard' => 'Dados informacionais',
            'product' => $product,
            'active' => 'image',
            'productId' => $productId,
            'typeProduct' => $this->productRepository->category($product->type_product_id),
            'typeProductList' => $this->productRepository->allCategories(),
            'account' => $this->auth->data()
        ];

        return view('adm/storage/product/changeImage', $this->dataView);
    }

    /**
     * Undocumented function
     *
     * @param string|null $productId
     * @return object
     */
    public function saveImage(string $productId = null): object
    {
        $file = $this->request->getFile('image');

        $imageValidationRules = $this->validation->imagesValidationRules();

        if (!$this->validate($imageValidationRules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $decProductId = $this->decryptTypeProductId($productId);
        $product = $this->productRepository->find($decProductId);

        $dataProduct['file'] = $file;
        $dataProduct['id'] = $product->id;
        $dataProduct['current_image'] = $product->image;

        if (!$this->updateProduct($dataProduct)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Operação não realizada, contacte o administrador!');
        }

        return redirect()->route('product.list-search')->with('success', 'Produto atualizado com sucesso');
    }

    /**
     * Ler uma determinada imagem passada pelo URL
     *
     * @param string|null $image
     * @return void
     */
    public function image(string $image = null): void
    {
       $data = $this->file->retrieve($image);

        header('Conten-Type:' . $data['type']);
        header('Content-Length:' . $data['length']);

        readfile($data['file']);

        exit();
    }

    /**
     * Exibe tela para confirmar exclusão do produto
     *
     * @param string|null $productId
     * @return string
     */
    public function remove(string $productId = null): string
    {
        $decProductId = $this->decryptTypeProductId($productId);

        $this->dataView = [
            'title' => 'ADM - Produtos',
            'dashboard' => 'Remover produto',
            'productId' => $productId,
            'account' => $this->auth->data(),
            'product' => $this->productRepository->find($decProductId)
        ];

        return view('adm/storage/product/confirmRemove', $this->dataView);
    }

    /**
     * Remove produto do banco de dados
     *
     * @param string|null $productID
     * @return object
     */
    public function confirmRemove(string $productId = null): object
    {
        $decProductId = $this->decryptTypeProductId($productId);

        $this->productRepository->remove($decProductId);

        return redirect()->route('product.list-search')->with('success', 'Produto removido com sucesso');
    }

    /**
     * Registra o novo produto no sistema
     *
     * @param array $product
     * @return boolean
     */
    private function addProduct(array $product): bool
    {
        try {
            $product['image'] = $this->file->store($product['file'], env('storage.product'));

            unset($product['file']);

            $this->productRepository->add($product);

            return true;
        } catch (\Exception $e) {
            $this->file->remove($product['image'], env('storage.product'));
            return false;
        }
    }

    /**
     * Atualiza dados do produto
     *
     * @param array $product
     * @return boolean
     */
    private function updateProduct(array $product): bool
    {
        try {
            $newDataProduct['image'] = $this->file->store($product['file'], env('storage.product'));

            $this->file->remove($product['current_image'], env('storage.product'));

            unset($product['file']);
            unset($product['product']);

            $this->productRepository->update($product['id'], $newDataProduct);

            return true;
        } catch (FileNotFoundException $th) {
            $this->file->remove($product['image'], env('storage.product'));

            return false;
        }
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
            // echo $th->getMessage();
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Operação não realizada, contacte o administrado!');
        }
    }
}
