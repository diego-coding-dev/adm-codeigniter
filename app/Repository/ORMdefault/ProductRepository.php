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

    public function add(array $data): bool|string
    {
        $db = db_connect('default');

        $db->transBegin();

        $this->model->insert($data);

        $date = Date('Y-m-d H:i:s', time());
        
        $db->table('storages')->insert([
            'product_id' => $this->model->getInsertID(),
            'quantity' => 0,
            'created_at' => $date,
            'updated_at' => $date
        ]);

        if ($db->transStatus() === false) {

            $db->transRollback();
            return false;
        }

        $db->transCommit();
        return true;
    }

    public function getLike(array $like): array
    {
        return $this->model->like($like)->orderBy('id', 'asc')->paginate(10);
    }

    public function all(): array
    {
        return $this->model->orderBy('id', 'asc')->paginate(10);
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
