<?php

namespace App\Repository\ORMdefault;

use App\Repository\DefaulRepositoryInterface;
use App\Models\Order;
use App\Repository\Views\OrderView;
use App\Repository\Trait\PagerTrait;

class OrderRepository extends BaseRepository implements DefaulRepositoryInterface
{

    use PagerTrait;

    public function __construct()
    {
        parent::__construct(
                new Order(),
                new OrderView()
        );
    }

    public function hasOneNotSettled(int $orderId): null|object
    {
        return $this->model->where('client_id', $orderId)->where('is_settled', false)->first();
    }

    public function belongsOneClient(int $orderId)
    {
        $orderData = $this->find($orderId);

        return \Config\Services::repository('client')->find($orderData->client_id);
    }

    public function hasManyCartItens(int $orderId)
    {
        return \Config\Services::repository('orderCart')->getWhere([
                    'order_id' => $orderId
        ]);
    }

}
