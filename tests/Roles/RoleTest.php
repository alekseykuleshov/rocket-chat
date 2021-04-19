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

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}