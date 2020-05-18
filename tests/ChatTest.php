<?php namespace ATDev\RocketChat\Tests\Users;

use \PHPUnit\Framework\TestCase;
use \AspectMock\Test as test;

use \ATDev\RocketChat\Chat;

class ChatTest extends TestCase {

	public function testLoginFailedNoError() {

		$stub = test::double("\ATDev\RocketChat\Chat", [
			"send" => true,
			"getResponse" => (object) ["status" => "failed"],
			"setError" => true,
			"setAuthUserId" => true,
			"setAuthToken" => true
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"createOutOfResponse" => "result"
		]);

		$result = Chat::login("asd", "zxc");

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["login", "POST", ["user" => "asd", "password" => "zxc"]]);
		$stub->verifyInvokedMultipleTimes("getResponse", 3);
		$stub->verifyInvokedOnce("setError", ["Unknown error occured while loggin in"]);
		$stub->verifyNeverInvoked("setAuthUserId");
		$stub->verifyNeverInvoked("setAuthToken");
		$user->verifyNeverInvoked("createOutOfResponse");
	}

	public function testLoginFailedWithError() {

		$stub = test::double("\ATDev\RocketChat\Chat", [
			"send" => true,
			"getResponse" => (object) ["status" => "failed", "error" => "something happened"],
			"setError" => true,
			"setAuthUserId" => true,
			"setAuthToken" => true,
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"createOutOfResponse" => "result"
		]);

		$result = Chat::login("asd", "zxc");

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["login", "POST", ["user" => "asd", "password" => "zxc"]]);
		$stub->verifyInvokedMultipleTimes("getResponse", 4);
		$stub->verifyInvokedOnce("setError", ["something happened"]);
		$stub->verifyNeverInvoked("setAuthUserId");
		$stub->verifyNeverInvoked("setAuthToken");
		$user->verifyNeverInvoked("createOutOfResponse");
	}

	public function testLoginSuccessNoAuth() {

		$stub = test::double("\ATDev\RocketChat\Chat", [
			"send" => true,
			"getResponse" => (object) ["data" => (object) ["me" => "some data"]],
			"setError" => true,
			"setAuthUserId" => true,
			"setAuthToken" => true
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"createOutOfResponse" => "result"
		]);

		$result = Chat::login("asd", "zxc", false);

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["login", "POST", ["user" => "asd", "password" => "zxc"]]);
		$stub->verifyInvokedMultipleTimes("getResponse", 2);
		$stub->verifyNeverInvoked("setError");
		$stub->verifyNeverInvoked("setAuthUserId");
		$stub->verifyNeverInvoked("setAuthToken");
		$user->verifyInvokedOnce("createOutOfResponse", ["some data"]);
	}

	public function testLoginSuccessWithAuth() {

		$stub = test::double("\ATDev\RocketChat\Chat", [
			"send" => true,
			"getResponse" => (object) ["status" => "success", "data" => (object) ["me" => "some data", "userId" => "ID", "authToken" => "Tok"]],
			"setError" => true,
			"setAuthUserId" => true,
			"setAuthToken" => true
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"createOutOfResponse" => "result"
		]);

		$result = Chat::login("asd", "zxc");

		$this->assertSame("result", $result);
		$stub->verifyInvokedOnce("send", ["login", "POST", ["user" => "asd", "password" => "zxc"]]);
		$stub->verifyInvokedMultipleTimes("getResponse", 5);
		$stub->verifyNeverInvoked("setError");
		$stub->verifyInvokedOnce("setAuthUserId", ["ID"]);
		$stub->verifyInvokedOnce("setAuthToken", ["Tok"]);
		$user->verifyInvokedOnce("createOutOfResponse", ["some data"]);
	}

	public function testMeFailed() {

		$stub = test::double("\ATDev\RocketChat\Chat", [
			"send" => true,
			"getSuccess" => false,
			"getResponse" => (object) []
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"createOutOfResponse" => "nothing"
		]);

		$result = Chat::me();

		$this->assertSame(false, $result);
		$stub->verifyInvokedOnce("send", ["me", "GET"]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyNeverInvoked("getResponse");
		$user->verifyNeverInvoked("createOutOfResponse");
	}

	public function testMeSuccess() {

		$response = (object) ["something" => "here"];

		$stub = test::double("\ATDev\RocketChat\Chat", [
			"send" => true,
			"getSuccess" => true,
			"getResponse" => $response
		]);

		$user = test::double("\ATDev\RocketChat\Users\User", [
			"createOutOfResponse" => "something"
		]);

		$result = Chat::me();

		$this->assertSame("something", $result);
		$stub->verifyInvokedOnce("send", ["me", "GET"]);
		$stub->verifyInvokedOnce("getSuccess");
		$stub->verifyInvokedOnce("getResponse");
		$user->verifyInvokedOnce("createOutOfResponse", [$response]);
	}

	public function testLogout() {

		$stub = test::double("\ATDev\RocketChat\Chat", [
			"send" => true,
			"setAuthUserId" => true,
			"setAuthToken" => true,
		]);

		$result = Chat::logout();

		$this->assertSame(true, $result);
		$stub->verifyInvokedOnce("send", ["logout", "GET"]);
		$stub->verifyInvokedOnce("setAuthUserId", [null]);
		$stub->verifyInvokedOnce("setAuthToken", [null]);
	}

	protected function tearDown(): void {

		test::clean(); // remove all registered test doubles
	}
}