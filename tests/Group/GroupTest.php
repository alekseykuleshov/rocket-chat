<?php namespace ATDev\RocketChat\Tests\Groups;

use \PHPUnit\Framework\TestCase;
use \AspectMock\Test as test;

use \ATDev\RocketChat\Groups\Group;

class GroupTest extends TestCase {

	public function testListingFailed() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"send" => true,
			"getSuccess" => false,
			"getResponse" => (object) [],
			"createOutOfResponse" => "nothing"
		]);

		$result = Group::listing();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["groups.list", "GET"]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("getResponse");
		$stub->verifyNeverInvoked("createOutOfResponse");
	}

	public function testListingSuccess() {

		$group1 = new \ATDev\RocketChat\Tests\Common\ResponseFixture1();
		$group2 = new \ATDev\RocketChat\Tests\Common\ResponseFixture2();
		$response = (object) ["groups" => [$group1, $group2]];

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"send" => true,
			"getSuccess" => true,
			"getResponse" => $response,
			"createOutOfResponse" => function($arg) { return get_class($arg); }
		]);

		$coll = test::double("\ATDev\RocketChat\Groups\Collection", [
			"add" => true
		]);

		$result = Group::listing();

		$this->assertInstanceOf("\ATDev\RocketChat\Groups\Collection", $result);
		$stub->verifyInvokedOnce("send", ["groups.list", "GET"]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("getResponse");
		$stub->verifyInvokedOnce("createOutOfResponse", [$group1]);
		$stub->verifyInvokedOnce("createOutOfResponse", [$group2]);
		$coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture1"]);
		$coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture2"]);
	}

	public function testCreateFailed() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"send" => true,
			"getSuccess" => false,
			"getResponse" => (object) [],
			"updateOutOfResponse" => "nothing"
		]);

		$group = new Group();
		$result = $group->create();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["groups.create", "POST", $group]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("getResponse");
		$stub->verifyNeverInvoked("updateOutOfResponse");
	}

	public function testCreateSuccess() {

		$response = (object) ["group" => "group content"];

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"send" => true,
			"getSuccess" => true,
			"getResponse" => $response,
			"updateOutOfResponse" => "result"
		]);

		$group = new Group();
		$result = $group->create();

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["groups.create", "POST", $group]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("getResponse");
		$stub->verifyInvokedOnce("updateOutOfResponse", ["group content"]);
	}

	protected function tearDown(): void {

		test::clean(); // remove all registered test doubles
	}
}