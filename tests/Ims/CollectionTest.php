<?php

namespace ATDev\RocketChat\Tests\Ims;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Ims\Collection;
use ATDev\RocketChat\Ims\Im;

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
        $im = new Im();
        $result = $collection->add($im);

        $this->assertSame("added", $result);
        $stub->verifyInvokedOnce("add", [$im]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
