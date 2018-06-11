<?php
namespace App\Services;

use App\Repositories\AuthorRepository;
class AuthorService
{
    /**
     * @var \App\Repositories\AuthorRepository
     */
    private $contactRepository;
    /**
     * ContactService constructor.
     *
     * @param \App\Repositories\AuthorRepository $contactRepository
     */
    public function __construct(AuthorRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function paginateAll(int $perPage = 15)
    {
        return $this->contactRepository->paginate($perPage);
    }
   
}