<?php

namespace ATDev\RocketChat\Tests\Invites;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Invites\Data;

class DataTest extends TestCase
{
    public function testConstructorNoInviteId()
    {
        $mock = $this->getMockForTrait(Data::class);
        $stub = test::double(get_class($mock), ['setInviteId' => $mock]);
        $stub->construct();
        $stub->verifyNeverInvoked('setInviteId');
    }

    public function testConstructorWithInviteId()
    {
        $mock = $this->getMockForTrait(Data::class);
        $stub = test::double(get_class($mock), ['setInviteId' => $mock]);
        $stub->construct('invite_id');
        $stub->verifyInvokedOnce('setInviteId', ['invite_id']);
    }

    public function testGetters()
    {
        $inviteFull = new ResponseFixtureFull();
        $mock = $this->getMockBuilder(Data::class)
            ->onlyMethods([
                'getInviteId', 'getDays', 'getMaxUses', 'getRoomId', 'getUserId', 'getCreatedAt', 'getExpires',
                'getUses', 'getUpdatedAt', 'getValid'
            ])
            ->getMockForTrait();

        $mock->method('getInviteId')->willReturn($inviteFull->_id);
        $mock->method('getDays')->willReturn($inviteFull->days);
        $mock->method('getMaxUses')->willReturn($inviteFull->maxUses);
        $mock->method('getRoomId')->willReturn($inviteFull->rid);
        $mock->method('getUserId')->willReturn($inviteFull->userId);
        $mock->method('getCreatedAt')->willReturn($inviteFull->createdAt);
        $mock->method('getExpires')->willReturn($inviteFull->expires);
        $mock->method('getUses')->willReturn($inviteFull->uses);
        $mock->method('getUpdatedAt')->willReturn($inviteFull->_updatedAt);
        $mock->method('getValid')->willReturn($inviteFull->valid);

        $this->assertSame('inviteId123', $mock->getInviteId());
        $this->assertSame(5, $mock->getDays());
        $this->assertSame(3, $mock->getMaxUses());
        $this->assertSame('roomId123', $mock->getRoomId());
        $this->assertSame('userId123', $mock->getUserId());
        $this->assertSame('2019-12-20T03:31:56.774Z', $mock->getCreatedAt());
        $this->assertSame('2019-12-21T03:31:56.774Z', $mock->getExpires());
        $this->assertSame(1, $mock->getUses());
        $this->assertSame('2019-12-20T03:33:40.065Z', $mock->getUpdatedAt());
        $this->assertSame(true, $mock->getValid());
    }

    public function testInvalidInviteId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setInviteId(123);
        $this->assertNull($mock->getInviteId());

        $stub->verifyInvokedOnce("setDataError", ["Invalid invite Id"]);
    }

    public function testValidInviteId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setInviteId("123");
        $this->assertSame("123", $mock->getInviteId());

        // And null value...
        $mock->setInviteId(null);
        $this->assertSame(null, $mock->getInviteId());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidDays()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setDays("1");
        $this->assertNull($mock->getDays());

        $stub->verifyInvokedOnce("setDataError", ["Invalid days value"]);
    }

    public function testValidDays()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setDays(1);
        $this->assertSame(1, $mock->getDays());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidMaxUses()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setMaxUses("1");
        $this->assertNull($mock->getMaxUses());

        $stub->verifyInvokedOnce("setDataError", ["Invalid maxUses value"]);
    }

    public function testValidMaxUses()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setMaxUses(1);
        $this->assertSame(1, $mock->getMaxUses());

        $stub->verifyNeverInvoked("setDataError");
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

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testUpdateOutOfResponse()
    {
        $inviteFull = new ResponseFixtureFull();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($inviteFull);

        $this->assertSame("inviteId123", $mock->getInviteId());

        $this->assertSame(5, $mock->getDays());
        $this->assertSame(3, $mock->getMaxUses());
        $this->assertSame("roomId123", $mock->getRoomId());
        $this->assertSame("userId123", $mock->getUserId());
        $this->assertSame("2019-12-20T03:31:56.774Z", $mock->getCreatedAt());
        $this->assertSame("2019-12-21T03:31:56.774Z", $mock->getExpires());
        $this->assertSame(1, $mock->getUses());
        $this->assertSame("2019-12-20T03:33:40.065Z", $mock->getUpdatedAt());
        $this->assertSame(true, $mock->getValid());

        $invite1 = new ResponseFixture1();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($invite1);

        $this->assertSame("inviteId123", $mock->getInviteId());
        $this->assertNull($mock->getCreatedAt());
        $this->assertSame(5, $mock->getDays());
        $this->assertNull($mock->getExpires());
        $this->assertSame(3, $mock->getMaxUses());
        $this->assertNull($mock->getUses());
        $this->assertSame("roomId123", $mock->getRoomId());
        $this->assertNull($mock->getUpdatedAt());
        $this->assertSame("userId123", $mock->getUserId());
        $this->assertNull($mock->getValid());

        $invite2 = new ResponseFixture2();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($invite2);

        $this->assertNull($mock->getInviteId());
        $this->assertSame("2019-12-20T03:31:56.774Z", $mock->getCreatedAt());
        $this->assertNull($mock->getDays());
        $this->assertSame("2019-12-21T03:31:56.774Z", $mock->getExpires());
        $this->assertNull($mock->getMaxUses());
        $this->assertSame(1, $mock->getUses());
        $this->assertNull($mock->getRoomId());
        $this->assertSame("2019-12-20T03:33:40.065Z", $mock->getUpdatedAt());
        $this->assertNull($mock->getUserId());
        $this->assertSame(true, $mock->getValid());
    }

    public function testCreateOutOfResponse()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double(get_class($mock), ["updateOutOfResponse" => $mock]);

        $inviteFull = new ResponseFixtureFull();
        $mock->createOutOfResponse($inviteFull);

        $stub->verifyInvokedOnce("updateOutOfResponse", [$inviteFull]);
    }
}
