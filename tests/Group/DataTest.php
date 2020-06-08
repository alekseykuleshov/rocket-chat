<?php

namespace ATDev\RocketChat\Tests\Groups;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Groups\Data;

class DataTest extends TestCase
{
    public function testSetGroupId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $mock->expects($this->once())
            ->method("setRoomId")
            ->with($this->equalTo("123"))
            ->will($this->returnValue($mock));

        $mock->setGroupId("123");
    }

    public function testGetGroupId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $mock->expects($this->once())
            ->method("getRoomId")
            ->will($this->returnValue($mock));

        $mock->getGroupId();
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
