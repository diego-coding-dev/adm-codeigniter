<?php

namespace App\Repository\Views;

use CodeIgniter\Model;

class OrderCartsView extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'order_carts_view';
    protected $returnType = 'object';
}
