<?php

namespace ATDev\RocketChat\Tests\Ims;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Ims\Im;

class ImTest extends TestCase
{
    public function testListingFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "createOutOfResponse" => "nothing"
        ]);

        $result = Im::listing();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["im.list", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("createOutOfResponse");
    }

    public function testListingSuccess()
    {
        $im1 = new \ATDev\RocketChat\Tests\Common\ResponseFixture1();
        $im2 = new \ATDev\RocketChat\Tests\Common\ResponseFixture2();
        $response = (object) [
            "ims" => [$im1, $im2],
            "offset" => 2,
            "count" => 10,
            "total" => 30
        ];

        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "createOutOfResponse" => function ($arg) { return get_class($arg); }
        ]);

        $coll = test::double("\ATDev\RocketChat\Ims\Collection", [
            "add" => true
        ]);

        $result = Im::listing();

        $this->assertInstanceOf("\ATDev\RocketChat\Ims\Collection", $result);
        $stub->verifyInvokedOnce("send", ["im.list", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("createOutOfResponse", [$im1]);
        $stub->verifyInvokedOnce("createOutOfResponse", [$im2]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture1"]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture2"]);
        $this->assertSame(2, $result->getOffset());
        $this->assertSame(10, $result->getCount());
        $this->assertSame(30, $result->getTotal());
    }

    public function testCreateFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $im = new Im();
        $result = $im->create();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["im.create", "POST", $im]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testCreateSuccess()
    {
        $response = (object) ["room" => "room content"];

        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $im = new Im();
        $result = $im->create();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["im.create", "POST", $im]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["room content"]);
    }

    public function testCreateManyUsersSuccess()
    {
        $response = (object) ["room" => "room content"];

        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $im = new Im();
        $result = $im->create();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["im.create", "POST", $im]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["room content"]);
    }

    public function testOpenFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $im = new Im();
        $result = $im->open();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["im.open", "POST", ["roomId" => "directMessageId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testOpenSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $im = new Im();
        $result = $im->open();

        $this->assertSame($im, $result);
        $stub->verifyInvokedOnce("send", ["im.open", "POST", ["roomId" => "directMessageId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testCloseFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $im = new Im();
        $result = $im->close();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["im.close", "POST", ["roomId" => "directMessageId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testCloseSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $im = new Im();
        $result = $im->close();

        $this->assertSame($im, $result);
        $stub->verifyInvokedOnce("send", ["im.close", "POST", ["roomId" => "directMessageId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testCountersFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "getUsername" => "graywolf337",
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) []
        ]);

        $imCounters = test::double("\ATDev\RocketChat\Ims\ImCounters", [
            "updateOutOfResponse" => "result"
        ]);

        $im = new Im();
        $result = $im->counters();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["im.counters", "GET", ["roomId" => "directMessageId123", "username" => "graywolf337"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $imCounters->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testCountersSuccess()
    {
        $response = (object) [
            "joined" => true,
            "members" => 2,
            "unreads" => 0,
            "unreadsFrom" => "2018-02-21T21:08:51.026Z",
            "msgs" => 0,
            "latest" => "2018-02-21T21:08:51.026Z",
            "userMentions" => 0,
            "success" => true
        ];

        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "getUsername" => "graywolf337",
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response
        ]);

        $imCounters = test::double("\ATDev\RocketChat\Ims\ImCounters", [
            "updateOutOfResponse" => "result"
        ]);

        $im = new Im();
        $result = $im->counters();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["im.counters", "GET", ["roomId" => "directMessageId123", "username" => "graywolf337"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $imCounters->verifyInvokedOnce("updateOutOfResponse", $response);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
