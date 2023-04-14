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

    public function hasManyItens(int $orderId)
    {
        return \Config\Services::repository('orderItens')->getWhere([
                    'order_id' => $orderId
        ], true);
    }

    public function finish(int $orderId)
    {
        $db = db_connect('default');
        $orderCartRepository = \Config\Services::repository('orderCart');
        $orderItensRepository = \Config\Services::repository('orderItens');

        $db->transBegin();

        $cartItens = $orderCartRepository->getWhere(['order_id' => $orderId]);

        foreach ($cartItens as $item) {
            $orderItensRepository->add([
                'order_id' => $item->order_id,
                'storage_id' => $item->storage_id,
                'quantity' => $item->quantity
            ]);
        }

        $orderCartRepository->removeWhere(['order_id' => $orderId]);

        parent::update(['id' => $orderId], ['is_settled' => true]);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return false;
        }

        $db->transCommit();
        return true;
    }

    public function cancel(int $orderId): bool
    {
        $db = db_connect('default');
        $orderCartRepository = \Config\Services::repository('orderCart');
        $storageRepository = \Config\Services::repository('storage');

        $db->transBegin();

        $cartItens = $orderCartRepository->getWhere(['order_id' => $orderId]);

        if (count($cartItens) < 1) {
            return parent::remove($orderId);
        }

        foreach ($cartItens as $item) {
            $storageItem = $storageRepository->find($item->storage_id);

            $storageData['quantity'] = $storageItem->quantity + $item->quantity;

            $storageRepository->update(['id' => $item->storage_id], $storageData);
        }

        $orderCartRepository->removeWhere(['order_id' => $orderId]);

        parent::update(['id' => $orderId], ['is_canceled' => true]);

        parent::remove($orderId);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return false;
        }

        $db->transCommit();
        return true;
    }

}
