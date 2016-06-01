<?php

namespace Armory\Autocomplete;

use Armory\Autocomplete\Contracts\RepositoryInterface;

final class Autocomplete
{
    /**
     * The repository to use for storing and searching indexes
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * Create a new
     * @param RepositoryInterface $repository
     * @return void
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new index for a term
     * @param string $id
     * @param string $term
     * @param string $namespace
     * @return void
     */
    public function index(string $id, string $term, string $namespace)
    {
        $this->repository->store(new Index($id, $term), $namespace);
    }

    /**
     * Search for a term under a namespace
     * @param  string $searchs
     * @param  string $namespace
     * @return array
     */
    public function search(string $search, string $namespace) : array
    {
        return $this->repository->find($search, $namespace);
    }
}
