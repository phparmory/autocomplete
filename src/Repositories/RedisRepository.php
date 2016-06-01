<?php

namespace Armory\Autocomplete\Repositories;

use Armory\Autocomplete\Contracts\RepositoryInterface;
use Armory\Autocomplete\Index;
use Predis\ClientInterface;

/**
 * Redis Autocomplete Repository
 *
 * The Redis repository works by using three types of set:
 *
 * 1) A general purpose set to store ALL indexes by namespace - autocomplete:namespace
 * 2) A set for each ID in the namespace containing all of it's indexes - autocomplete:1:namespace
 * 3) A set of IDs for a permutation of a search term - autocomplete:term:namespace
 */
final class RedisRepository implements RepositoryInterface
{
    /**
     * The redis client interface
     * @var ClientInterface
     */
    private $redis;

    /**
     * Create a new
     * @param ClientInterface $redis
     * @return void
     */
    public function __construct(ClientInterface $redis)
    {
        $this->redis = $redis;
    }

    /**
     * Store an index
     * @param  Index  $index
     * @param  string $namespace
     * @return void
     */
    public function store(Index $index, string $namespace)
    {
        $this->redis->pipeline(function($redis) use ($index, $namespace)
        {
            // Store all indexes for this under ID separately
            $id = "autocomplete:" . $index->getId() . ":{$namespace}";

            foreach ($index->permutations() as $permutation) {

                // Store the index
                $key = "autocomplete:{$permutation}:{$namespace}";
                $redis->sadd($key, $index->getId());

                // Record the index by ID for easier deletes later
                $redis->sadd($id, $key);

                // Store all indexes in a separate array so we can clear
                $redis->sadd("autocomplete:{$namespace}", $key);
            }

            // Add the IDs indexes to a general indexes set
            $redis->sadd("autocomplete:{$namespace}", $id);
        });
    }

    /**
     * Find all IDs that match a search under a namespace
     * @param  string $term
     * @param  string $namespace
     * @return array
     */
    public function find(string $term, string $namespace) : array
    {
        return $this->redis->smembers("autocomplete:{$term}:$namespace");
    }

    /**
     * Remove all indexes that match an ID
     * @param string $id
     * @param string $namespace
     * @return void
     */
    public function remove(string $id, string $namespace)
    {
        $indexes = $this->redis->smembers("autocomplete:{$id}:{$namespace}");

        foreach ($indexes as $index) {
            $this->removeIndexId($id, $index);
        }

        $this->redis->del("autocomplete:{$id}:{$namespace}");
    }

    /**
     * Clears all stored indexes
     * @param string $namespace
     * @return void
     */
    public function clear(string $namespace)
    {
        $indexes = $this->redis->smembers("autocomplete:{$namespace}");

        // Remove every index
        foreach ($indexes as $index) {
            $this->redis->del($index);
        }

        // Remove the general autocomplete index storage
        $this->redis->del("autocomplete:{$namespace}");
    }

    /**
     * Remove an ID from an index
     * @param  string $id
     * @param  string $index
     * @return void
     */
    protected function removeIndexId(string $id, string $index)
    {
        if ($this->redis->scard($index) == 1) {
            return $this->redis->del($index);
        }

        return $this->redis->srem($index, $id);
    }
}
