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

    public function testIsFull()
    {
        $stub = test::double(Collection::class, ["isFull" => "result"]);
        $collection = new Collection();
        $result = $collection->isFull();

        $this->assertSame("result", $result);
        $stub->verifyInvoked("isFull");
    }

    public function testInvalidSetFull()
    {
        $stub = test::double(Collection::class);
        $collection = new Collection();
        $result = $collection->setFull("invalid type value");

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertNull($result->isFull());
        $stub->verifyInvoked("setFull");
    }

    public function testValidSetFull()
    {
        $stub = test::double(Collection::class);
        $collection = new Collection();
        $result = $collection->setFull(true);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertSame(true, $result->isFull());
        $stub->verifyInvoked("setFull");
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
