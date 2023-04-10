<?php

namespace App\Repository\Trait;

/**
 * 
 */
trait PagerTrait
{
    public function pager(): object
    {
        return $this->model->pager;
    }
}
