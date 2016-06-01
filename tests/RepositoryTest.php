<?php

namespace Armory\Autocomplete\Tests;

use Armory\Autocomplete\Index;
use PHPUnit_Framework_TestCase;

abstract class RepositoryTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        $this->repository->clear('phpunit');
        $this->repository->clear('phpunit2');
    }

    public function test_basic_repository_find()
    {
        $index = new Index(1, 'complete');

        $this->repository->store($index, 'phpunit');

        $this->assertEquals([1], $this->repository->find('comp', 'phpunit'));
    }

    public function test_repository_finds_all_indexed_terms()
    {
        $first = new Index(1, 'complete');
        $second = new Index(2, 'completion');

        $this->repository->store($first, 'phpunit');
        $this->repository->store($second, 'phpunit');

        $this->assertEquals([1, 2], $this->repository->find('comp', 'phpunit'));
    }

    public function test_repository_finds_one_indexed_term()
    {
        $first = new Index(1, 'complete');
        $second = new Index(2, 'completion');

        $this->repository->store($first, 'phpunit');
        $this->repository->store($second, 'phpunit');

        $this->assertEquals([2], $this->repository->find('completi', 'phpunit'));
    }

    public function test_repository_finds_no_indexed_terms()
    {
        $first = new Index(1, 'complete');
        $second = new Index(2, 'completion');

        $this->repository->store($first, 'phpunit');
        $this->repository->store($second, 'phpunit');

        $this->assertEquals([], $this->repository->find('comply', 'phpunit'));
    }

    public function test_repository_finds_no_indexed_terms_in_other_namespace()
    {
        $first = new Index(1, 'complete');
        $second = new Index(2, 'completion');

        $this->repository->store($first, 'phpunit');
        $this->repository->store($second, 'phpunit');

        $this->assertEquals([], $this->repository->find('complet', 'testing'));
    }

    public function test_repository_removes_all_indexes_for_id()
    {
        $first = new Index(1, 'complete');
        $second = new Index(2, 'completion');

        $this->repository->store($first, 'phpunit');
        $this->repository->store($second, 'phpunit');

        $this->repository->remove(1, 'phpunit');

        $this->assertEquals([2], $this->repository->find('complet', 'phpunit'));
    }

    public function test_repository_removes_all_indexes_for_id_only_in_namespace()
    {
        $first = new Index(1, 'complete');
        $second = new Index(1, 'complete');

        $this->repository->store($first, 'phpunit');
        $this->repository->store($second, 'phpunit2');

        $this->repository->remove(1, 'phpunit');

        $this->assertEquals([], $this->repository->find('complet', 'phpunit'));
        $this->assertEquals([1], $this->repository->find('complet', 'phpunit2'));
    }

    public function test_repository_removing_nonexistent_indexes_for_id_doesnt_throw_error()
    {
        $first = new Index(1, 'complete');

        $this->repository->store($first, 'phpunit');

        $this->repository->remove(500, 'phpunit2');

        $this->assertEquals([1], $this->repository->find('complet', 'phpunit'));
    }

    public function test_repository_finds_term_with_special_characters_and_spaces()
    {
        $first = new Index(1, 'php arm0ry i$ awe$om3');

        $this->repository->store($first, 'phpunit');

        $this->assertEquals([1], $this->repository->find('php arm0ry', 'phpunit'));
    }

    public function test_repository_finds_term_with_mixed_case()
    {
        $first = new Index(1, 'Complete');

        $this->repository->store($first, 'phpunit');

        $this->assertEquals([1], $this->repository->find('comp', 'phpunit'));
    }
}
