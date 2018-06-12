<?php

namespace App\Repositories;

use App\Category;
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

    public function updateVisibility(int $id, string $isVisible)
    {
        return $this->update([
            Category::IS_VISIBLE => $isVisible,
        ], $id);
    }
}