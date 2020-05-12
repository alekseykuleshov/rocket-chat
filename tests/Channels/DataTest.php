<?php namespace ATDev\RocketChat\Tests\Channels;

use \PHPUnit\Framework\TestCase;
use \AspectMock\Test as test;

use \ATDev\RocketChat\Channels\Data;

class DataTest extends TestCase {

	public function testConstructorNoChannelId() {

		$mock = $this->getMockForTrait(Data::class);

		$stub = test::double(get_class($mock), ["setChannelId" => $mock]);

		$stub->construct();

		$stub->verifyNeverInvoked("setChannelId");
	}

	public function testConstructorWithChannelId() {

		$mock = $this->getMockForTrait(Data::class);

		$stub = test::double(get_class($mock), ["setChannelId" => $mock]);

		$stub->construct("asd123asd");

		$stub->verifyInvokedOnce("setChannelId", ["asd123asd"]);
	}

	public function testInvalidChannelId() {

		$mock = $this->getMockForTrait(Data::class);

		$stub = test::double($mock, ["setDataError" => $mock]);

		$mock->setChannelId(123);
		$this->assertNull($mock->getChannelId());

		$stub->verifyInvokedOnce("setDataError", ["Invalid channel Id"]);
	}

	public function testValidChannelId() {

		$mock = $this->getMockForTrait(Data::class);

		$stub = test::double($mock, ["setDataError" => $mock]);

		$mock->setChannelId("123");
		$this->assertSame("123", $mock->getChannelId());

		// And null value...
		$mock->setChannelId(null);
		$this->assertSame(null, $mock->getChannelId());

		$stub->verifyNeverInvoked("setDataError");
	}

	public function testInvalidName() {

		$mock = $this->getMockForTrait(Data::class);

		$stub = test::double($mock, ["setDataError" => $mock]);

		$mock->setName(123);
		$this->assertNull($mock->getName());

		$stub->verifyInvokedOnce("setDataError", ["Invalid name"]);
	}

	public function testValidName() {

		$mock = $this->getMockForTrait(Data::class);

		$stub = test::double($mock, ["setDataError" => $mock]);

		$mock->setName("Channel Name");
		$this->assertSame("Channel Name", $mock->getName());

		// And null value...
		$mock->setName(null);
		$this->assertSame(null, $mock->getName());

		$stub->verifyNeverInvoked("setDataError");
	}

	public function testJsonSerialize() {

		$mock = $this->getMockForTrait(Data::class);
		$mock->setName("channelname");

		$this->assertSame([
			"name" => "channelname"
		], $mock->jsonSerialize());

		$mock = $this->getMockForTrait(Data::class);
		$mock->setReadOnly(true);

		$this->assertSame([
			"name" => null,
			"readOnly" => true
		], $mock->jsonSerialize());
	}

	public function testUpdateOutOfResponse() {

		$channelFull = new ResponseFixtureFull();
		$mock = $this->getMockForTrait(Data::class);
		$mock->updateOutOfResponse($channelFull);

		$this->assertSame("asd123asd", $mock->getChannelId());

		$this->assertSame("Channel Name", $mock->getName());
		$this->assertSame("c", $mock->getT());
		$this->assertSame(6, $mock->getMsgs());
		$this->assertSame(3, $mock->getUsersCount());
		$this->assertSame("2020-05-12T15:24:04.977Z", $mock->getTs());
		$this->assertSame(true, $mock->getReadOnly());
		$this->assertSame(false, $mock->getDefault());
		$this->assertSame(true, $mock->getSysMes());

		$channel1 = new ResponseFixture1();
		$mock = $this->getMockForTrait(Data::class);
		$mock->updateOutOfResponse($channel1);

		$this->assertSame("asd123asd", $mock->getChannelId());
		$this->assertNull($mock->getName());
		$this->assertSame("c", $mock->getT());
		$this->assertNull($mock->getMsgs());
		$this->assertSame(3, $mock->getUsersCount());
		$this->assertSame("2020-05-12T15:24:04.977Z", $mock->getTs());
		$this->assertNull($mock->getReadOnly());
		$this->assertNull($mock->getDefault());
		$this->assertSame(true, $mock->getSysMes());

		$channel2 = new ResponseFixture2();
		$mock = $this->getMockForTrait(Data::class);
		$mock->updateOutOfResponse($channel2);

		$this->assertNull($mock->getChannelId());
		$this->assertSame("Channel Name", $mock->getName());
		$this->assertNull($mock->getT());
		$this->assertSame(6, $mock->getMsgs());
		$this->assertNull($mock->getUsersCount());
		$this->assertNull($mock->getTs());
		$this->assertSame(true, $mock->getReadOnly());
		$this->assertSame(false, $mock->getDefault());
		$this->assertNull($mock->getSysMes());
	}

	public function testCreateOutOfResponse() {

		$mock = $this->getMockForTrait(Data::class);

		$stub = test::double(get_class($mock), ["updateOutOfResponse" => $mock]);

		$channelFull = new ResponseFixtureFull();
		$mock->createOutOfResponse($channelFull);

		$stub->verifyInvokedOnce("updateOutOfResponse", [$channelFull]);
	}

	protected function tearDown(): void {

		test::clean(); // remove all registered test doubles
	}
}