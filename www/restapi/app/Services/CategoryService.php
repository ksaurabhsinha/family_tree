<?php

namespace App\Services;

use App\Entities\Category;
use App\Repositories\CategoryRepository;

class CategoryService
{
    /** * @var \App\Repositories\CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function paginateAll(int $perPage = 15)
    {
        return $this->categoryRepository->paginate($perPage);
    }

    public function create(Category $category)
    {
        return $this->categoryRepository->createCategory($category);
    }

    public function getOne(string $id)
    {
        return $this->categoryRepository->find($id);
    }

    public function updateVisibility(string $id, string $isVisible)
    {
        return $this->categoryRepository->updateVisibility($id, $isVisible);
    }

    public function getCategoryTree($parentId)
    {
        $categories = $this->categoryRepository->getCategoryTreeByParentId($parentId);

        return $this->buildTree($categories, \App\Category::COLUMN_PARENT_ID, $parentId, \App\Category::COLUMN_ID);
    }

    private function buildTree(array $categories, string $pidKey, string $parentId, string $idKey = null)
    {
        $flat = json_decode(json_encode($categories), true);

        $grouped = array();
        foreach ($flat as $sub){
            if(isset($sub[$pidKey]))
                $grouped[$sub[$pidKey]][] = $sub;
        }

        $fnBuilder = function($siblings) use (&$fnBuilder, $grouped, $idKey) {
            foreach ($siblings as $k => $sibling) {
                $id = $sibling[$idKey];
                if(isset($grouped[$id])) {
                    $sibling['children'] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }

            return $siblings;
        };

        $tree = [];

        if(isset($grouped[$parentId])) {
            $tree = $fnBuilder($grouped[$parentId]);
        }

        return $tree;
    }
}
