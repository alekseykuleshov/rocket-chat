<?php

namespace ATDev\RocketChat\Tests\Files;

use ATDev\RocketChat\Files\Collection;
use ATDev\RocketChat\Files\File;
use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

class CollectionTest extends TestCase
{
    public function testInvalidAdd()
    {
        $stub = test::double('\Doctrine\Common\Collections\ArrayCollection', ['add' => 'not_added']);

        $collection = new Collection();
        $result = $collection->add('invalid argument');

        $this->assertSame(false, $result);
        $stub->verifyNeverInvoked('add');
    }

    public function testValidAdd()
    {
        $stub = test::double('\Doctrine\Common\Collections\ArrayCollection', ['add' => 'added']);

        $collection = new Collection();
        $file = new File();
        $result = $collection->add($file);

        $this->assertSame('added', $result);
        $stub->verifyInvokedOnce('add', [$file]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
