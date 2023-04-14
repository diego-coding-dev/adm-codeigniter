<?php

namespace App\Repository\ORMdefault;

use App\Repository\BaseRepositoryInterface;
use CodeIgniter\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{

    protected Model $model;
    protected ?Model $view;

    public function __construct(Model $model, Model $view = null)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function add(array $data, bool $returnId = false): bool|int|string
    {
        $result = $this->model->insert($data);

        if (!$returnId) {
            return $result;
        }

        return $this->model->getInsertID();
    }

    public function all(bool $useView = false): array
    {
        if (!$useView) {
            return $this->model->orderBy('id', 'asc')->paginate(10);
        }

        return $this->view->orderBy('id', 'asc')->paginate(10);
    }

    public function find(int $id, bool $useView = false): object
    {
        if (!$useView) {
            return $this->model->find($id);
        }

        return $this->view->find($id);
    }

    public function getWhere(array $where, bool $useView = false): array
    {
        if (!$useView) {
            return $this->model->where($where)->orderBy('id', 'asc')->paginate(10);
        }

        return $this->view->where($where)->orderBy('id', 'asc')->paginate(10);
    }

    public function getWhereFirst(array $where, bool $useView = false): null|array|object
    {
        if (!$useView) {
            return $this->model->where($where)->first();
        }
        return $this->view->where($where)->first();
    }

    public function getLike(array $like, bool $useView = false): array
    {
        if (!$useView) {
            return $this->model->like($like)->orderBy('id', 'asc')->paginate(10);
        }

        return $this->view->like($like)->orderBy('id', 'asc')->paginate(10);
    }

    public function update(array $where, array $data): bool
    {
        return $this->model->where($where)->set($data)->update();
    }

    public function remove(int $id): bool
    {
        return $this->model->delete($id);
    }

    public function removeWhere(array $where): bool
    {
        return $this->model->where($where)->delete();
    }

}
