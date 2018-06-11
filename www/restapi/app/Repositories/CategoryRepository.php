<?php

namespace App\Repositories;

use App\Repositories\Infrastructure\Contracts\AbstractRepository;

class CategoryRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function getModel(): string
    {
        return 'App\Category';
    }
}