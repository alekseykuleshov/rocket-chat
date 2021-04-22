<?php

namespace ATDev\RocketChat\Tests\Roles;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Roles\Role;
use ATDev\RocketChat\Users\User;
use ATDev\RocketChat\Roles\Data;

class RoleTest extends TestCase
{
    public function testListingFailed()
    {
        $stub = test::double('\ATDev\RocketChat\Roles\Role', [
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) [],
            'createOutOfResponse' => 'nothing'
        ]);

        $result = Role::listing();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['roles.list', 'GET']);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testListingSuccess()
    {
        $role1 = new ResponseFixture1();
        $role2 = new ResponseFixture2();
        $response = (object) ['roles' => [$role1, $role2]];

        $stub = test::double('\ATDev\RocketChat\Roles\Role', [
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response,
            'createOutOfResponse' => function ($arg) { return get_class($arg); }
        ]);

        $coll = test::double('\ATDev\RocketChat\Roles\Collection', [
            'add' => true
        ]);

        $result = Role::listing();

        $this->assertInstanceOf('\ATDev\RocketChat\Roles\Collection', $result);
        $stub->verifyInvokedOnce('send', ['roles.list', 'GET']);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('createOutOfResponse', [$role1]);
        $stub->verifyInvokedOnce('createOutOfResponse', [$role2]);
        $coll->verifyInvokedOnce('add', ['ATDev\RocketChat\Tests\Roles\ResponseFixture1']);
        $coll->verifyInvokedOnce('add', ['ATDev\RocketChat\Tests\Roles\ResponseFixture2']);
    }

    public function testSyncFailed()
    {
        $stub = test::double('\ATDev\RocketChat\Roles\Role', [
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) [],
            'createOutOfResponse' => 'nothing'
        ]);

        $result = Role::sync("2021-04-19T15:08:17.248Z");

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['roles.sync', 'GET', ['updatedSince' => '2021-04-19T15:08:17.248Z']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testSyncSuccess()
    {
        $role1 = new ResponseFixture1();
        $role2 = new ResponseFixture2();
        $role3 = new ResponseFixture1();
        $role4 = new ResponseFixture2();
        $response = (object) ['roles' => (object) ['update' => [$role1, $role2], 'remove' => [$role3, $role4]]];
        $stub = test::double('ATDev\RocketChat\Roles\Role', [
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response,
            'createOutOfResponse' => function ($arg) { return get_class($arg); }
        ]);

        $result = Role::sync("2021-04-19T15:08:17.248Z");

        $this->assertIsArray($result);
        $stub->verifyInvokedOnce('send', ['roles.sync', 'GET', ['updatedSince' => '2021-04-19T15:08:17.248Z']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
    }

    public function testCreateFailed()
    {
        $stub = test::double('\ATDev\RocketChat\Roles\Role', [
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) [],
            'updateOutOfResponse' => 'nothing'
        ]);

        $role = new Role();
        $result = $role->create();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['roles.create', 'POST', $role]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testCreateSuccess()
    {
        $response = (object) ['role' => 'role content'];

        $stub = test::double('\ATDev\RocketChat\Roles\Role', [
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response,
            'updateOutOfResponse' => 'result'
        ]);

        $role = new Role();
        $result = $role->create();

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['roles.create', 'POST', $role]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', ['role content']);
    }

    public function testAddUserToRoleFailed()
    {
        $stub = test::double('\ATDev\RocketChat\Roles\Role', [
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) [],
            'updateOutOfResponse' => 'nothing'
        ]);
        $data = [
            'roleName' => 'roleName123',
            'username' => 'username123'
        ];

        $role = (new Role())->setName('roleName123');
        $user = (new User())->setUsername('username123');

        $result = $role->addUserToRole($user);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['roles.addUserToRole', 'POST', $data]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testAddUserToRoleSuccess()
    {
        $response = (object) ['role' => 'role content'];
        $stub = test::double('\ATDev\RocketChat\Roles\Role', [
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response,
            'updateOutOfResponse' => 'result'
        ]);
        $data = [
            'roleName' => 'roleName123',
            'username' => 'username123',
            'roomId' => 'roomId123',
        ];

        $role = (new Role())->setName('roleName123');
        $user = (new User())->setUsername('username123');

        $result = $role->addUserToRole($user, 'roomId123');

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['roles.addUserToRole', 'POST', $data]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', $response);
    }

    public function testGetUsersInRoleFailed()
    {
        $stub = test::double('\ATDev\RocketChat\Roles\Role', [
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $userStub = test::double('\ATDev\RocketChat\Users\User', ['createOutOfResponse' => 'nothing']);

        $role = (new Role())->setName('roleName123');
        $result = $role->getUsersInRole(5, 10, "roomId123");

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce(
            'send',
            ['roles.getUsersInRole', 'GET', ['offset' => 5, 'count' => 10, 'role' => 'roleName123', 'roomId' => 'roomId123']]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $userStub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testGetUsersInRoleSuccess()
    {
        $user1 = new \ATDev\RocketChat\Tests\Users\ResponseFixture1();
        $user2 = new \ATDev\RocketChat\Tests\Users\ResponseFixture2();
        $response = (object) [
            'users' => [$user1, $user2],
            'total' => 30
        ];
        $stub = test::double('\ATDev\RocketChat\Roles\Role', [
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response
        ]);
        $userStub = test::double(
            '\ATDev\RocketChat\Users\User',
            ['createOutOfResponse' => function ($arg) {
                return $arg;
            }]
        );
        $collection = test::double('\ATDev\RocketChat\Users\Collection', ['add' => true]);

        $role = (new Role())->setName('roleName123');
        $result = $role->getUsersInRole(5, 10, "roomId123");

        $this->assertInstanceOf('\ATDev\RocketChat\Users\Collection', $result);
        $stub->verifyInvokedOnce(
            'send',
            [
                'roles.getUsersInRole',
                'GET',
                ['offset' => 5, 'count' => 10, 'role' => 'roleName123', 'roomId' => 'roomId123']
            ]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $userStub->verifyInvokedOnce('createOutOfResponse', [$user1]);
        $userStub->verifyInvokedOnce('createOutOfResponse', [$user2]);
        $collection->verifyInvokedOnce('add', [$user1]);
        $collection->verifyInvokedOnce('add', [$user2]);
        $this->assertSame(30, $result->getTotal());
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