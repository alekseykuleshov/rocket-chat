<?php

namespace ATDev\RocketChat\Tests\Invites;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Invites\Collection;
use ATDev\RocketChat\Invites\Invite;

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
        $invite = new Invite();
        $result = $collection->add($invite);

        $this->assertSame("added", $result);
        $stub->verifyInvokedOnce("add", [$invite]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
