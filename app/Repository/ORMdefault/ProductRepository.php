<?php

namespace App\Repository\ORMdefault;

use App\Models\Product;
use App\Repository\DefaulRepositoryInterface;
use App\Repository\Trait\PagerTrait;

class ProductRepository extends BaseRepository implements DefaulRepositoryInterface
{

    use PagerTrait;

    public function __construct()
    {
        parent::__construct(new Product());
    }

    public function register(array $data, bool $returnId = false): bool|int|string
    {
        $db = db_connect('default');
        $storageRepository = \Config\Services::repository('storage');

        $db->transBegin();

        $productId = parent::add($data, true);

        $date = Date('Y-m-d H:i:s', time());

        $storageRepository->add([
            'product_id' => $productId,
            'quantity1' => 0,
            'created_at' => $date,
            'updated_at' => $date
        ]);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return false;
        }
        throw new \CodeIgniter\Database\Exceptions\DatabaseException();

        $db->transCommit();

        if (!$returnId) {
            return true;
        }

        return $productId;
    }

    public function allCategories(): array
    {
        return service('repository', 'typeProduct')->all();
    }

    public function category(int $id)
    {
        return service('repository', 'typeProduct')->find($id);
    }

}
