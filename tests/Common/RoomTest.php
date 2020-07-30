<?php

namespace ATDev\RocketChat\Tests\Common;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Common\RoomData;

class RoomTest extends TestCase
{
    public function testConstructorNoRoomId()
    {
        $mock = $this->getMockForTrait(RoomData::class);

        $stub = test::double(get_class($mock), ["setRoomId" => $mock]);

        $stub->construct();

        $stub->verifyNeverInvoked("setRoomId");
    }

    public function testConstructorWithRoomId()
    {
        $mock = $this->getMockForTrait(RoomData::class);

        $stub = test::double(get_class($mock), ["setRoomId" => $mock]);

        $stub->construct("asd123asd");

        $stub->verifyInvokedOnce("setRoomId", ["asd123asd"]);
    }

    public function testInvalidRoomId()
    {
        $mock = $this->getMockForTrait(RoomData::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setRoomId(123);
        $this->assertNull($mock->getRoomId());

        $stub->verifyInvokedOnce("setDataError", ["Invalid room Id"]);
    }

    public function testValidRoomId()
    {
        $mock = $this->getMockForTrait(RoomData::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setRoomId("123");
        $this->assertSame("123", $mock->getRoomId());

        // And null value...
        $mock->setRoomId(null);
        $this->assertSame(null, $mock->getRoomId());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidName()
    {
        $mock = $this->getMockForTrait(RoomData::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setName(123);
        $this->assertNull($mock->getName());

        $stub->verifyInvokedOnce("setDataError", ["Invalid name"]);
    }

    public function testValidName()
    {
        $mock = $this->getMockForTrait(RoomData::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setName("Room Name");
        $this->assertSame("Room Name", $mock->getName());

        // And null value...
        $mock->setName(null);
        $this->assertSame(null, $mock->getName());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testJsonSerialize()
    {
        $mock = $this->getMockForTrait(RoomData::class);
        $mock->setName("roomname");

        $this->assertSame([
            "name" => "roomname"
        ], $mock->jsonSerialize());

        $mock = $this->getMockForTrait(RoomData::class);
        $mock->setReadOnly(true);

        $this->assertSame([
            "name" => null,
            "readOnly" => true
        ], $mock->jsonSerialize());
    }

    public function testUpdateOutOfResponse()
    {
        $roomFull = new ResponseFixtureFull();
        $mock = $this->getMockForTrait(RoomData::class);
        $mock->updateOutOfResponse($roomFull);

        $this->assertSame("asd123asd", $mock->getRoomId());

        $this->assertSame("Room Name", $mock->getName());
        $this->assertSame("c", $mock->getT());
        $this->assertSame(6, $mock->getMsgs());
        $this->assertSame(3, $mock->getUsersCount());
        $this->assertSame("2020-05-12T15:24:04.977Z", $mock->getTs());
        $this->assertSame(true, $mock->getReadOnly());
        $this->assertSame(false, $mock->getDefault());
        $this->assertSame(true, $mock->getSysMes());

        $room1 = new ResponseFixture1();
        $mock = $this->getMockForTrait(RoomData::class);
        $mock->updateOutOfResponse($room1);

        $this->assertSame("asd123asd", $mock->getRoomId());
        $this->assertNull($mock->getName());
        $this->assertSame("c", $mock->getT());
        $this->assertNull($mock->getMsgs());
        $this->assertSame(3, $mock->getUsersCount());
        $this->assertSame("2020-05-12T15:24:04.977Z", $mock->getTs());
        $this->assertNull($mock->getReadOnly());
        $this->assertNull($mock->getDefault());
        $this->assertSame(true, $mock->getSysMes());

        $room2 = new ResponseFixture2();
        $mock = $this->getMockForTrait(RoomData::class);
        $mock->updateOutOfResponse($room2);

        $this->assertNull($mock->getRoomId());
        $this->assertSame("Room Name", $mock->getName());
        $this->assertNull($mock->getT());
        $this->assertSame(6, $mock->getMsgs());
        $this->assertNull($mock->getUsersCount());
        $this->assertNull($mock->getTs());
        $this->assertSame(true, $mock->getReadOnly());
        $this->assertSame(false, $mock->getDefault());
        $this->assertNull($mock->getSysMes());
    }

    public function testCreateOutOfResponse()
    {
        $mock = $this->getMockForTrait(RoomData::class);

        $stub = test::double(get_class($mock), ["updateOutOfResponse" => $mock]);

        $roomFull = new ResponseFixtureFull();
        $mock->createOutOfResponse($roomFull);

        $stub->verifyInvokedOnce("updateOutOfResponse", [$roomFull]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
