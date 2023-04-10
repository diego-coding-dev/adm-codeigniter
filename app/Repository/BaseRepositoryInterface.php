<?php

namespace App\Repository;

interface BaseRepositoryInterface
{
    public function find(int $id): object;

    public function update(int $id, array $data): bool;
}
