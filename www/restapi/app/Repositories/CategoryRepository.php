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
            Category::COLUMN_IS_VISIBLE => $isVisible,
        ], $id);
    }

    public function createCategory(\App\Entities\Category $category)
    {
        return $this->create($this->toArray($category));
    }

    private function toArray(\App\Entities\Category $category): array
    {
        return [
            Category::COLUMN_NAME => $category->getName(),
            Category::COLUMN_SLUG => $category->getSlug(),
            Category::COLUMN_PARENT_ID => $category->getParentCategory(),
            Category::COLUMN_IS_VISIBLE => (string) $category->isVisible()
        ];
    }
}
