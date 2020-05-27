<?php namespace ATDev\RocketChat\Tests\Messages;

use \PHPUnit\Framework\TestCase;
use \AspectMock\Test as test;
use ATDev\RocketChat\Messages\Collection;
use ATDev\RocketChat\Messages\Message;

class CollectionTest extends TestCase {
    public function testInvalidAdd() {
        $stub = test::double('\Doctrine\Common\Collections\ArrayCollection', ['add' => 'not_added']);

        $collection = new Collection();
        $result = $collection->add('invalid');

        $this->assertSame(false, $result);
        $stub->verifyNeverInvoked('add');
    }

    public function testValidAdd() {
        $stub = test::double('\Doctrine\Common\Collections\ArrayCollection', ['add' => 'added']);

        $collection = new Collection();
        $message = new Message();
        $result = $collection->add($message);

        $this->assertSame('added', $result);
        $stub->verifyInvokedOnce('add', [$message]);
    }

    protected function tearDown(): void {
        test::clean(); // remove all registered test doubles
    }
}