<?php

namespace App\Repository\Views;

use CodeIgniter\Model;

class StorageView extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'storage_view';
    protected $returnType = 'object';
}
