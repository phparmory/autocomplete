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
     * Pass all method calls to the repository
     * @param  string $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        return call_user_func_array([$this->repository, $method], $parameters);
    }
}
