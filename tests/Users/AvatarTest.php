<?php namespace ATDev\RocketChat\Tests\Users;

use \PHPUnit\Framework\TestCase;
use \AspectMock\Test as test;

use \ATDev\RocketChat\Users\Avatar;

class AvatarTest extends TestCase {

	public function testInvalidNewAvatarFilepath() {

		$mock = $this->getMockForTrait(Avatar::class);

		$stub = test::double($mock, ["setAvatarError" => $mock]);

		$mock->setNewAvatarFilepath(123);
		$this->assertNull($mock->getNewAvatarFilepath());

		$stub->verifyInvokedOnce("setAvatarError", ["Invalid avatar filepath value"]);
	}

	public function testValidNewAvatarFilepath() {

		$mock = $this->getMockForTrait(Avatar::class);

		$stub = test::double($mock, ["setAvatarError" => $mock]);

		$mock->setNewAvatarFilepath("some-path");
		$this->assertSame("some-path", $mock->getNewAvatarFilepath());

		// And null value...
		$mock->setNewAvatarFilepath(null);
		$this->assertSame(null, $mock->getNewAvatarFilepath());

		$stub->verifyNeverInvoked("setAvatarError");
	}

	public function testInvalidNewAvatarUrl() {

		$mock = $this->getMockForTrait(Avatar::class);

		$stub = test::double($mock, ["setAvatarError" => $mock]);

		$mock->setNewAvatarUrl(123);
		$this->assertNull($mock->getNewAvatarUrl());

		$stub->verifyInvokedOnce("setAvatarError", ["Invalid avatar url value"]);
	}

	public function testValidNewAvatarUrl() {

		$mock = $this->getMockForTrait(Avatar::class);

		$stub = test::double($mock, ["setAvatarError" => $mock]);

		$mock->setNewAvatarUrl("some-url");
		$this->assertSame("some-url", $mock->getNewAvatarUrl());

		// And null value...
		$mock->setNewAvatarUrl(null);
		$this->assertSame(null, $mock->getNewAvatarUrl());

		$stub->verifyNeverInvoked("setAvatarError");
	}

	protected function tearDown(): void {

		test::clean(); // remove all registered test doubles
	}
}