<?php

namespace App\Repository\ORMdefault;

use App\Models\Storage;
use App\Repository\Views\StorageView;
use App\Repository\DefaulRepositoryInterface;
use App\Repository\Trait\PagerTrait;

class StorageRepository extends BaseRepository implements DefaulRepositoryInterface
{

    use PagerTrait;

    private object $pager;

    public function __construct()
    {
        $this->pager = service('pager');

        parent::__construct(
                new Storage(),
                new StorageView()
        );
    }

    public function category(int $id)
    {
        return \Config\Services::repository('typeProduct')->find($id);
    }

}
