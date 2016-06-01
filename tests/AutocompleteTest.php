<?php

namespace Armory\Autocomplete\Tests;

use Armory\Autocomplete\Autocomplete;
use Armory\Autocomplete\Repositories\ArrayRepository;
use PHPUnit_Framework_TestCase;

class AutocompleteTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->autocomplete = new Autocomplete(new ArrayRepository);
    }

    public function tearDown()
    {
        $this->autocomplete->clear('phpunit');
    }

    public function test_autocomplete_index_creates_index()
    {
        $this->autocomplete->index(1, 'complete', 'phpunit');

        $this->assertEquals([1], $this->autocomplete->find('comp', 'phpunit'));
    }
}
