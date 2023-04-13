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

}
