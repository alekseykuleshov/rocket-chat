<?php namespace ATDev\RocketChat\Tests\Channels;

use \PHPUnit\Framework\TestCase;
use \AspectMock\Test as test;

use \ATDev\RocketChat\Channels\Channel;

class ChannelTest extends TestCase {

	public function testListingFailed() {

		$stub = test::double("\ATDev\RocketChat\Channels\Channel", [
			"send" => true,
			"getSuccess" => false,
			"getResponse" => (object) [],
			"createOutOfResponse" => "nothing"
		]);

		$result = Channel::listing();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["channels.list", "GET"]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("getResponse");
		$stub->verifyNeverInvoked("createOutOfResponse");
	}

	public function testListingSuccess() {

		$channel1 = new \ATDev\RocketChat\Tests\Common\ResponseFixture1();
		$channel2 = new \ATDev\RocketChat\Tests\Common\ResponseFixture2();
		$response = (object) ["channels" => [$channel1, $channel2]];

		$stub = test::double("\ATDev\RocketChat\Channels\Channel", [
			"send" => true,
			"getSuccess" => true,
			"getResponse" => $response,
			"createOutOfResponse" => function($arg) { return get_class($arg); }
		]);

		$coll = test::double("\ATDev\RocketChat\Channels\Collection", [
			"add" => true
		]);

		$result = Channel::listing();

		$this->assertInstanceOf("\ATDev\RocketChat\Channels\Collection", $result);
		$stub->verifyInvokedOnce("send", ["channels.list", "GET"]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("getResponse");
		$stub->verifyInvokedOnce("createOutOfResponse", [$channel1]);
		$stub->verifyInvokedOnce("createOutOfResponse", [$channel2]);
		$coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture1"]);
		$coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture2"]);
	}

	public function testCreateFailed() {

		$stub = test::double("\ATDev\RocketChat\Channels\Channel", [
			"send" => true,
			"getSuccess" => false,
			"getResponse" => (object) [],
			"updateOutOfResponse" => "nothing"
		]);

		$channel = new Channel();
		$result = $channel->create();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["channels.create", "POST", $channel]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("getResponse");
		$stub->verifyNeverInvoked("updateOutOfResponse");
	}

	public function testCreateSuccess() {

		$response = (object) ["channel" => "channel content"];

		$stub = test::double("\ATDev\RocketChat\Channels\Channel", [
			"send" => true,
			"getSuccess" => true,
			"getResponse" => $response,
			"updateOutOfResponse" => "result"
		]);

		$channel = new Channel();
		$result = $channel->create();

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["channels.create", "POST", $channel]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("getResponse");
		$stub->verifyInvokedOnce("updateOutOfResponse", ["channel content"]);
	}

	protected function tearDown(): void {

		test::clean(); // remove all registered test doubles
	}
}