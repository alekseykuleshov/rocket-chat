<?php namespace ATDev\RocketChat\Tests\Groups;

use \PHPUnit\Framework\TestCase;
use \AspectMock\Test as test;

use \ATDev\RocketChat\Groups\Group;
use \ATDev\RocketChat\Users\User;

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

	public function testDeleteFailed() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => false,
			"setGroupId" => "nothing"
		]);

		$group = new Group();
		$result = $group->delete();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["groups.delete", "POST", ["roomId" => "groupId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("setGroupId");
	}

	public function testDeleteSuccess() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => true,
			"setGroupId" => "result"
		]);

		$group = new Group();
		$result = $group->delete();

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["groups.delete", "POST", ["roomId" => "groupId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("setGroupId", [null]);
	}

	public function testInfoFailed() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => false,
			"getResponse" => (object) [],
			"updateOutOfResponse" => "nothing"
		]);

		$group = new Group();
		$result = $group->info();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["groups.info", "GET", ["roomId" => "groupId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("getResponse");
		$stub->verifyNeverInvoked("updateOutOfResponse");
	}

	public function testInfoSuccess() {

		$response = (object) ["group" => "group content"];

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => true,
			"getResponse" => $response,
			"updateOutOfResponse" => "result"
		]);

		$group = new Group();
		$result = $group->info();

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["groups.info", "GET", ["roomId" => "groupId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("getResponse");
		$stub->verifyInvokedOnce("updateOutOfResponse", ["group content"]);
	}

	public function testOpenFailed() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => false
		]);

		$group = new Group();
		$result = $group->open();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["groups.open", "POST", ["roomId" => "groupId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	public function testOpenSuccess() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => true
		]);

		$group = new Group();
		$result = $group->open();

		$this->assertSame($group, $result);
		$stub->verifyInvokedOnce("send", ["groups.open", "POST", ["roomId" => "groupId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	public function testInviteFailed() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => false
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123"
		]);

		$group = new Group();
		$user = new User();
		$result = $group->invite($user);

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["groups.invite", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	public function testInviteSuccess() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => true
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123"
		]);

		$group = new Group();
		$user = new User();
		$result = $group->invite($user);

		$this->assertSame($group, $result);
		$stub->verifyInvokedOnce("send", ["groups.invite", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	public function testKickFailed() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => false
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123"
		]);

		$group = new Group();
		$user = new User();
		$result = $group->kick($user);

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["groups.kick", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	public function testKickSuccess() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => true
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123"
		]);

		$group = new Group();
		$user = new User();
		$result = $group->kick($user);

		$this->assertSame($group, $result);
		$stub->verifyInvokedOnce("send", ["groups.kick", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	public function testAddOwnerFailed() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => false
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123"
		]);

		$group = new Group();
		$user = new User();
		$result = $group->addOwner($user);

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["groups.addOwner", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	public function testAddOwnerSuccess() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => true
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123"
		]);

		$group = new Group();
		$user = new User();
		$result = $group->addOwner($user);

		$this->assertSame($group, $result);
		$stub->verifyInvokedOnce("send", ["groups.addOwner", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	public function testRemoveOwnerFailed() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => false
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123"
		]);

		$group = new Group();
		$user = new User();
		$result = $group->removeOwner($user);

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["groups.removeOwner", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	public function testRemoveOwnerSuccess() {

		$stub = test::double("\ATDev\RocketChat\Groups\Group", [
			"getGroupId" => "groupId123",
			"send" => true,
			"getSuccess" => true
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123"
		]);

		$group = new Group();
		$user = new User();
		$result = $group->removeOwner($user);

		$this->assertSame($group, $result);
		$stub->verifyInvokedOnce("send", ["groups.removeOwner", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	protected function tearDown(): void {

		test::clean(); // remove all registered test doubles
	}
}