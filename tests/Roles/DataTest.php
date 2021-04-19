<?php

namespace ATDev\RocketChat\Tests\Roles;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;
use ATDev\RocketChat\Roles\Data;

class DataTest extends TestCase
{
    public function testCreateOutOfResponse()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double(get_class($mock), ["updateOutOfResponse" => $mock]);

        $roleFull = new ResponseFixtureFull();
        $mock->createOutOfResponse($roleFull);

        $stub->verifyInvokedOnce("updateOutOfResponse", [$roleFull]);
    }

    public function testGetters()
    {
        $roleFull = new ResponseFixtureFull();

        $mock = $this->getMockBuilder(Data::class)
            ->onlyMethods([
                'getRoleId', 'getDescription', 'getMandatory2fa', 'getProtected', 'getName', 'getScope'
            ])
            ->getMockForTrait();

        $mock->method('getRoleId')->willReturn($roleFull->_id);
        $mock->method('getDescription')->willReturn($roleFull->description);
        $mock->method('getMandatory2fa')->willReturn($roleFull->mandatory2fa);
        $mock->method('getProtected')->willReturn($roleFull->protected);
        $mock->method('getName')->willReturn($roleFull->name);
        $mock->method('getScope')->willReturn($roleFull->scope);

        $this->assertSame('moderator', $mock->getRoleId());
        $this->assertSame('description', $mock->getDescription());
        $this->assertFalse($mock->getMandatory2fa());
        $this->assertTrue($mock->getProtected());
        $this->assertSame('moderator', $mock->getName());
        $this->assertSame('Subscriptions', $mock->getScope());
    }

    public function testUpdateOutOfResponse()
    {
        $roleFull = new ResponseFixtureFull();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($roleFull);

        $this->assertSame("moderator", $mock->getRoleId());
        $this->assertSame("description", $mock->getDescription());
        $this->assertFalse($mock->getMandatory2fa());
        $this->assertTrue($mock->getProtected());
        $this->assertSame("moderator", $mock->getName());
        $this->assertSame("Subscriptions", $mock->getScope());

        $role1 = new ResponseFixture1();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($role1);

        $this->assertSame("moderator", $mock->getRoleId());
        $this->assertSame("description", $mock->getDescription());
        $this->assertFalse($mock->getMandatory2fa());

        $role2 = new ResponseFixture2();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($role2);

        $this->assertTrue($mock->getProtected());
        $this->assertSame("moderator", $mock->getName());
        $this->assertSame("Subscriptions", $mock->getScope());
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
