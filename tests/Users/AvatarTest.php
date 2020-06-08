<?php

namespace ATDev\RocketChat\Tests\Users;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Users\Avatar;
use ATDev\RocketChat\Users\AvatarFromFile;
use ATDev\RocketChat\Users\AvatarFromDomain;

class AvatarTest extends TestCase
{
    public function testConstructorNoSource()
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);

        $stub = test::double(get_class($mock), ["setSource" => $mock]);

        $stub->construct();

        $stub->verifyNeverInvoked("setSource");
    }

    public function testConstructorWithUserId()
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);

        $stub = test::double(get_class($mock), ["setSource" => $mock]);

        $stub->construct("some-path");

        $stub->verifyInvokedOnce("setSource", ["some-path"]);
    }

    public function testInvalidSource()
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);

        $mock->setSource(123);
        $this->assertNull($mock->getSource());
        $this->assertSame("Invalid avatar source", $mock->getError());
    }

    public function testValidSource()
    {
        $mock = $this->getMockForAbstractClass(Avatar::class);

        $mock->setSource("some-path");
        $this->assertSame("some-path", $mock->getSource());
        $this->assertNull($mock->getError());
    }

    public function testIsFile()
    {
        $this->assertSame(true, AvatarFromFile::IS_FILE);
        $this->assertSame(false, AvatarFromDomain::IS_FILE);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
