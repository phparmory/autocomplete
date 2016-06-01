<?php

namespace Armory\Autocomplete\Repositories;

use Armory\Autocomplete\Contracts\RepositoryInterface;
use Armory\Autocomplete\Index;

final class ArrayRepository implements RepositoryInterface
{
    /**
     * The array of indexed data
     * @param array
     */
    private $data = [];

    /**
     * Store an index
     * @param  Index  $index
     * @param  string $namespace
     * @return void
     */
    public function store(Index $index, string $namespace)
    {
        foreach ($index->permutations() as $permutation) {
            $namespaced = $this->data[$namespace] ?? [];
            $indexes = $namespaced[$permutation] ?? [];
            $indexes[] = $index->getId();
            $this->data[$namespace][$permutation] = $indexes;
        }
    }

    /**
     * Find all IDs that match a search under a namespace
     * @param  string $term
     * @param  string $namespace
     * @return array
     */
    public function find(string $term, string $namespace) : array
    {
        $namespaced = $this->data[$namespace] ?? [];
        return $namespaced[$term] ?? [];
    }

    /**
     * Remove all indexes that match an ID
     * @param string $id
     * @param string $namespace
     * @return void
     */
    public function remove(string $id, string $namespace)
    {
        $namespaced = $this->data[$namespace] ?? [];

        $filtered = array_map(function($ids) use ($id)
        {
            unset($ids[array_search($id, $ids)]);
            return array_values($ids);
        }, $namespaced);

        $this->data[$namespace] = $filtered;
    }

    /**
     * Clears all stored indexes
     * @param string $namespace
     * @return void
     */
    public function clear(string $namespace)
    {
        unset($this->data[$namespace]);
        $this->indexes = [];
    }
}
