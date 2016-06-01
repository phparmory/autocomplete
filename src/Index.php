<?php

namespace Armory\Autocomplete;

use Assert\Assertion as A;

final class Index
{
    /**
     * The ID of the index
     * @var string
     */
    private $id;

    /**
     * The term that's being indexed
     * @var string
     */
    private $term;

    /**
     * Create a new index
     * @param string $id
     * @param string $term
     * @return void
     */
    public function __construct(string $id, string $term)
    {
        $this->id = $id;
        $this->term = $term;
    }

    /**
     * Get the ID of the
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Calculate all string permutations of the original string
     * @param int $min
     * @return array
     */
    public function permutations(int $min = 1) : array
    {
        // If the minimum index length is longer than the length of
        // the term then this is a noop
        if ($min > strlen($this->term)) {
            return [];
        }

        $permutations = [];
        $count = strlen($this->term) - ($min - 1);

        for ($i = 0; $i < $count; $i++) {
            $permutations[] = substr($this->term, 0, $i + $min);
        }

        return $permutations;
    }
}
