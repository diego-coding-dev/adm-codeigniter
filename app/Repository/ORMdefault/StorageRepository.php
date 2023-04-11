<?php

namespace App\Repository\ORMdefault;

use App\Models\Storage;
use App\Repository\DefaulRepositoryInterface;
use App\Repository\Trait\PagerTrait;

class StorageRepository extends BaseRepository implements DefaulRepositoryInterface
{
    use PagerTrait;

    private int $limit = 2;
    private object $pager;

    public function __construct()
    {
        $this->pager = service('pager');
        $this->view = service('repositoryView', 'storage');
        parent::__construct(new Storage());
    }

    public function getLike(array $like): array
    {
        return $this->view->like($like)->orderBy('id', 'asc')->paginate(10);
    }

    public function all(): array
    {
        return $this->view->orderBy('id', 'asc')->paginate(10);
    }

    public function find(int $id, bool $view = false): object
    {
        if (!$view) {
            return parent::find($id);
        }

        return $this->view->find($id);
    }

    public function category(int $id)
    {
        return \Config\Services::repository('typeProduct')->find($id);
    }
}
