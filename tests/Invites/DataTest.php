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
