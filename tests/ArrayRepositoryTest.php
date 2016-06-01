<?php

namespace Armory\Autocomplete\Tests;

use Armory\Autocomplete\Repositories\ArrayRepository;

class ArrayRepositoryTest extends RepositoryTest
{
    public function setUp()
    {
        $this->repository = new ArrayRepository;
    }
}
