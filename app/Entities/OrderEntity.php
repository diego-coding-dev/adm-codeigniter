<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class OrderEntity extends Entity
{

    protected $datamap = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [];

    public function status(): string
    {
        if ($this->attributes['is_settled'] === 't') {
            return 'Concluído';
        }

        return 'Em aberto';
    }

}
