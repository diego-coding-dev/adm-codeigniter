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
        return $this->model->insert($data);
    }

    public function getLike(string $like): array
    {
        return $this->model->like('description', $like)->orderBy('id', 'asc')->paginate(10);
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
