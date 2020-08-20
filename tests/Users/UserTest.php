<?php

namespace ATDev\RocketChat\Tests\Users;

use ATDev\RocketChat\Users\Collection;
use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Users\User;
use ATDev\RocketChat\Users\AvatarFromFile;
use ATDev\RocketChat\Users\AvatarFromDomain;
use ATDev\RocketChat\Users\Preferences;

class UserTest extends TestCase
{
    public function testListingFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "createOutOfResponse" => "nothing"
        ]);

        $result = User::listing();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.list", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("createOutOfResponse");
    }

    public function testListingSuccess()
    {
        $user1 = new ResponseFixture1();
        $user2 = new ResponseFixture2();
        $response = (object) ["users" => [$user1, $user2]];

        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "createOutOfResponse" => function ($arg) { return get_class($arg); }
        ]);

        $coll = test::double("\ATDev\RocketChat\Users\Collection", [
            "add" => true
        ]);

        $result = User::listing();

        $this->assertInstanceOf("\ATDev\RocketChat\Users\Collection", $result);
        $stub->verifyInvokedOnce("send", ["users.list", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("createOutOfResponse", [$user1]);
        $stub->verifyInvokedOnce("createOutOfResponse", [$user2]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Users\ResponseFixture1"]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Users\ResponseFixture2"]);
    }

    public function testCreateFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $user = new User();
        $result = $user->create();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.create", "POST", $user]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testCreateSuccess()
    {
        $response = (object) ["user" => "user content"];

        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $user = new User();
        $result = $user->create();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["users.create", "POST", $user]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["user content"]);
    }

    public function testUpdateFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $user = new User();
        $result = $user->update();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.update", "POST", ["userId" => "userId123", "data" => $user]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testUpdateSuccess()
    {
        $response = (object) ["user" => "user content"];

        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $user = new User();
        $result = $user->update();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["users.update", "POST", ["userId" => "userId123", "data" => $user]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["user content"]);
    }

    public function testInfoFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $user = new User();
        $result = $user->info();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.info", "GET", ["userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testInfoSuccess()
    {
        $response = (object) ["user" => "user content"];

        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $user = new User();
        $result = $user->info();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["users.info", "GET", ["userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["user content"]);
    }

    public function testDeleteFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => false,
            "setUserId" => "nothing"
        ]);

        $user = new User();
        $result = $user->delete();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.delete", "POST", ["userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("setUserId");
    }

    public function testDeleteSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => true,
            "setUserId" => "result"
        ]);

        $user = new User();
        $result = $user->delete();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["users.delete", "POST", ["userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("setUserId", [null]);
    }

    public function testSetAvatarFilepathFailed()
    {
        $user = new User();

        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => false,
        ]);

        test::double("\ATDev\RocketChat\Users\AvatarFromFile", [
            "getSource" => "some-path"
        ]);

        $result = $user->setAvatar(new AvatarFromFile());

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.setAvatar", "POST", ["userId" => "userId123"], ["image" => "some-path"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testSetAvatarUrlFailed()
    {
        $user = new User();

        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => false
        ]);

        test::double("\ATDev\RocketChat\Users\AvatarFromDomain", [
            "getSource" => "some-domain"
        ]);

        $result = $user->setAvatar(new AvatarFromDomain());

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.setAvatar", "POST", ["userId" => "userId123", "avatarUrl" => "some-domain"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testSetAvatarFilepathSuccess()
    {
        $user = new User();

        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => true
        ]);

        test::double("\ATDev\RocketChat\Users\AvatarFromFile", [
            "getSource" => "some-path"
        ]);

        $result = $user->setAvatar(new AvatarFromFile());

        $this->assertSame($user, $result);
        $stub->verifyInvokedOnce("send", ["users.setAvatar", "POST", ["userId" => "userId123"], ["image" => "some-path"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testSetAvatarUrlSuccess()
    {
        $user = new User();

        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => true
        ]);

        test::double("\ATDev\RocketChat\Users\AvatarFromDomain", [
            "getSource" => "some-domain"
        ]);

        $result = $user->setAvatar(new AvatarFromDomain());

        $this->assertSame($user, $result);
        $stub->verifyInvokedOnce("send", ["users.setAvatar", "POST", ["userId" => "userId123", "avatarUrl" => "some-domain"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testGetAvatarFailed()
    {
        $user = new User();

        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => false,
            "getResponseUrl" => null,
            "setAvatarUrl" => true
        ]);

        $result = $user->getAvatar();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.getAvatar", "GET", ["userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponseUrl");
        $stub->verifyNeverInvoked("setAvatarUrl");
    }

    public function testGetAvatarNoUrlAvailable()
    {
        $user = new User();

        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => true,
            "getResponseUrl" => null,
            "setAvatarUrl" => true
        ]);

        $result = $user->getAvatar();

        $this->assertSame($user, $result);
        $stub->verifyInvokedOnce("send", ["users.getAvatar", "GET", ["userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponseUrl");
        $stub->verifyNeverInvoked("setAvatarUrl");
    }

    public function testGetAvatarSuccess()
    {
        $user = new User();

        $stub = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => true,
            "getResponseUrl" => "some-url",
            "setAvatarUrl" => $user
        ]);

        $result = $user->getAvatar();

        $this->assertSame($user, $result);
        $stub->verifyInvokedOnce("send", ["users.getAvatar", "GET", ["userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedMultipleTimes("getResponseUrl", 2);
        $stub->verifyInvokedOnce("setAvatarUrl", ["some-url"]);
    }

    public function testResetAvatarFailed()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => false,
            "getUsername" => "username123"
        ]);
        $result = (new User())->resetAvatar();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.resetAvatar", "POST", ["username" => "username123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testResetAvatarSuccess()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getUserId" => "userId123"
        ]);
        $result = (new User())->resetAvatar();

        $this->assertSame(true, $result);
        $stub->verifyInvokedOnce("send", ["users.resetAvatar", "POST", ["userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testUpdateOwnBasicInfoFailed()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => false
        ]);
        $updateData = [
            'email' => 'test@updated.com',
            'name' => 'Updated Name',
            'username' => null,
            'currentPassword' => hash('sha256', 'current-pass')
        ];
        $user = new User();
        $user->setEmail('test@updated.com');
        $user->setName('Updated Name');
        $user->setPassword(hash('sha256', 'current-pass'));

        $result = $user->updateOwnBasicInfo();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.updateOwnBasicInfo", "POST", ["data" => $updateData]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testUpdateOwnBasicInfoSuccess()
    {
        $response = (object) ["user" => "update result"];
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "updated user result"
        ]);

        $updateData = [
            'email' => 'test@updated.com',
            'name' => 'Updated Name',
            'username' => null,
            'currentPassword' => hash('sha256', 'current-pass'),
            'newPassword' => 'new0pass',
            'customFields' => "{ twitter: '@example' }",
        ];
        $user = new User();
        $user->setEmail('test@updated.com');
        $user->setName('Updated Name');
        $user->setPassword(hash('sha256', 'current-pass'));
        $user->setNewPassword('new0pass');
        $user->setCustomFields("{ twitter: '@example' }");

        $result = $user->updateOwnBasicInfo();

        $this->assertSame("updated user result", $result);
        $stub->verifyInvokedOnce("send", ["users.updateOwnBasicInfo", "POST", ["data" => $updateData]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", "update result");
    }

    public function testSetActiveStatusFailed()
    {
        $stub = test::double(User::class, [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $user = new User();
        $result = $user->setActiveStatus(true);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.setActiveStatus", "POST", ["activeStatus" => true, "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testSetActiveStatusSuccess()
    {
        $response = (object) ["user" => "user content"];
        $stub = test::double(User::class, [
            "getUserId" => "userId123",
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $user = new User();
        $result = $user->setActiveStatus(false);

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["users.setActiveStatus", "POST", ["activeStatus" => false, "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["user content"]);
    }

    public function testSetStatusFailed()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => false]);
        $user = new User();
        $result = $user->setStatus("Status message");

        $this->assertSame(false, $result);
        $this->assertNull($user->getStatusText());
        $this->assertNull($user->getStatusValue());
        $stub->verifyInvokedOnce("send", ["users.setStatus", "POST", ["message" => "Status message"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testSetStatusSuccess()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => true]);
        $user = new User();
        $result = $user->setStatus("Status message", "away");

        $this->assertSame($user, $result);
        $this->assertSame("Status message", $user->getStatusText());
        $this->assertSame("away", $user->getStatusValue());
        $stub->verifyInvokedOnce("send", ["users.setStatus", "POST", ["message" => "Status message", "status" => "away"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testGetStatusFailed()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => false]);
        $result = (new User())->getStatus();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("getUserId");
        $stub->verifyInvokedOnce("getUsername");
        $stub->verifyInvokedOnce("send", ["users.getStatus", "GET", []]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testGetStatusWithUsernameFailed()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => false,
            "getUsername" => "user-name",
            "getUserId" => null,
        ]);

        $user = new User();
        $result = $user->getStatus();
        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.getStatus", "GET", ["username" => "user-name"]]);
        $stub->verifyInvokedOnce("getUserId");
        $stub->verifyInvokedMultipleTimes("getUsername", 2);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testGetStatusSuccess()
    {
        $response = (object) [
            "message" => "Latest status",
            "connectionStatus" => "online",
            "status" => "online"
        ];
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "userInstance"
        ]);

        $result = (new User())->getStatus();
        $this->assertSame("userInstance", $result);
        $stub->verifyInvokedOnce("send", ["users.getStatus", "GET", []]);
        $stub->verifyInvokedOnce("getUserId");
        $stub->verifyInvokedOnce("getUsername");
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("updateOutOfResponse", $response);
    }

    public function testGetStatusWithUserIdSuccess()
    {
        $response = (object) [
            "_id" => "userId123",
            "message" => "Latest status",
            "connectionStatus" => "online",
            "status" => "online"
        ];
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "userInstance",
            "getUserId" => "userId123",
            "getUsername" => null
        ]);

        $result = (new User())->getStatus();
        $this->assertSame("userInstance", $result);
        $stub->verifyInvokedOnce("send", ["users.getStatus", "GET", ["userId" => "userId123"]]);
        $stub->verifyInvokedMultipleTimes("getUserId", 2);
        $stub->verifyNeverInvoked("getUsername");
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("updateOutOfResponse", $response);
    }

    public function testForgotPasswordFailed()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => false]);
        $response = User::forgotPassword("email123");

        $this->assertSame(false, $response);
        $stub->verifyInvokedOnce("send", ["users.forgotPassword", "POST", ["email" => "email123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testForgotPasswordSuccess()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => true]);
        $response = User::forgotPassword("email123");

        $this->assertSame(true, $response);
        $stub->verifyInvokedOnce("send", ["users.forgotPassword", "POST", ["email" => "email123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testDeactivateIdleFailed()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => false]);
        $response = User::deactivateIdle(5);

        $this->assertSame(false, $response);
        $stub->verifyInvokedOnce("send", ["users.deactivateIdle", "POST", ["daysIdle" => 5, "role" => "user"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
    }

    public function testDeactivateIdleSuccess()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => (object) ["count" => 10]
        ]);
        $response = User::deactivateIdle(5, "guest");

        $this->assertSame(10, $response);
        $stub->verifyInvokedOnce("send", ["users.deactivateIdle", "POST", ["daysIdle" => 5, "role" => "guest"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
    }

    public function testDeleteOwnAccountFailed()
    {
        $stub = test::double(
            User::class,
            ['send' => true, 'getSuccess' => false, 'getPassword' => 'pass123']
        );
        $response = (new User())->deleteOwnAccount();

        $this->assertSame(false, $response);
        $stub->verifyInvokedOnce('getPassword');
        $stub->verifyInvokedOnce('send', ['users.deleteOwnAccount', 'POST', ['password' => 'pass123']]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testDeleteOwnAccountSuccess()
    {
        $stub = test::double(
            User::class,
            ['send' => true, 'getSuccess' => true, 'getPassword' => 'pass123']
        );
        $user = new User();
        $user->setUserId('testUserId');
        $this->assertSame('testUserId', $user->getUserId());
        $user->setUsername('testUsername');
        $this->assertSame('testUsername', $user->getUsername());
        $response = $user->deleteOwnAccount();

        $this->assertSame($user, $response);
        $this->assertNull($user->getUserId());
        $this->assertNull($user->getUsername());
        $stub->verifyInvokedOnce('getPassword');
        $stub->verifyInvokedOnce('send', ['users.deleteOwnAccount', 'POST', ['password' => 'pass123']]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testGetUsernameSuggestionFailed()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => false]);
        $response = User::getUsernameSuggestion();

        $this->assertSame(false, $response);
        $stub->verifyInvokedOnce("send", ["users.getUsernameSuggestion", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
    }

    public function testGetUsernameSuggestionNull()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => null
        ]);
        $response = User::getUsernameSuggestion();

        $this->assertNull($response);
        $stub->verifyInvokedOnce("send", ["users.getUsernameSuggestion", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
    }

    public function testGetUsernameSuggestionSuccess()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => (object) ["result" => "response"]
        ]);
        $response = User::getUsernameSuggestion();

        $this->assertSame("response", $response);
        $stub->verifyInvokedOnce("send", ["users.getUsernameSuggestion", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedMultipleTimes("getResponse", 2);
    }

    public function testCreateTokenFailed()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => false,
            "getUsername" => "username123",
            "getUserId" => null
        ]);
        $response = User::createToken(new User());

        $this->assertSame(false, $response);
        $stub->verifyInvokedOnce("send", ["users.createToken", "POST", ["username" => "username123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedMultipleTimes("getUsername", 2);
        $stub->verifyInvokedOnce("getUserId");
        $stub->verifyNeverInvoked("getResponse");
    }

    public function testCreateTokenNull()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getUserId" => "userId123",
            "getUsername" => null,
            "getResponse" => null
        ]);
        $response = User::createToken(new User());

        $this->assertNull($response);
        $stub->verifyInvokedOnce("send", ["users.createToken", "POST", ["userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getUsername");
        $stub->verifyInvokedMultipleTimes("getUserId", 2);
        $stub->verifyInvokedOnce("getResponse", 2);
    }

    public function testCreateTokenSuccess()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getUserId" => "userId123",
            "getUsername" => null,
            "getResponse" => (object) [
                "data" => "response object"
            ]
        ]);
        $response = User::createToken(new User());

        $this->assertSame("response object", $response);
        $stub->verifyInvokedOnce("send", ["users.createToken", "POST", ["userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getUsername");
        $stub->verifyInvokedMultipleTimes("getUserId", 2);
        $stub->verifyInvokedMultipleTimes("getResponse", 2);
    }

    public function testGetPersonalAccessTokensFailed()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => false]);
        $response = User::getPersonalAccessTokens();

        $this->assertSame(false, $response);
        $stub->verifyInvokedOnce("send", ["users.getPersonalAccessTokens", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
    }

    public function testGetPersonalAccessTokensNull()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => null
        ]);
        $response = User::getPersonalAccessTokens();

        $this->assertNull($response);
        $stub->verifyInvokedOnce("send", ["users.getPersonalAccessTokens", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
    }

    public function testGetPersonalAccessTokensSuccess()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => (object) ["tokens" => "personal tokens array"]
        ]);
        $response = User::getPersonalAccessTokens();

        $this->assertSame("personal tokens array", $response);
        $stub->verifyInvokedOnce("send", ["users.getPersonalAccessTokens", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedMultipleTimes("getResponse", 2);
    }

    public function testGeneratePersonalAccessTokenFailed()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => false]);
        $response = User::generatePersonalAccessToken("token-name");

        $this->assertSame(false, $response);
        $stub->verifyInvokedOnce(
            "send",
            ["users.generatePersonalAccessToken", "POST", ["tokenName" => "token-name", "bypassTwoFactor" => false]]
        );
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
    }

    public function testGeneratePersonalAccessTokenNull()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => null
        ]);
        $response = User::generatePersonalAccessToken("token-name");

        $this->assertNull($response);
        $stub->verifyInvokedOnce(
            "send",
            ["users.generatePersonalAccessToken", "POST", ["tokenName" => "token-name", "bypassTwoFactor" => false]]
        );
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
    }

    public function testGeneratePersonalAccessTokenSuccess()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => (object) ["token" => "personal-token"]
        ]);
        $response = User::generatePersonalAccessToken("token-name", true);

        $this->assertSame("personal-token", $response);
        $stub->verifyInvokedOnce(
            "send",
            ["users.generatePersonalAccessToken", "POST", ["tokenName" => "token-name", "bypassTwoFactor" => true]]
        );
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedMultipleTimes("getResponse", 2);
    }

    public function testRegeneratePersonalAccessTokenFailed()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => false]);
        $response = User::regeneratePersonalAccessToken("token-name");

        $this->assertSame(false, $response);
        $stub->verifyInvokedOnce(
            "send",
            ["users.regeneratePersonalAccessToken", "POST", ["tokenName" => "token-name"]]
        );
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
    }

    public function testRegeneratePersonalAccessTokenNull()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => null
        ]);
        $response = User::regeneratePersonalAccessToken("token-name");

        $this->assertNull($response);
        $stub->verifyInvokedOnce(
            "send",
            ["users.regeneratePersonalAccessToken", "POST", ["tokenName" => "token-name"]]
        );
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
    }

    public function testRegeneratePersonalAccessTokenSuccess()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => (object) ["token" => "personal-token"]
        ]);
        $response = User::regeneratePersonalAccessToken("token-name");

        $this->assertSame("personal-token", $response);
        $stub->verifyInvokedOnce(
            "send",
            ["users.regeneratePersonalAccessToken", "POST", ["tokenName" => "token-name"]]
        );
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedMultipleTimes("getResponse", 2);
    }

    public function testRemovePersonalAccessTokenFailed()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => false]);
        $response = User::removePersonalAccessToken("token-name");

        $this->assertSame(false, $response);
        $stub->verifyInvokedOnce(
            "send",
            ["users.removePersonalAccessToken", "POST", ["tokenName" => "token-name"]]
        );
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testRemovePersonalAccessTokenSuccess()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => true]);
        $response = User::removePersonalAccessToken("token-name");

        $this->assertSame(true, $response);
        $stub->verifyInvokedOnce(
            "send",
            ["users.removePersonalAccessToken", "POST", ["tokenName" => "token-name"]]
        );
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testRemoveOtherTokensFailed()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => false]);
        $response = User::removeOtherTokens();

        $this->assertSame(false, $response);
        $stub->verifyInvokedOnce("send", ["users.removeOtherTokens", "POST"]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testRemoveOtherTokensSuccess()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => true]);
        $response = User::removeOtherTokens();

        $this->assertSame(true, $response);
        $stub->verifyInvokedOnce("send", ["users.removeOtherTokens", "POST"]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testRequestDataDownloadFailed()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => false]);
        $response = User::requestDataDownload();

        $this->assertSame(false, $response);
        $stub->verifyInvokedOnce("send", ["users.requestDataDownload", "GET", ["fullExport" => false]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
    }

    public function testRequestDataDownloadSuccess()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => (object) ["exportOperation" => "result"]
        ]);
        $response = User::requestDataDownload(true);

        $this->assertSame("result", $response);
        $stub->verifyInvokedOnce("send", ["users.requestDataDownload", "GET", ["fullExport" => true]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
    }

    public function testGetPreferencesFailed()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => false]);
        $prefStub = test::double(Preferences::class);
        $response = User::getPreferences();

        $this->assertSame(false, $response);
        $stub->verifyInvokedOnce("send", ["users.getPreferences", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $prefStub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testGetPreferencesSuccess()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => (object) ["preferences" => "preferences-result"]
        ]);
        $prefStub = test::double(Preferences::class, ["updateOutOfResponse" => "result"]);
        $response = User::getPreferences();

        $this->assertSame("result", $response);
        $stub->verifyInvokedOnce("send", ["users.getPreferences", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $prefStub->verifyInvokedOnce("updateOutOfResponse", "preferences-result");
    }

    public function testSetPreferencesFailed()
    {
        $stub = test::double(
            User::class,
            ['send' => true, 'getSuccess' => false, 'getUserId' => 'userId123']
        );
        $preferences = new Preferences();
        $response = (new User())->setPreferences($preferences);

        $this->assertSame(false, $response);
        $stub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce(
            'send',
            ['users.setPreferences', 'POST', ['userId' => 'userId123', 'data' => $preferences]]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testSetPreferencesSuccess()
    {
        $stub = test::double(User::class, [
            'send' => true,
            'getSuccess' => true,
            'getResponse' => (object) ['user' => 'user-result'],
            'updateOutOfResponse' => 'result',
            'getUserId' => 'userId123'
        ]);
        $preferences = new Preferences();
        $response = (new User())->setPreferences($preferences);

        $this->assertSame('result', $response);
        $stub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce(
            'send',
            ['users.setPreferences', 'POST', ['userId' => 'userId123', 'data' => $preferences]]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', 'user-result');
    }

    public function testPresenceFailed()
    {
        $stub = test::double(User::class, ["send" => true, "getSuccess" => false]);
        $result = User::presence();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.presence", "GET", ["from" => null]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("createOutOfResponse");
    }

    public function testPresenceSuccess()
    {
        $user1 = new ResponseFixture1();
        $user2 = new ResponseFixture2();
        $response = (object) ["users" => [$user1, $user2], "full" => false];
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "createOutOfResponse" => function ($arg) { return get_class($arg); }
        ]);

        $coll = test::double(Collection::class, ["add" => true, "setFull" => false]);
        $result = User::presence("2019-05-22T12:11:45.392Z");

        $this->assertInstanceOf(Collection::class, $result);
        $stub->verifyInvokedOnce("send", ["users.presence", "GET", ["from" => "2019-05-22T12:11:45.392Z"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("createOutOfResponse", [$user1]);
        $stub->verifyInvokedOnce("createOutOfResponse", [$user2]);
        $coll->verifyInvokedOnce("add", [ResponseFixture1::class]);
        $coll->verifyInvokedOnce("add", [ResponseFixture2::class]);
        $coll->verifyInvokedOnce("setFull", [false]);
    }

    public function testGetPresenceFailed()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => false,
            "getUserId" => null,
            "getUsername" => "username123"
        ]);
        $result = (new User())->getPresence();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["users.getPresence", "GET", ["username" => "username123"]]);
        $stub->verifyInvokedMultipleTimes("getUsername", 2);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyInvokedOnce("getUserId");
    }

    public function testGetPresenceSuccess()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getUserId" => "userId123",
            "getUsername" => null,
            "getResponse" => (object) ["presence" => "away"]
        ]);
        $result = (new User())->getPresence();

        $this->assertIsObject($result);
        $this->assertObjectHasAttribute("presence", $result);
        $this->assertSame("away", $result->presence);
        $this->assertObjectNotHasAttribute("connectionStatus", $result);
        $this->assertObjectNotHasAttribute("lastLogin", $result);
        $stub->verifyInvokedOnce("send", ["users.getPresence", "GET", ["userId" => "userId123"]]);
        $stub->verifyInvokedMultipleTimes("getUserId", 2);
        $stub->verifyNeverInvoked("getUsername");
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
    }

    public function testGetPresenceCalleeSuccess()
    {
        $stub = test::double(User::class, [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => (object) [
                "presence" => "away",
                "connectionStatus" => "offline",
                "lastLogin" => "2016-12-08T18:26:03.612Z"
            ]
        ]);
        $result = (new User())->getPresence();

        $this->assertIsObject($result);
        $this->assertObjectHasAttribute("presence", $result);
        $this->assertSame("away", $result->presence);
        $this->assertObjectHasAttribute("connectionStatus", $result);
        $this->assertSame("offline", $result->connectionStatus);
        $this->assertObjectHasAttribute("lastLogin", $result);
        $this->assertSame("2016-12-08T18:26:03.612Z", $result->lastLogin);
        $stub->verifyInvokedOnce("send", ["users.getPresence", "GET", []]);
        $stub->verifyInvokedOnce("getUsername");
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
