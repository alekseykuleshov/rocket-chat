<?php

namespace ATDev\RocketChat\Tests\Ims;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;
use ATDev\RocketChat\Ims\Data;

class DataTest extends TestCase
{
    public function testCreateOutOfResponse()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double(get_class($mock), ["updateOutOfResponse" => $mock]);

        $imFull = new ResponseFixtureFull();
        $mock->createOutOfResponse($imFull);

        $stub->verifyInvokedOnce("updateOutOfResponse", [$imFull]);
    }

    public function testInvalidRoomId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setRoomId(123);
        $this->assertNull($mock->getRoomId());

        $stub->verifyInvokedOnce("setDataError", ["Invalid room Id"]);
    }

    public function testValidRoomId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setRoomId("123");
        $this->assertSame("123", $mock->getRoomId());

        // And null value...
        $mock->setRoomId(null);
        $this->assertSame(null, $mock->getRoomId());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testUpdateOutOfResponse()
    {
        $imFull = new ResponseFixtureFull();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($imFull);

        $this->assertSame("bZGWmZcbGZTmFQDuN", $mock->getRoomId());
        $this->assertSame("2020-06-22T12:00:17.106Z", $mock->getUpdatedAt());
        $this->assertSame("d", $mock->getT());
        $this->assertSame(7, $mock->getMsgs());
        $this->assertSame("2020-06-22T09:21:24.884Z", $mock->getTs());
        $this->assertSame("2020-06-23T15:22:46.020Z", $mock->getLm());
        $this->assertSame("Discuss all of the testing", $mock->getTopic());
        $this->assertSame(["graywolf336", "graywolf337"], $mock->getUsernames());
        $this->assertSame("Last message", $mock->getLastMessage());

        $im1 = new ResponseFixture1();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($im1);

        $this->assertSame("bZGWmZcbGZTmFQDuN", $mock->getRoomId());
        $this->assertNull($mock->getLm());
        $this->assertSame("2020-06-22T12:00:17.106Z", $mock->getUpdatedAt());
        $this->assertNull($mock->getTopic());
        $this->assertSame("d", $mock->getT());
        $this->assertNull($mock->getUsernames());
        $this->assertSame(7, $mock->getMsgs());
        $this->assertNull($mock->getLastMessage());
        $this->assertSame("2020-06-22T09:21:24.884Z", $mock->getTs());

        $im2 = new ResponseFixture2();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($im2);

        $this->assertNull($mock->getRoomId());
        $this->assertSame("2020-06-23T15:22:46.020Z", $mock->getLm());
        $this->assertNull($mock->getUpdatedAt());
        $this->assertSame("Discuss all of the testing", $mock->getTopic());
        $this->assertNull($mock->getT());
        $this->assertSame(['graywolf336', 'graywolf337'], $mock->getUsernames());
        $this->assertNull($mock->getMsgs());
        $this->assertSame("Last message", $mock->getLastMessage());
        $this->assertNull($mock->getTs());
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
