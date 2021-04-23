<?php

namespace ATDev\RocketChat\Tests\Roles;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Roles\Collection;
use ATDev\RocketChat\Roles\Role;

class CollectionTest extends TestCase
{
    public function testInvalidAdd()
    {
        $stub = test::double("\Doctrine\Common\Collections\ArrayCollection", ["add" => "not_added"]);

        $collection = new Collection();
        $result = $collection->add(123);

        $this->assertSame(false, $result);
        $stub->verifyNeverInvoked("add");
    }

    public function testValidAdd()
    {
        $stub = test::double("\Doctrine\Common\Collections\ArrayCollection", ["add" => "added"]);

        $collection = new Collection();
        $role = new Role();
        $result = $collection->add($role);

        $this->assertSame("added", $result);
        $stub->verifyInvokedOnce("add", [$role]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
