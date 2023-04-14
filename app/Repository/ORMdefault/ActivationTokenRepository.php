<?php

namespace App\Repository\ORMdefault;

use App\Models\ActivationTokens;
use App\Repository\DefaulRepositoryInterface;

class ActivationTokenRepository extends BaseRepository implements DefaulRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new ActivationTokens());
    }

    public function getBy(array $data, $first = false): null|object
    {
        if (!$first) {
            return $this->model->where($data)->findAll();
        }

        return $this->model->where($data)->first();
    }

    public function update(array $where, array $data): bool
    {
        return $this->model->where($where)->set($data)->update();
    }

    public function removeBy(array $data): bool
    {
        return $this->model->where($data)->delete();
    }
}
