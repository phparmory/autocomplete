<?php

namespace Armory\Autocomplete\Tests;

use Armory\Autocomplete\Repositories\ArrayRepository;
use Armory\Autocomplete\Repositories\RedisRepository;
use Predis\Client;

class RedisRepositoryTest extends RepositoryTest
{
    public function setUp()
    {
        $this->repository = new RedisRepository(new Client);
        $this->repository->clear('phpunit');
        $this->repository->clear('phpunit2');
    }
}
