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

    public function getOne(int $id)
    {
        return $this->categoryRepository->find($id);
    }

    public function updateVisibility(int $id, string $isVisible)
    {
        return $this->categoryRepository->updateVisibility($id, $isVisible);
    }
}