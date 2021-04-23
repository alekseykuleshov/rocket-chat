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

        $stub = test::double(get_class($mock), ['updateOutOfResponse' => $mock]);

        $roleFull = new ResponseFixtureFull();
        $mock->createOutOfResponse($roleFull);

        $stub->verifyInvokedOnce('updateOutOfResponse', [$roleFull]);
    }

    public function testGetters()
    {
        $roleFull = new ResponseFixtureFull();

        $mock = $this->getMockBuilder(Data::class)
            ->onlyMethods([
                'getRoleId', 'getUpdatedAt', 'getDescription', 'getMandatory2fa', 'getProtected', 'getName', 'getScope'
            ])
            ->getMockForTrait();

        $mock->method('getRoleId')->willReturn($roleFull->_id);
        $mock->method('getUpdatedAt')->willReturn($roleFull->_updatedAt);
        $mock->method('getDescription')->willReturn($roleFull->description);
        $mock->method('getMandatory2fa')->willReturn($roleFull->mandatory2fa);
        $mock->method('getProtected')->willReturn($roleFull->protected);
        $mock->method('getName')->willReturn($roleFull->name);
        $mock->method('getScope')->willReturn($roleFull->scope);

        $this->assertSame('moderator', $mock->getRoleId());
        $this->assertSame('2021-04-21T03:57:54.603Z', $mock->getUpdatedAt());
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

        $this->assertSame('moderator', $mock->getRoleId());
        $this->assertSame('2021-04-21T03:57:54.603Z', $mock->getUpdatedAt());
        $this->assertSame('description', $mock->getDescription());
        $this->assertFalse($mock->getMandatory2fa());
        $this->assertTrue($mock->getProtected());
        $this->assertSame('moderator', $mock->getName());
        $this->assertSame('Subscriptions', $mock->getScope());

        $role1 = new ResponseFixture1();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($role1);

        $this->assertSame('moderator', $mock->getRoleId());
        $this->assertSame('2021-04-21T03:57:54.603Z', $mock->getUpdatedAt());
        $this->assertSame('description', $mock->getDescription());
        $this->assertFalse($mock->getMandatory2fa());

        $role2 = new ResponseFixture2();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($role2);

        $this->assertTrue($mock->getProtected());
        $this->assertSame('moderator', $mock->getName());
        $this->assertSame('Subscriptions', $mock->getScope());
    }

    public function testInvalidDescription()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ['setDataError' => $mock]);

        $mock->setDescription(123);
        $this->assertNull($mock->getDescription());

        $stub->verifyInvokedOnce('setDataError', ['Invalid description']);
    }

    public function testValidDescription()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ['setDataError' => $mock]);

        $mock->setDescription('description');
        $this->assertSame('description', $mock->getDescription());

        $stub->verifyNeverInvoked('setDataError');
    }

    public function testInvalidName()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ['setDataError' => $mock]);

        $mock->setName(123);
        $this->assertNull($mock->getName());

        $stub->verifyInvokedOnce('setDataError', ['Invalid name']);
    }

    public function testValidName()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ['setDataError' => $mock]);

        $mock->setName('roleName123');
        $this->assertSame('roleName123', $mock->getName());

        $stub->verifyNeverInvoked('setDataError');
    }

    public function testInvalidScope()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ['setDataError' => $mock]);

        $mock->setScope(123);
        $this->assertNull($mock->getScope());

        $stub->verifyInvokedOnce('setDataError', ['Invalid scope']);
    }

    public function testValidScope()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ['setDataError' => $mock]);

        $mock->setScope('Subscriptions');
        $this->assertSame('Subscriptions', $mock->getScope());

        $stub->verifyNeverInvoked('setDataError');
    }

    public function testJsonSerialize()
    {
        $mock = $this->getMockForTrait(Data::class);
        $mock->setName('roleName');

        $this->assertSame([
            'name' => 'roleName'
        ], $mock->jsonSerialize());

        $mock = $this->getMockForTrait(Data::class);
        $mock->setScope('Subscriptions');
        $mock->setDescription('description');

        $this->assertSame([
            'name' => null,
            'scope' => 'Subscriptions',
            'description' => 'description'
        ], $mock->jsonSerialize());
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
