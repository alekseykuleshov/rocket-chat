<?php

namespace ATDev\RocketChat\Tests\Users;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Users\Collection;
use ATDev\RocketChat\Users\User;

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
        $user = new User();
        $result = $collection->add($user);

        $this->assertSame("added", $result);
        $stub->verifyInvokedOnce("add", [$user]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
