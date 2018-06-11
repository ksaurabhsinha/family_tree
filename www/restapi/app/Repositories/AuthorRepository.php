<?php
namespace App\Repositories;
use App\Repositories\Infrastructure\Contracts\AbstractRepository;
class AuthorRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function getModel(): string
    {
        return 'App\Author';
    }
    
}