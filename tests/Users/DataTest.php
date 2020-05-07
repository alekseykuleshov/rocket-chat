<?php namespace ATDev\RocketChat\Tests\Users;

use \PHPUnit\Framework\TestCase;
use \AspectMock\Test as test;

use \ATDev\RocketChat\Users\Data;

class DataTest extends TestCase {

	public function testConstructorNoUserId() {

		$mock = $this->getMockForTrait(Data::class);

		$stub = test::double(get_class($mock), ["setUserId" => $mock]);

		$stub->construct();

		$stub->verifyNeverInvoked("setUserId");
	}

	public function testConstructorWithUserId() {

		$mock = $this->getMockForTrait(Data::class);

		$stub = test::double(get_class($mock), ["setUserId" => $mock]);

		$stub->construct("asd123asd");

		$stub->verifyInvokedOnce("setUserId", "asd123asd");
	}

	public function testInvalidUserId() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->once())
			->method("setError")
			->with($this->equalTo("Invalid user Id"))
			->will($this->returnValue($mock));

		$mock->setUserId(123);
		$this->assertNull($mock->getUserId());
	}

	public function testValidUserId() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->never())
			->method("setError");

		$mock->setUserId("123");
		$this->assertSame("123", $mock->getUserId());
	}

	public function testInvalidEmail() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->once())
			->method("setError")
			->with($this->equalTo("Invalid email"))
			->will($this->returnValue($mock));

		$mock->setEmail(123);
		$this->assertNull($mock->getEmail());
	}

	public function testInvalidEmailFormat() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->once())
			->method("setError")
			->with($this->equalTo("Invalid email value"))
			->will($this->returnValue($mock));

		$validator = test::double("\Egulias\EmailValidator\EmailValidator", ["isValid" => false]);
		$validation = test::double("\Egulias\EmailValidator\Validation\RFCValidation");

		$mock->setEmail("ajsfsdfasdf");
		$this->assertNull($mock->getEmail());
	}

	public function testValidEmail() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->never())
			->method("setError");

		$validator = test::double("\Egulias\EmailValidator\EmailValidator", ["isValid" => true]);
		$validation = test::double("\Egulias\EmailValidator\Validation\RFCValidation");

		$mock->setEmail("test@example.com");
		$this->assertSame("test@example.com", $mock->getEmail());
	}

	public function testInvalidName() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->once())
			->method("setError")
			->with($this->equalTo("Invalid name"))
			->will($this->returnValue($mock));

		$mock->setName(123);
		$this->assertNull($mock->getName());
	}

	public function testValidName() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->never())
			->method("setError");

		$mock->setName("User Name");
		$this->assertSame("User Name", $mock->getName());
	}

	public function testInvalidPassword() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->once())
			->method("setError")
			->with($this->equalTo("Invalid password"))
			->will($this->returnValue($mock));

		$mock->setPassword(123);
		$this->assertNull($mock->getPassword());
	}

	public function testValidPassword() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->never())
			->method("setError");

		$mock->setPassword("sjdfb235$$");
		$this->assertSame("sjdfb235$$", $mock->getPassword());
	}

	public function testInvalidUsername() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->once())
			->method("setError")
			->with($this->equalTo("Invalid user name"))
			->will($this->returnValue($mock));

		$mock->setUsername(123);
		$this->assertNull($mock->getUsername());
	}

	public function testValidUsername() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->never())
			->method("setError");

		$mock->setUsername("userName");
		$this->assertSame("userName", $mock->getUsername());
	}

	public function testInvalidActive() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->once())
			->method("setError")
			->with($this->equalTo("Invalid active value"))
			->will($this->returnValue($mock));

		$mock->setActive(new \stdClass);
		$this->assertNull($mock->getActive());
	}

	public function testValidActive() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->never())
			->method("setError");

		$mock->setActive(false);
		$this->assertSame(false, $mock->getActive());
	}

	public function testInvalidRoles() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->once())
			->method("setError")
			->with($this->equalTo("Invalid roles value"))
			->will($this->returnValue($mock));

		$mock->setRoles(123);
		$this->assertNull($mock->getRoles());
	}

	public function testValidRoles() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->never())
			->method("setError");

		$mock->setRoles(["admin"]);
		$this->assertSame(["admin"], $mock->getRoles());
	}

	public function testInvalidJoinDefaultChannels() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->once())
			->method("setError")
			->with($this->equalTo("Invalid join default channels value"))
			->will($this->returnValue($mock));

		$mock->setJoinDefaultChannels(123);
		$this->assertNull($mock->getJoinDefaultChannels());
	}

	public function testValidJoinDefaultChannels() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->never())
			->method("setError");

		$mock->setJoinDefaultChannels(false);
		$this->assertSame(false, $mock->getJoinDefaultChannels());
	}

	public function testInvalidRequirePasswordChange() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->once())
			->method("setError")
			->with($this->equalTo("Invalid require password change value"))
			->will($this->returnValue($mock));

		$mock->setRequirePasswordChange(123);
		$this->assertNull($mock->getRequirePasswordChange());
	}

	public function testValidRequirePasswordChange() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->never())
			->method("setError");

		$mock->setRequirePasswordChange(false);
		$this->assertSame(false, $mock->getRequirePasswordChange());
	}

	public function testInvalidSendWelcomeEmail() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->once())
			->method("setError")
			->with($this->equalTo("Invalid send welcome email value"))
			->will($this->returnValue($mock));

		$mock->setSendWelcomeEmail(123);
		$this->assertNull($mock->getSendWelcomeEmail());
	}

	public function testValidSendWelcomeEmail() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->never())
			->method("setError");

		$mock->setSendWelcomeEmail(false);
		$this->assertSame(false, $mock->getSendWelcomeEmail());
	}

	public function testInvalidVerified() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->once())
			->method("setError")
			->with($this->equalTo("Invalid verified value"))
			->will($this->returnValue($mock));

		$mock->setVerified(123);
		$this->assertNull($mock->getVerified());
	}

	public function testValidVerified() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->never())
			->method("setError");

		$mock->setVerified(false);
		$this->assertSame(false, $mock->getVerified());
	}

	public function testInvalidCustomFields() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->once())
			->method("setError")
			->with($this->equalTo("Invalid custom fields name"))
			->will($this->returnValue($mock));

		$mock->setCustomFields(123);
		$this->assertNull($mock->getCustomFields());
	}

	public function testValidCustomFields() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->expects($this->never())
			->method("setError");

		$mock->setCustomFields("asdfasdf");
		$this->assertSame("asdfasdf", $mock->getCustomFields());
	}

	public function testGetUserData() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->setEmail("test@example.com");
		$mock->setName("John Doe");
		$mock->setUsername("jDoe");
		$mock->setPassword("#@$%");
		$mock->setRoles(["somebody", "other"]);
		$mock->setRequirePasswordChange(false);
		$mock->setVerified(true);

		$this->assertSame([
			"email" => "test@example.com",
			"name" => "John Doe",
			"username" => "jDoe",
			"password" => "#@$%",
			"roles" => ["somebody", "other"],
			"requirePasswordChange" => false,
			"verified" => true
		], $mock->getUserData());

		$mock = $this->getMockForTrait(Data::class);
		$mock->setActive(false);
		$mock->setJoinDefaultChannels(false);
		$mock->setSendWelcomeEmail(true);
		$mock->setCustomFields("custom fields");

		$this->assertSame([
			"email" => null,
			"name" => null,
			"username" => null,
			"active" => false,
			"joinDefaultChannels" => false,
			"sendWelcomeEmail" => true,
			"customFields" => "custom fields"
		], $mock->getUserData());
	}

	public function testUpdateOutOfResponse() {

		$userFull = new ResponseFixtureFull();
		$mock = $this->getMockForTrait(Data::class);
		$mock->updateOutOfResponse($userFull);

		$this->assertSame("asd123asd", $mock->getUserId());
		$this->assertSame("2018-01-12T00:12:22.167Z", $mock->getCreatedAt());
		$this->assertSame("test@example.com", $mock->getEmail());
		$this->assertSame(true, $mock->getVerified());
		$this->assertSame("user", $mock->getType());
		$this->assertSame("some", $mock->getStatus());
		$this->assertSame(true, $mock->getActive());
		$this->assertSame(["admin", "guest"], $mock->getRoles());
		$this->assertSame("John Doe", $mock->getName());
		$this->assertSame("2016-12-08T00:22:15.167Z", $mock->getLastLogin());
		$this->assertSame("offline", $mock->getStatusConnection());
		$this->assertSame(-3.5, $mock->getUtcOffset());
		$this->assertSame("jDoe", $mock->getUserName());
		$this->assertSame("https://localhost/avatar.png", $mock->getAvatarUrl());

		$user1 = new ResponseFixture1();
		$mock = $this->getMockForTrait(Data::class);
		$mock->updateOutOfResponse($user1);

		$this->assertSame("asd123asd", $mock->getUserId());
		$this->assertNull($mock->getCreatedAt());
		$this->assertSame("test@example.com", $mock->getEmail());
		$this->assertNull($mock->getVerified());
		$this->assertNull($mock->getType());
		$this->assertSame("some", $mock->getStatus());
		$this->assertNull($mock->getActive());
		$this->assertSame(["admin", "guest"], $mock->getRoles());
		$this->assertNull($mock->getName());
		$this->assertSame("2016-12-08T00:22:15.167Z", $mock->getLastLogin());
		$this->assertNull($mock->getStatusConnection());
		$this->assertSame(-3.5, $mock->getUtcOffset());
		$this->assertNull($mock->getUserName());
		$this->assertSame("https://localhost/avatar.png", $mock->getAvatarUrl());

		$user2 = new ResponseFixture2();
		$mock = $this->getMockForTrait(Data::class);
		$mock->updateOutOfResponse($user2);

		$this->assertNull($mock->getUserId());
		$this->assertSame("2018-01-12T00:12:22.167Z", $mock->getCreatedAt());
		$this->assertNull($mock->getEmail());
		$this->assertNull($mock->getVerified());
		$this->assertSame("user", $mock->getType());
		$this->assertNull($mock->getStatus());
		$this->assertSame(true, $mock->getActive());
		$this->assertNull($mock->getRoles());
		$this->assertSame("John Doe", $mock->getName());
		$this->assertNull($mock->getLastLogin());
		$this->assertSame("offline", $mock->getStatusConnection());
		$this->assertNull($mock->getUtcOffset());
		$this->assertSame("jDoe", $mock->getUserName());
		$this->assertNull($mock->getAvatarUrl());
	}

	public function testCreateOutOfResponse() {

		$mock = $this->getMockForTrait(Data::class);

		$stub = test::double(get_class($mock), ["updateOutOfResponse" => $mock]);

		$userFull = new ResponseFixtureFull();
		$mock->createOutOfResponse($userFull);

		$stub->verifyInvokedOnce("updateOutOfResponse", [$userFull]);
	}

	protected function tearDown(): void {

		test::clean(); // remove all registered test doubles
	}
}