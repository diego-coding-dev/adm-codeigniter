<?php

namespace App\Repository\Views;

use CodeIgniter\Model;

class OrderView extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'order_view';
    protected $returnType = 'object';
}
