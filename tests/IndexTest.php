<?php

namespace Armory\Autocomplete\Tests;

use Armory\Autocomplete\Index;
use PHPUnit_Framework_TestCase;

class IndexTest extends PHPUnit_Framework_TestCase
{
    public function test_index_returns_all_permutations()
    {
        $index = new Index(1, 'complete');

        return $this->assertEquals([
            'c',
            'co',
            'com',
            'comp',
            'compl',
            'comple',
            'complet',
            'complete'
        ], $index->permutations());
    }

    public function test_index_returns_permutations_with_minimum()
    {
        $index = new Index(1, 'complete');

        return $this->assertEquals([
            'com',
            'comp',
            'compl',
            'comple',
            'complet',
            'complete'
        ], $index->permutations(3));
    }

    public function test_index_returns_no_permutations_when_term_is_shorter_than_index_length()
    {
        $index = new Index(1, 'comp');

        return $this->assertEquals([], $index->permutations(5));
    }
}
