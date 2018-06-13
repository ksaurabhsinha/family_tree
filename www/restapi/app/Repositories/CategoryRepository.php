<?php

namespace App\Repositories;

use App\Category;
use App\Repositories\Infrastructure\Contracts\AbstractRepository;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function getModel(): string
    {
        return 'App\Category';
    }

    public function updateVisibility(string $id, string $isVisible)
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

    public function getCategoryTreeByParentId($parentId)
    {
        $results = DB::select( "select  id,
                name,
                parent_id 
            from    (select * from categories
                     order by parent_id, id) categories_sorted,
                    (select @pv := '$parentId') initialisation
            where   find_in_set(parent_id, @pv)
            and     length(@pv := concat(@pv, ',', id));");

        return $results;
    }
}
