<?php

namespace App\Repository\ORMdefault;

use App\Repository\BaseRepositoryInterface;
use CodeIgniter\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;
    protected Model $view;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // public abstract function getLike(string $like): array;

    // public abstract function all(): array;

    // public abstract function add(array $data): bool|string;

    public function find(int $id): object
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->where('id', $id)->set($data)->update();
    }

    public function remove(int $id)
    {
        return $this->model->where('id', $id)->delete();
    }
}
