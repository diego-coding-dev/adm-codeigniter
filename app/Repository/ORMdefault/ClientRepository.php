<?php

namespace App\Repository\ORMdefault;

use App\Models\Client;
use App\Repository\DefaulRepositoryInterface;
use App\Repository\Trait\PagerTrait;

class ClientRepository extends BaseRepository implements DefaulRepositoryInterface
{
    use PagerTrait;

    public function __construct()
    {
        parent::__construct(new Client());
    }

    public function add(array $data): bool|string
    {
        return $this->model->insert($data);
    }

    public function getLike(array $like): array
    {
        return $this->model->where('type_user_id', 1)->like($like)->orderBy('id', 'asc')->paginate(10);
    }

    public function all(): array
    {
        return $this->model->where('type_user_id', 1)->orderBy('id', 'asc')->paginate(10);
    }
}
