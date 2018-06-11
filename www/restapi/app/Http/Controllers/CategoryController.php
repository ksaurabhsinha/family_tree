<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
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

    public function create(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'parent_id' => 'integer|min:0',
        ]);
    }
}