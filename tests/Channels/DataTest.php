<?php

namespace ATDev\RocketChat\Tests\Channels;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Channels\Data;

class DataTest extends TestCase
{
    public function testSetChannelId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $mock->expects($this->once())
            ->method("setRoomId")
            ->with($this->equalTo("123"))
            ->will($this->returnValue($mock));

        $mock->setChannelId("123");
    }

    public function testGetChannelId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $mock->expects($this->once())
            ->method("getRoomId")
            ->will($this->returnValue($mock));

        $mock->getChannelId();
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
