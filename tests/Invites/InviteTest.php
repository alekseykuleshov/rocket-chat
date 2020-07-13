<?php

namespace ATDev\RocketChat\Tests\Invites;

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

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
