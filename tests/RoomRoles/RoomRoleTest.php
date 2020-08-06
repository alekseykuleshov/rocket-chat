<?php

namespace RoomRoles;

use ATDev\RocketChat\RoomRoles\RoomRole;
use ATDev\RocketChat\Tests\RoomRoles\ResponseFixture1;
use ATDev\RocketChat\Tests\RoomRoles\ResponseFixture2;
use ATDev\RocketChat\Users\User;
use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

class RoomRoleTest extends TestCase
{
    public function testConstructorNoRoomRoleId()
    {
        $mock = $this->getMockBuilder(RoomRole::class)->enableProxyingToOriginalMethods()->getMock();
        $stub = test::double(get_class($mock), ['setRoomRoleId' => $mock]);
        $stub->construct();
        $stub->verifyNeverInvoked('setRoomRoleId');
    }

    public function testConstructorWithRoomRoleId()
    {
        $mock = $this->getMockBuilder(RoomRole::class)->enableProxyingToOriginalMethods()->getMock();
        $stub = test::double(get_class($mock), ['setRoomRoleId' => $mock]);
        $stub->construct('roomRoleId');
        $stub->verifyInvokedOnce('setRoomRoleId', ['roomRoleId']);
    }

    public function testUpdateOutOfResponse1()
    {
        $roomRole1 = new ResponseFixture1();
        $mock = $this->getMockBuilder(RoomRole::class)->enableProxyingToOriginalMethods()->getMock();
//        $stub = test::double(get_class($mock), ['updateOutOfResponse' => $mock]);
        $mock->updateOutOfResponse($roomRole1);

        $this->assertSame('roomRoleId123', $mock->getRoomRoleId());
        $this->assertSame('roomId123', $mock->getRoomId());
        $this->assertInstanceOf(User::class, $mock->getUser());
        $this->assertSame('y65tAmHs93aDChMWu', $mock->getUser()->getUserId());
        $this->assertSame(['admin', 'leader'], $mock->getRoles());
    }

    public function testUpdateOutOfResponse2()
    {
        $roomRole1 = new ResponseFixture2();
        $mock = $this->getMockBuilder(RoomRole::class)->enableProxyingToOriginalMethods()->getMock();
        $mock->updateOutOfResponse($roomRole1);

        $this->assertSame('roomRoleId321', $mock->getRoomRoleId());
        $this->assertSame('roomId123', $mock->getRoomId());
        $this->assertInstanceOf(User::class, $mock->getUser());
        $this->assertSame('userId123', $mock->getUser()->getUserId());
        $this->assertSame([], $mock->getRoles());
    }

    public function testCreateOutOfResponse()
    {
        $stub = test::double(RoomRole::class, ['updateOutOfResponse' => 'result']);

        $roomRole = new ResponseFixture1();
        $result = RoomRole::createOutOfResponse($roomRole);
        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('updateOutOfResponse', [$roomRole]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
