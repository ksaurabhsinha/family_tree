<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

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

    public function create(Request $request)
    {
        return $this->categoryRepository->create($request->all());
    }
}