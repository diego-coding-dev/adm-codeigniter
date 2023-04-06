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
     * Verifica o password
     *
     * @param string $password
     * @return bool
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->attributes['password']);
    }

    /**
     * Verifica se está ativado
     *
     * @return boolean
     */
    public function isActive(): bool
    {
        return $this->attributes['is_active'] == true;
    }
}
