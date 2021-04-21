<?php

namespace ATDev\RocketChat\Tests\Roles;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Roles\Role;

class RoleTest extends TestCase
{
    public function testListingFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Roles\Role", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "createOutOfResponse" => "nothing"
        ]);

        $result = Role::listing();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["roles.list", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("createOutOfResponse");
    }

    public function testListingSuccess()
    {
        $role1 = new ResponseFixture1();
        $role2 = new ResponseFixture2();
        $response = (object) ["roles" => [$role1, $role2]];

        $stub = test::double("\ATDev\RocketChat\Roles\Role", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "createOutOfResponse" => function ($arg) { return get_class($arg); }
        ]);

        $coll = test::double("\ATDev\RocketChat\Roles\Collection", [
            "add" => true
        ]);

        $result = Role::listing();

        $this->assertInstanceOf("\ATDev\RocketChat\Roles\Collection", $result);
        $stub->verifyInvokedOnce("send", ["roles.list", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("createOutOfResponse", [$role1]);
        $stub->verifyInvokedOnce("createOutOfResponse", [$role2]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Roles\ResponseFixture1"]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Roles\ResponseFixture2"]);
    }

    public function testSyncFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Roles\Role", [
            "updatedSince" => "2021-04-19T15:08:17.248Z",
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "createOutOfResponse" => "nothing"
        ]);

        $role = new Role();
        $role->setUpdatedSince("2021-04-19T15:08:17.248Z");
        $result = $role->sync();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["roles.sync", "GET", ["updatedSince" => "2021-04-19T15:08:17.248Z"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("createOutOfResponse");
    }

    public function testSyncSuccess()
    {
        $role1 = new ResponseFixture1();
        $role2 = new ResponseFixture2();
        $role3 = new ResponseFixture1();
        $role4 = new ResponseFixture2();
        $response = (object) ["roles" => (object) ["update" => [$role1, $role2], "remove" => [$role3, $role4]]];
        $stub = test::double("ATDev\RocketChat\Roles\Role", [
            "updatedSince" => "2021-04-19T15:08:17.248Z",
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "createOutOfResponse" => function ($arg) { return get_class($arg); }
        ]);

        $role = new Role();
        $role->setUpdatedSince("2021-04-19T15:08:17.248Z");
        $result = $role->sync();

        $this->assertInstanceOf("\ATDev\RocketChat\Roles\Role", $result);
        $stub->verifyInvokedOnce("send", ["roles.sync", "GET", ["updatedSince" => "2021-04-19T15:08:17.248Z"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
    }

    public function testCreateFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Roles\Role", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);
        $createData = [
            'name' => 'newRole',
            'scope' => 'Subscriptions',
            'description' => 'Role description'
        ];
        $role = new Role();
        $role->setName("newRole");
        $role->setScope("Subscriptions");
        $role->setDescription("Role description");

        $result = $role->create();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["roles.create", "POST", $createData]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testCreateSuccess()
    {
        $response = (object) ["role" => "role content"];
        $stub = test::double("\ATDev\RocketChat\Roles\Role", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $createData = [
            'name' => 'newRole',
            'scope' => 'Subscriptions',
            'description' => 'Role description'
        ];
        $role = new Role();
        $role->setName("newRole");
        $role->setScope("Subscriptions");
        $role->setDescription("Role description");

        $result = $role->create();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["roles.create", "POST", $createData]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["role content"]);
    }

    public function testAddUserToRoleFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Roles\Role", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $role = new Role();
        $result = $role->addUserToRole();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["roles.addUserToRole", "POST", $role]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testAddUserToRoleSuccess()
    {
        $response = (object) ["role" => "role content"];

        $stub = test::double("\ATDev\RocketChat\Roles\Role", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $role = new Role();
        $result = $role->addUserToRole();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["roles.addUserToRole", "POST", $role]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["role content"]);
    }

    public function testGetUsersInRoleFailed()
    {
        $stub = test::double('\ATDev\RocketChat\Roles\Role', [
            'getRole' => 'role123',
            'getRoomId' => 'roomId123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $userStub = test::double('\ATDev\RocketChat\Users\User', ['createOutOfResponse' => 'nothing']);

        $role = new Role();
        $result = $role->getUsersInRole();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce(
            'send',
            ['roles.getUsersInRole', 'GET', ['offset' => 0, 'count' => 0, 'role' => 'role123', 'roomId' => 'roomId123']]
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
            "users" => [$user1, $user2],
            "total" => 30
        ];
        $stub = test::double("\ATDev\RocketChat\Roles\Role", [
            'getRole' => 'role123',
            'getRoomId' => 'roomId123',
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

        $role = new Role();
        $result = $role->getUsersInRole(2, 10);

        $this->assertInstanceOf('\ATDev\RocketChat\Users\Collection', $result);
        $stub->verifyInvokedOnce(
            'send',
            [
                'roles.getUsersInRole',
                'GET',
                ['offset' => 2, 'count' => 10, 'role' => 'role123', 'roomId' => 'roomId123']
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

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}