<?php

namespace Armory\Autocomplete;

use Armory\Autocomplete\Str;

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
        $this->term = Str::clean($term);
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

        return Str::permutations($this->term, $min);
    }
}
