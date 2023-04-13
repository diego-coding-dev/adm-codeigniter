<?php

namespace App\Repository\ORMdefault;

use App\Models\OrderCart;
use App\Repository\Views\OrderCartsView;
use App\Repository\DefaulRepositoryInterface;
use App\Repository\Trait\PagerTrait;

/**
 * Description of OrderCartRepository
 *
 * @author diego
 */
class OrderCartRepository extends BaseRepository implements DefaulRepositoryInterface
{

    use PagerTrait;

    public function __construct()
    {
        parent::__construct(
                new OrderCart(),
                new OrderCartsView()
        );
    }

    public function add(array $data, bool $returnId = false): bool|int|string
    {
        $db = db_connect('default');

        $storageRepository = \Config\Services::repository('storage');

        $storageData = $storageRepository->find($data['storage_id']);

        $db->transBegin();

        parent::add($data);

        $quantity = $storageData->quantity - $data['quantity'];

        \Config\Services::repository('storage')->update([
            'id' => $data['storage_id']
                ], [
            'quantity' => $quantity
        ]);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return false;
        }

        $db->transCommit();
        return true;
    }

    public function remove(int $orderCartId): bool
    {
        $db = db_connect('default');

        $orderCartData = parent::find($orderCartId);

        $storageRepository = \Config\Services::repository('storage');

        $storageData = $storageRepository->find($orderCartData->storage_id);

        $db->transBegin();

        parent::remove($orderCartId);

        $quantity = $storageData->quantity + $orderCartData->quantity;

        \Config\Services::repository('storage')->update([
            'id' => $storageData->id
                ], [
            'quantity' => $quantity
        ]);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return false;
        }

        $db->transCommit();
        return true;
    }

}
