<?php

namespace App\Controllers\Adm\Storage;

use App\Controllers\BaseController;
use CodeIgniter\Files\Exceptions\FileNotFoundException;
use CodeIgniter\Files\File;
use Exception;

class ProductController extends BaseController
{
    private array $dataView;
    private object $productModel;
    private object $typeProductModel;
    private object $image;
    private object $auth;

    public function __construct()
    {
        $this->productModel = service('model', 'Product');
        $this->typeProductModel = service('model', 'TypeProduct');
        $this->auth = service('auth', 'EmployeeAuthentication');
        $this->image = service('image', 'gd');
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

            if (!$this->productModel->forSearchProduct()->validate($this->request->getGet())) {
                return redirect()->back()->with('errors', $this->productModel->errors());
            }

            $this->dataView['description'] = $description;
            $this->dataView['productList'] = $this->productModel->like('description', $description)->orderBy('id', 'asc')->paginate(10);
        } else {
            $this->dataView['productList'] = $this->productModel->orderBy('id', 'asc')->paginate(10);
        }

        $this->dataView['pager'] = $this->productModel->pager;

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
            'typeProductList' => $this->typeProductModel->findAll()
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
        $imageValidationRules = $this->productModel->imagesValidationRules();

        if (!$this->productModel->validate($imageValidationRules)) {
            return redirect()->back()->with('errors', $this->productModel->errors());
        }

        $dataForm = $this->request->getPost();

        if (!$this->productModel->fieldsValidationRules()->validate($dataForm)) {
            return redirect()->back()->with('errors', $this->productModel->errors());
        }

        try {
            $dataForm['image'] = $this->storeProductImage($file);
            $this->persistProductDb($dataForm);

            return redirect()->route('product.list-search')->with('success', 'Produto registrado com sucesso!');
        } catch (Exception $e) {
            unlink(WRITEPATH . 'uploads/' . $dataForm['image']);
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Operação não realizada, contacte o administrador!');
        }
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

        $product = $this->findProductById($decProductId);

        $this->dataView = [
            'title' => 'ADM - Produtos',
            'dashboard' => 'Dados informacionais',
            'product' => $product,
            'active' => 'show',
            'productId' => $productId,
            'typeProduct' => $this->findTypeProductById($product->type_product_id),
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

        $product = $this->findProductById($decProductId);

        $this->dataView = [
            'title' => 'ADM - Produtos',
            'dashboard' => 'Dados informacionais',
            'product' => $product,
            'active' => 'image',
            'productId' => $productId,
            'typeProduct' => $this->findTypeProductById($product->type_product_id),
            'typeProductList' => $this->typeProductModel->findAll(),
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
        $decProductId = $this->decryptTypeProductId($productId);

        $product = $this->findProductById($decProductId);

        $image = $this->request->getFile('image');

        $imageValidation = $this->productModel->imagesValidationRules();

        if (!$this->productModel->validate($imageValidation)) {
            return redirect()->back()->with('errors', $this->productModel->errors());
        }

        try {
            $imageData['image'] = $this->storeProductImage($image);
            $imageData['product_id'] = $decProductId;

            $this->updateProductDb($imageData);
            $this->removeProductImage($product->image);

            return redirect()->route('product.list-search')->with('success', 'Produto atualizado com sucesso');
        } catch (FileNotFoundException $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Ler uma determinada imagem passada pelo URL
     *
     * @param string|null $image
     * @return void
     */
    public function image(string $image = null): void
    {
        $imagePath = WRITEPATH . env('storage.root') . env('storage.product') . DIRECTORY_SEPARATOR . $image;

        $file = new File($imagePath);

        header('Conten-Type:' . $file->getMimeType());
        header('Content-Length:' . $file->getSize());

        readfile($imagePath);

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
            'product' => $this->findProductById($decProductId)
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

        $this->productModel->where('id', $decProductId)->delete();

        return redirect()->route('product.list-search')->with('success', 'Produto removido com sucesso');
    }

    /**
     * Realiza o storage do imagem do produto no diretório
     *
     * @param object $file
     * @return string
     */
    private function storeProductImage(object $file): string
    {
        if (!$file->hasMoved()) {
            $filePath = WRITEPATH . 'uploads/' . $file->store(env('storage.product'));
        }

        $this->image->withFile($filePath)->fit(100, 100, 'center')->save($filePath);

        $filePathName = explode(DIRECTORY_SEPARATOR, $filePath);

        return end($filePathName);
    }

    /**
     * Remove a antiga imagem do produto
     *
     * @param string $image
     * @return void
     */
    private function removeProductImage(string $image)
    {
        $imagePath = WRITEPATH . env('storage.root') . env('storage.product') . DIRECTORY_SEPARATOR . $image;

        if (!file_exists($imagePath)) {
            throw new FileNotFoundException();
        }

        unlink($imagePath);

        return true;
    }

    /**
     * Persisti dados dps produto no banco de dados
     *
     * @param array $product
     * @return boolean
     */
    private function persistProductDb(array $product): bool
    {
        $this->productModel->skipValidation()->insert($product);

        return true;
    }

    /**
     * Atualiza dados dps produto no banco de dados
     *
     * @param array $product
     * @return boolean
     */
    private function updateProductDb(array $product): bool
    {
        $this->productModel->skipValidation()->where('id', $product['product_id'])->set(['image' => $product['image']])->update();

        return true;
    }

    /**
     * Recupera dados do produto pelo id
     *
     * @param integer $productId
     * @return null|object
     */
    private function findProductById(int $productId): null|object
    {
        return $this->productModel->find($productId);
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
