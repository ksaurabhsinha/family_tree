<?php

namespace App\Http\Controllers;


use App\Services\CategoryService;

class CategoryController
{
    /** * @var \App\Services\CategoryService */
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getAll()
    {
        $categories = $this->categoryService->paginateAll(3);

        return response()->json($categories, 200);
    }
}