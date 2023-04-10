<?php

namespace App\Repository\ORMdefault;

use App\Models\TypeProduct;
use App\Repository\DefaulRepositoryInterface;
use App\Repository\Trait\PagerTrait;

class TypeProductRepository extends BaseRepository implements DefaulRepositoryInterface
{
    use PagerTrait;

    public function __construct()
    {
        parent::__construct(new TypeProduct());
    }

    public function add(array $data): bool|string
    {
        return $this->model->insert($data);
    }

    public function all(): array
    {
        return $this->model->orderBy('id', 'asc')->paginate(10);
    }

    public function getLike(string $like): array
    {
        return $this->model->like('type_product', $like)->orderBy('id', 'asc')->paginate(10);
    }
}
