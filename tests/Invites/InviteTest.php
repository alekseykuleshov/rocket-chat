<?php

namespace ATDev\RocketChat\Tests\Invites;

use ATDev\RocketChat\Rooms\Room;
use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Invites\Invite;

class InviteTest extends TestCase
{
    public function testListingFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Invites\Invite", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "createOutOfResponse" => "nothing"
        ]);

        $result = Invite::listing();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["listInvites", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("createOutOfResponse");
    }

    public function testListingSuccess()
    {
        $invite1 = new \ATDev\RocketChat\Tests\Invites\ResponseFixture1();
        $invite2 = new \ATDev\RocketChat\Tests\Invites\ResponseFixture2();
        $response = (object) [$invite1, $invite2];

        $stub = test::double("\ATDev\RocketChat\Invites\Invite", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "createOutOfResponse" => function ($arg) { return get_class($arg); }
        ]);

        $coll = test::double("\ATDev\RocketChat\Invites\Collection", [
            "add" => true
        ]);

        $result = Invite::listing();

        $this->assertInstanceOf("\ATDev\RocketChat\Invites\Collection", $result);
        $stub->verifyInvokedOnce("send", ["listInvites", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("createOutOfResponse", [$invite1]);
        $stub->verifyInvokedOnce("createOutOfResponse", [$invite2]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Invites\ResponseFixture1"]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Invites\ResponseFixture2"]);
    }

    public function testFindOrCreateInviteFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Invites\Invite", [
            'getRoomId' => 'roomId123',
            'getDays' => 0,
            'getMaxUses' => 1,
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $invite = new Invite();
        $result = $invite->findOrCreateInvite();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", [
            "findOrCreateInvite",
            "POST",
            ['rid' => 'roomId123', 'days' => 0, 'maxUses' => 1]
        ]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testFindOrCreateInviteSuccess()
    {
        $response = (object) ["something" => "here"];
        $stub = test::double('ATDev\RocketChat\Invites\Invite', [
            'getRoomId' => 'roomId123',
            'getDays' => 0,
            'getMaxUses' => 1,
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response,
            'updateOutOfResponse' => 'result'
        ]);

        $invite = new Invite();
        $result = $invite->findOrCreateInvite();

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', [
            'findOrCreateInvite', 'POST', ['rid' => 'roomId123', 'days' => 0, 'maxUses' => 1]
        ]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', $response);
    }

    public function testRemoveInviteFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Invites\Invite", [
            "getInviteId" => "inviteId123",
            "send" => true,
            "getSuccess" => false,
            "setInviteId" => "nothing"
        ]);

        $invite = new Invite();
        $result = $invite->removeInvite();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["removeInvite/inviteId123", "DELETE"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("setChannelId");
    }

    public function testRemoveInviteSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Invites\Invite", [
            "getInviteId" => "inviteId123",
            "send" => true,
            "getSuccess" => true,
            "setInviteId" => "result"
        ]);

        $invite = new Invite();
        $result = $invite->removeInvite();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["removeInvite/inviteId123", "DELETE"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("setInviteId", [null]);
    }

    public function testUseInviteTokenFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Invites\Invite", [
            'getInviteId' => 'inviteId123',
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) []
        ]);

        $room = test::double(Room::class, ["updateOutOfResponse" => "result"]);

        $invite = new Invite();
        $result = $invite->useInviteToken();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", [
            "useInviteToken",
            "POST",
            ['token' => 'inviteId123']
        ]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $room->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testUseInviteTokenSuccess()
    {
        $response = (object) ["room" => "room content"];
        $stub = test::double('ATDev\RocketChat\Invites\Invite', [
            'getInviteId' => 'inviteId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response
        ]);

        $room = test::double(Room::class, ["updateOutOfResponse" => "result"]);

        $invite = new Invite();
        $result = $invite->useInviteToken();

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', [
            'useInviteToken', 'POST', ['token' => 'inviteId123']
        ]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $room->verifyInvokedOnce("updateOutOfResponse", $response);
    }

    public function testValidateInviteTokenFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Invites\Invite", [
            'getInviteId' => 'inviteId123',
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $invite = new Invite();
        $result = $invite->validateInviteToken();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["validateInviteToken", "POST", ['token' => 'inviteId123']]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testValidateInviteTokenSuccess()
    {
        $response = (object) ["something" => "here"];
        $stub = test::double('ATDev\RocketChat\Invites\Invite', [
            'getInviteId' => 'inviteId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response,
            'updateOutOfResponse' => 'result'
        ]);

        $invite = new Invite();
        $result = $invite->validateInviteToken();

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', [
            'validateInviteToken', 'POST', ['token' => 'inviteId123']
        ]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', $response);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
