<?php

namespace ATDev\RocketChat\Tests\RoomRoles;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\RoomRoles\Collection;
use ATDev\RocketChat\RoomRoles\RoomRole;

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
        $roomRole = new RoomRole();
        $result = $collection->add($roomRole);

        $this->assertSame('added', $result);
        $stub->verifyInvokedOnce('add', [$roomRole]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
