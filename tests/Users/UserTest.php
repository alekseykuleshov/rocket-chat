<?php namespace ATDev\RocketChat\Tests\Users;

use \PHPUnit\Framework\TestCase;
use \AspectMock\Test as test;

use \ATDev\RocketChat\Users\User;

class UserTest extends TestCase {

	public function testLoginFailedNoError() {

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"send" => true,
			"getResponse" => (object) ["status" => "failed"],
			"setError" => true,
			"setAuthUserId" => true,
			"setAuthToken" => true,
			"createOutOfResponse" => "result"
		]);

		$result = User::login("asd", "zxc");

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["login", "POST", ["user" => "asd", "password" => "zxc"]]);
		$stub->verifyInvokedMultipleTimes("getResponse", 3);
		$stub->verifyInvokedOnce("setError", ["Unknown error occured while loggin in"]);
		$stub->verifyNeverInvoked("setAuthUserId");
		$stub->verifyNeverInvoked("setAuthToken");
		$stub->verifyNeverInvoked("createOutOfResponse");
	}

	public function testLoginFailedWithError() {

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"send" => true,
			"getResponse" => (object) ["status" => "failed", "error" => "something happened"],
			"setError" => true,
			"setAuthUserId" => true,
			"setAuthToken" => true,
			"createOutOfResponse" => "result"
		]);

		$result = User::login("asd", "zxc");

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["login", "POST", ["user" => "asd", "password" => "zxc"]]);
		$stub->verifyInvokedMultipleTimes("getResponse", 4);
		$stub->verifyInvokedOnce("setError", ["something happened"]);
		$stub->verifyNeverInvoked("setAuthUserId");
		$stub->verifyNeverInvoked("setAuthToken");
		$stub->verifyNeverInvoked("createOutOfResponse");
	}

	public function testLoginSuccessNoAuth() {

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"send" => true,
			"getResponse" => (object) ["data" => (object) ["me" => "some data"]],
			"setError" => true,
			"setAuthUserId" => true,
			"setAuthToken" => true,
			"createOutOfResponse" => "result"
		]);

		$result = User::login("asd", "zxc", false);

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["login", "POST", ["user" => "asd", "password" => "zxc"]]);
		$stub->verifyInvokedMultipleTimes("getResponse", 2);
		$stub->verifyNeverInvoked("setError");
		$stub->verifyNeverInvoked("setAuthUserId");
		$stub->verifyNeverInvoked("setAuthToken");
		$stub->verifyInvokedOnce("createOutOfResponse", ["some data"]);
	}

	public function testLoginSuccessWithAuth() {

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"send" => true,
			"getResponse" => (object) ["status" => "success", "data" => (object) ["me" => "some data", "userId" => "ID", "authToken" => "Tok"]],
			"setError" => true,
			"setAuthUserId" => true,
			"setAuthToken" => true,
			"createOutOfResponse" => "result"
		]);

		$result = User::login("asd", "zxc");

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["login", "POST", ["user" => "asd", "password" => "zxc"]]);
		$stub->verifyInvokedMultipleTimes("getResponse", 5);
		$stub->verifyNeverInvoked("setError");
		$stub->verifyInvokedOnce("setAuthUserId", ["ID"]);
		$stub->verifyInvokedOnce("setAuthToken", ["Tok"]);
		$stub->verifyInvokedOnce("createOutOfResponse", ["some data"]);
	}

	public function testMeFailed() {

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"send" => true,
			"getSuccess" => false,
			"getResponse" => (object) [],
			"createOutOfResponse" => "nothing"
		]);

		$result = User::me();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["me", "GET"]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("getResponse");
		$stub->verifyNeverInvoked("createOutOfResponse");
	}

	public function testMeSuccess() {

		$response = (object) ["something" => "here"];

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"send" => true,
			"getSuccess" => true,
			"getResponse" => $response,
			"createOutOfResponse" => "something"
		]);

		$result = User::me();

		$this->assertSame("something", $result);
		$stub->verifyInvokedOnce("send", ["me", "GET"]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("getResponse");
		$stub->verifyInvokedOnce("createOutOfResponse", [$response]);
	}

	public function testLogout() {

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"send" => true,
			"setAuthUserId" => true,
			"setAuthToken" => true,
		]);

		$result = User::logout();

		$this->assertSame(true, $result);
		$stub->verifyInvokedOnce("send", ["logout", "GET"]);
		$stub->verifyInvokedOnce("setAuthUserId", [null]);
		$stub->verifyInvokedOnce("setAuthToken", [null]);
	}

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
			"getNewAvatarFilepath" => "filepath",
			"getNewAvatarUrl" => null,
			"send" => true,
			"getSuccess" => false,
			"setNewAvatarFilepath" => $user,
			"setNewAvatarUrl" => "result"
		]);

		$result = $user->setAvatar();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["users.setAvatar", "POST", ["userId" => "userId123"], ["image" => "filepath"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("setNewAvatarFilepath");
		$stub->verifyNeverInvoked("setNewAvatarUrl");
	}

	public function testSetAvatarUrlFailed() {

		$user = new User();

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"getNewAvatarFilepath" => null,
			"getNewAvatarUrl" => "url",
			"send" => true,
			"getSuccess" => false,
			"setNewAvatarFilepath" => $user,
			"setNewAvatarUrl" => "result"
		]);

		$result = $user->setAvatar();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["users.setAvatar", "POST", ["userId" => "userId123", "avatarUrl" => "url"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("setNewAvatarFilepath");
		$stub->verifyNeverInvoked("setNewAvatarUrl");
	}

	public function testSetAvatarNoData() {

		$user = new User();

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getNewAvatarFilepath" => null,
			"getNewAvatarUrl" => null,
			"send" => true,
			"getSuccess" => false,
			"setNewAvatarFilepath" => $user,
			"setNewAvatarUrl" => "result"
		]);

		$result = $user->setAvatar();

		$this->assertSame("result", $result);
		$stub->verifyNeverInvoked("send");
		$stub->verifyNeverInvoked("getSuccess");
		$stub->verifyInvokedOnce("setNewAvatarFilepath", [null]);
		$stub->verifyInvokedOnce("setNewAvatarUrl", [null]);
	}

	public function testSetAvatarFilepathSuccess() {

		$user = new User();

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"getNewAvatarFilepath" => "filepath",
			"getNewAvatarUrl" => null,
			"send" => true,
			"getSuccess" => true,
			"setNewAvatarFilepath" => $user,
			"setNewAvatarUrl" => "result"
		]);

		$result = $user->setAvatar();

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["users.setAvatar", "POST", ["userId" => "userId123"], ["image" => "filepath"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("setNewAvatarFilepath", [null]);
		$stub->verifyInvokedOnce("setNewAvatarUrl", [null]);
	}

	public function testSetAvatarUrlSuccess() {

		$user = new User();

		$stub = test::double("\ATDev\RocketChat\Users\User", [
			"getUserId" => "userId123",
			"getNewAvatarFilepath" => null,
			"getNewAvatarUrl" => "url",
			"send" => true,
			"getSuccess" => true,
			"setNewAvatarFilepath" => $user,
			"setNewAvatarUrl" => "result"
		]);

		$result = $user->setAvatar();

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["users.setAvatar", "POST", ["userId" => "userId123", "avatarUrl" => "url"]]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("setNewAvatarFilepath", [null]);
		$stub->verifyInvokedOnce("setNewAvatarUrl", [null]);
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