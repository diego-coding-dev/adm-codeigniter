<?php

namespace App\Repository\Trait;

/**
 * 
 */
trait PagerTrait
{
    /**
     * Gerador dos links de paginação
     *
     * @param boolean $useView
     * @return null|object
     */
    public function pager(bool $useView = false): null|object
    {
        if (!$useView) {
            return $this->model->pager;
        }

        return $this->view->pager;
    }

    /**
     * Gerador dos links de paginação em caso de paginação manual
     *
     * @param integer $page
     * @param string|null $like
     * @return void
     */
    // public function createPagerLinks(int $page, string $like = null)
    // {
    //     $perPage = $this->limit; // como se fosse limit

    //     if (!$like) {
    //         $total = $this->total();
    //     } else {
    //         $total = $this->totalWithLike($like, $page);
    //     }

    //     return $this->pager->makeLinks($page, $perPage, $total);
    // }
}
