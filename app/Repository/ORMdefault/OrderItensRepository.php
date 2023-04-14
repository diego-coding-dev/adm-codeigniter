<?php

namespace App\Repository\ORMdefault;

use App\Models\OrderItens;
use App\Repository\Views\OrderItensView;
use App\Repository\DefaulRepositoryInterface;
use App\Repository\Trait\PagerTrait;

/**
 * Description of OrderItensRepository
 *
 * @author diego
 */
class OrderItensRepository extends BaseRepository implements DefaulRepositoryInterface
{

    use PagerTrait;

    public function __construct()
    {
        parent::__construct(
                new OrderItens(),
                new OrderItensView()
        );
    }

}
