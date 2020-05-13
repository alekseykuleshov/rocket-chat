<?php namespace ATDev\RocketChat\Tests\Users;

use \PHPUnit\Framework\TestCase;
use \AspectMock\Test as test;

use \ATDev\RocketChat\Users\User;
use ATDev\RocketChat\Users\AvatarFromFile;
use ATDev\RocketChat\Users\AvatarFromDomain;

class UserTest extends TestCase {

	public function testListingFailed() {

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"send" => true,
			"getSuccess" => false,
			"getResponse" => (object) [],
			"createOutOfResponse" => "nothing"
		]);

		$result = User::listing();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["users.list", "GET"]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("getResponse");
		$stub->verifyNeverInvoked("createOutOfResponse");
	}

	public function testListingSuccess() {

		$user1 = new ResponseFixture1();
		$user2 = new ResponseFixture2();
		$response = (object) ["users" => [$user1, $user2]];

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"send" => true,
			"getSuccess" => true,
			"getResponse" => $response,
			"createOutOfResponse" => function($arg) { return get_class($arg); }
		]);

		$coll = test::double("\ATDev\RocketChat\Users\Collection", [
			"add" => true
		]);

		$result = User::listing();

		$this->assertInstanceOf("\ATDev\RocketChat\Users\Collection", $result);
		$stub->verifyInvokedOnce("send", ["users.list", "GET"]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("getResponse");
		$stub->verifyInvokedOnce("createOutOfResponse", [$user1]);
		$stub->verifyInvokedOnce("createOutOfResponse", [$user2]);
		$coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Users\ResponseFixture1"]);
		$coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Users\ResponseFixture2"]);
	}

	public function testCreateFailed() {

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"send" => true,
			"getSuccess" => false,
			"getResponse" => (object) [],
			"updateOutOfResponse" => "nothing"
		]);

		$user = new User();
		$result = $user->create();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["users.create", "POST", $user]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("getResponse");
		$stub->verifyNeverInvoked("updateOutOfResponse");
	}

	public function testCreateSuccess() {

		$response = (object) ["user" => "user content"];

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"send" => true,
			"getSuccess" => true,
			"getResponse" => $response,
			"updateOutOfResponse" => "result"
		]);

		$user = new User();
		$result = $user->create();

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["users.create", "POST", $user]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("getResponse");
		$stub->verifyInvokedOnce("updateOutOfResponse", ["user content"]);
	}

	public function testUpdateFailed() {

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"send" => true,
			"getSuccess" => false,
			"getResponse" => (object) [],
			"updateOutOfResponse" => "nothing"
		]);

		$user = new User();
		$result = $user->update();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["users.update", "POST", ["userId" => "userId123", "data" => $user]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("getResponse");
		$stub->verifyNeverInvoked("updateOutOfResponse");
	}

	public function testUpdateSuccess() {

		$response = (object) ["user" => "user content"];

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"send" => true,
			"getSuccess" => true,
			"getResponse" => $response,
			"updateOutOfResponse" => "result"
		]);

		$user = new User();
		$result = $user->update();

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["users.update", "POST", ["userId" => "userId123", "data" => $user]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("getResponse");
		$stub->verifyInvokedOnce("updateOutOfResponse", ["user content"]);
	}

	public function testInfoFailed() {

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"send" => true,
			"getSuccess" => false,
			"getResponse" => (object) [],
			"updateOutOfResponse" => "nothing"
		]);

		$user = new User();
		$result = $user->info();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["users.info", "GET", ["userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("getResponse");
		$stub->verifyNeverInvoked("updateOutOfResponse");
	}

	public function testInfoSuccess() {

		$response = (object) ["user" => "user content"];

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"send" => true,
			"getSuccess" => true,
			"getResponse" => $response,
			"updateOutOfResponse" => "result"
		]);

		$user = new User();
		$result = $user->info();

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["users.info", "GET", ["userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("getResponse");
		$stub->verifyInvokedOnce("updateOutOfResponse", ["user content"]);
	}

	public function testDeleteFailed() {

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"send" => true,
			"getSuccess" => false,
			"setUserId" => "nothing"
		]);

		$user = new User();
		$result = $user->delete();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["users.delete", "POST", ["userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("setUserId");
	}

	public function testDeleteSuccess() {

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"send" => true,
			"getSuccess" => true,
			"setUserId" => "result"
		]);

		$user = new User();
		$result = $user->delete();

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["users.delete", "POST", ["userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("setUserId", [null]);
	}

	public function testSetAvatarFilepathFailed() {

		$user = new User();

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"send" => true,
			"getSuccess" => false,
		]);

		test::double("\ATDev\RocketChat\Users\AvatarFromFile", [
			"getSource" => "some-path"
		]);

		$result = $user->setAvatar(new AvatarFromFile);

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["users.setAvatar", "POST", ["userId" => "userId123"], ["image" => "some-path"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	public function testSetAvatarUrlFailed() {

		$user = new User();

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"send" => true,
			"getSuccess" => false
		]);

		test::double("\ATDev\RocketChat\Users\AvatarFromDomain", [
			"getSource" => "some-domain"
		]);

		$result = $user->setAvatar(new AvatarFromDomain);

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["users.setAvatar", "POST", ["userId" => "userId123", "avatarUrl" => "some-domain"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	public function testSetAvatarFilepathSuccess() {

		$user = new User();

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"send" => true,
			"getSuccess" => true
		]);

		test::double("\ATDev\RocketChat\Users\AvatarFromFile", [
			"getSource" => "some-path"
		]);

		$result = $user->setAvatar(new AvatarFromFile);

		$this->assertSame($user, $result);
		$stub->verifyInvokedOnce("send", ["users.setAvatar", "POST", ["userId" => "userId123"], ["image" => "some-path"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	public function testSetAvatarUrlSuccess() {

		$user = new User();

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"send" => true,
			"getSuccess" => true
		]);

		test::double("\ATDev\RocketChat\Users\AvatarFromDomain", [
			"getSource" => "some-domain"
		]);

		$result = $user->setAvatar(new AvatarFromDomain);

		$this->assertSame($user, $result);
		$stub->verifyInvokedOnce("send", ["users.setAvatar", "POST", ["userId" => "userId123", "avatarUrl" => "some-domain"]]);
		$stub->verifyInvokedOnce("getSuccess");
	}

	public function testGetAvatarFailed() {

		$user = new User();

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"send" => true,
			"getSuccess" => false,
			"getResponseUrl" => null,
			"setAvatarUrl" => true
		]);

		$result = $user->getAvatar();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["users.getAvatar", "GET", ["userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("getResponseUrl");
		$stub->verifyNeverInvoked("setAvatarUrl");
	}

	public function testGetAvatarNoUrlAvailable() {

		$user = new User();

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"send" => true,
			"getSuccess" => true,
			"getResponseUrl" => null,
			"setAvatarUrl" => true
		]);

		$result = $user->getAvatar();

		$this->assertSame($user, $result);
		$stub->verifyInvokedOnce("send", ["users.getAvatar", "GET", ["userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("getResponseUrl");
		$stub->verifyNeverInvoked("setAvatarUrl");
	}

	public function testGetAvatarSuccess() {

		$user = new User();

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"send" => true,
			"getSuccess" => true,
			"getResponseUrl" => "some-url",
			"setAvatarUrl" => $user
		]);

		$result = $user->getAvatar();

		$this->assertSame($user, $result);
		$stub->verifyInvokedOnce("send", ["users.getAvatar", "GET", ["userId" => "userId123"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedMultipleTimes("getResponseUrl", 2);
		$stub->verifyInvokedOnce("setAvatarUrl", ["some-url"]);
	}

	protected function tearDown(): void {

		test::clean(); // remove all registered test doubles
	}
}