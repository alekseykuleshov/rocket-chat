<?php

namespace ATDev\RocketChat\Tests\Groups;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Groups\Collection;
use ATDev\RocketChat\Groups\Group;

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
        $group = new Group();
        $result = $collection->add($group);

        $this->assertSame("added", $result);
        $stub->verifyInvokedOnce("add", [$group]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
