<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        $categories = $this->categoryService->paginateAll(15);

        return response()
            ->json($categories, Response::HTTP_OK);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'is_visible' => 'required|integer|between:0,1',
        ]);

        $category = new Category($request->input('name'), $request->input('is_visible'));

        $addedCategory = $this->categoryService->create($category);

        if($addedCategory) {
            return response()
                ->json(['created' => 'success'], Response::HTTP_CREATED);
        } else {
            return response()
                ->json(['created' => 'error'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function getOne($id)
    {
        $category = $this->categoryService->getOne($id);

        return response()
            ->json($category, Response::HTTP_OK);
    }

    public function updateVisibility($id, Request $request)
    {
        $this->validate($request, [
            'is_visible' => 'required|integer|between:0,1',
        ]);

        $status = $this->categoryService->updateVisibility($id, (string) $request->input('is_visible'));

        return response()
            ->json(['status' => $status], Response::HTTP_OK);
    }

    public function getCategoryTree($parentId)
    {
        $category = $this->categoryService->getCategoryTree($parentId);

        return response()
            ->json($category, Response::HTTP_OK);
    }
}
