<?php namespace ATDev\RocketChat\Tests\Channels;

use \PHPUnit\Framework\TestCase;
use \AspectMock\Test as test;

use \ATDev\RocketChat\Channels\Collection;
use \ATDev\RocketChat\Channels\Channel;

class CollectionTest extends TestCase {

	public function testInvalidAdd() {

		$stub = test::double("\Doctrine\Common\Collections\ArrayCollection", ["add" => "not_added"]);

		$collection = new Collection();
		$result = $collection->add(123);

		$this->assertSame(false, $result);
		$stub->verifyNeverInvoked("add");
	}

	public function testValidAdd() {

		$stub = test::double("\Doctrine\Common\Collections\ArrayCollection", ["add" => "added"]);

		$collection = new Collection();
		$channel = new Channel();
		$result = $collection->add($channel);

		$this->assertSame("added", $result);
		$stub->verifyInvokedOnce("add", [$channel]);
	}

	protected function tearDown(): void {

		test::clean(); // remove all registered test doubles
	}
}