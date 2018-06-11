<?php

namespace App\Http\Controllers;

class AuthorController extends Controller
{

    private $authorService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Services\AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function getAll()
    {
        $recipes = $this->authorService->paginateAll(3);
        
        return response()->json($recipes, 200);
    }

    //
}
