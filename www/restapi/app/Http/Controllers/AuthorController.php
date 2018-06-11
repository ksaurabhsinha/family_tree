<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;

class AuthorController extends Controller
{

    private $authorService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthorService $authorService)
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
