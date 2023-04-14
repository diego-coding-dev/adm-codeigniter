<?php

namespace App\Repository\Views;

use CodeIgniter\Model;

class OrderItensView extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'order_itens_view';
    protected $returnType = 'object';
}
