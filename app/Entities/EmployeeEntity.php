<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use Config\Services;
use DateTime;

class EmployeeEntity extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    /**
     * Retorna o id critptografado
     *
     * @return string
     */
    public function getId(): string
    {
        $encrypt = Services::encrypter();

        $this->attributes['id'] = $encrypt->encrypt($this->attributes['id']);

        return bin2hex($this->attributes['id']);
    }
}
