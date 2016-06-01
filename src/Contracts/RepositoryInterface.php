<?php

namespace Armory\Autocomplete\Contracts;

use Armory\Autocomplete\Index;

interface RepositoryInterface
{
    /**
     * Store an index
     * @param  Index  $index
     * @param  string $namespace
     * @return void
     */
    public function store(Index $index, string $namespace);

    /**
     * Find all IDs that match a search under a namespace
     * @param  string $term
     * @param  string $namespace
     * @return array
     */
    public function find(string $term, string $namespace) : array;

    /**
     * Remove all indexes that match an ID
     * @param string $id
     * @param string $namespace
     * @return void
     */
    public function remove(string $id, string $namespace);

    /**
     * Clears all stored indexes
     * @param string $namespace
     * @return void
     */
    public function clear(string $namespace);
}
