<?php

namespace ATDev\RocketChat\Tests\Groups;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Groups\Group;
use ATDev\RocketChat\Users\User;

class GroupTest extends TestCase
{
    public function testListingFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "createOutOfResponse" => "nothing"
        ]);

        $result = Group::listing();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["groups.list", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("createOutOfResponse");
    }

    public function testListingSuccess()
    {
        $group1 = new \ATDev\RocketChat\Tests\Common\ResponseFixture1();
        $group2 = new \ATDev\RocketChat\Tests\Common\ResponseFixture2();
        $response = (object) [
            "groups" => [$group1, $group2],
            "offset" => 2,
            "count" => 10,
            "total" => 30
        ];

        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "createOutOfResponse" => function ($arg) { return get_class($arg); }
        ]);

        $coll = test::double("\ATDev\RocketChat\Groups\Collection", [
            "add" => true
        ]);

        $result = Group::listing();

        $this->assertInstanceOf("\ATDev\RocketChat\Groups\Collection", $result);
        $stub->verifyInvokedOnce("send", ["groups.list", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("createOutOfResponse", [$group1]);
        $stub->verifyInvokedOnce("createOutOfResponse", [$group2]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture1"]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture2"]);
        $this->assertSame(2, $result->getOffset());
        $this->assertSame(10, $result->getCount());
        $this->assertSame(30, $result->getTotal());
    }

    public function testCreateFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $group = new Group();
        $result = $group->create();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["groups.create", "POST", $group]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testCreateSuccess()
    {
        $response = (object) ["group" => "group content"];

        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $group = new Group();
        $result = $group->create();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["groups.create", "POST", $group]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["group content"]);
    }

    public function testDeleteFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => false,
            "setGroupId" => "nothing"
        ]);

        $group = new Group();
        $result = $group->delete();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["groups.delete", "POST", ["roomId" => "groupId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("setGroupId");
    }

    public function testDeleteSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => true,
            "setGroupId" => "result"
        ]);

        $group = new Group();
        $result = $group->delete();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["groups.delete", "POST", ["roomId" => "groupId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("setGroupId", [null]);
    }

    public function testInfoFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $group = new Group();
        $result = $group->info();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["groups.info", "GET", ["roomId" => "groupId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testInfoSuccess()
    {
        $response = (object) ["group" => "group content"];

        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $group = new Group();
        $result = $group->info();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["groups.info", "GET", ["roomId" => "groupId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["group content"]);
    }

    public function testOpenFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $group = new Group();
        $result = $group->open();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["groups.open", "POST", ["roomId" => "groupId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testOpenSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $group = new Group();
        $result = $group->open();

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce("send", ["groups.open", "POST", ["roomId" => "groupId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testInviteFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->invite($user);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["groups.invite", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testInviteSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->invite($user);

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce("send", ["groups.invite", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testKickFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->kick($user);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["groups.kick", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testKickSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->kick($user);

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce("send", ["groups.kick", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testAddOwnerFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->addOwner($user);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["groups.addOwner", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testAddOwnerSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->addOwner($user);

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce("send", ["groups.addOwner", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testRemoveOwnerFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->removeOwner($user);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["groups.removeOwner", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testRemoveOwnerSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->removeOwner($user);

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce("send", ["groups.removeOwner", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testMessagesFailed()
    {
        $stub = test::double('\ATDev\RocketChat\Groups\Group', [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $messageStub = test::double('\ATDev\RocketChat\Messages\Message', ['createOutOfResponse' => 'nothing']);

        $channel = new Group();
        $result = $channel->messages();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce(
            'send',
            ['groups.messages', 'GET', ['roomId' => 'groupId123', 'offset' => 0, 'count' => 0]]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $messageStub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testMessagesSuccess()
    {
        $message1 = new \ATDev\RocketChat\Tests\Messages\ResponseFixture1();
        $message2 = new \ATDev\RocketChat\Tests\Messages\ResponseFixture2();
        $response = (object) [
            'messages' => [$message1, $message2],
            'offset' => 2,
            'count' => 10,
            'total' => 30
        ];
        $stub = test::double('\ATDev\RocketChat\Groups\Group', [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response
        ]);
        $messageStub = test::double(
            '\ATDev\RocketChat\Messages\Message',
            ['createOutOfResponse' => function ($arg) {
                return $arg;
            }]
        );
        $collection = test::double('\ATDev\RocketChat\Messages\Collection', ['add' => true]);

        $channel = new Group();
        $result = $channel->messages(2, 10);

        $this->assertInstanceOf('\ATDev\RocketChat\Messages\Collection', $result);
        $stub->verifyInvokedOnce(
            'send',
            ['groups.messages', 'GET', ['roomId' => 'groupId123', 'offset' => 2, 'count' => 10]]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $messageStub->verifyInvokedOnce('createOutOfResponse', [$message1]);
        $messageStub->verifyInvokedOnce('createOutOfResponse', [$message2]);
        $collection->verifyInvokedOnce('add', [$message1]);
        $collection->verifyInvokedOnce('add', [$message2]);
        $this->assertSame(2, $result->getOffset());
        $this->assertSame(10, $result->getCount());
        $this->assertSame(30, $result->getTotal());
    }

    public function testAddAllFailed()
    {
        $stub = test::double(Group::class, [
            'getGroupId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->addAll(false);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.addAll', 'POST', [
            'roomId' => 'groupId123',
            'activeUsersOnly' => false
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testAddAllSuccess()
    {
        $stub = test::double(Group::class, [
            'getGroupId' => 'groupId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => (object) ['channel' => 'group-data'],
            'updateOutOfResponse' => 'result'
        ]);

        $channel = new Group();
        $result = $channel->addAll(true);

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['groups.addAll', 'POST', [
            'roomId' => 'groupId123',
            'activeUsersOnly' => true
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', 'group-data');
    }

    public function testAddLeaderFailed()
    {
        $stub = test::double(Group::class, [
            'getGroupId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $group = new Group();
        $user = new User();
        $result = $group->addLeader($user);

        $this->assertSame(false, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['groups.addLeader', 'POST', [
            'roomId' => 'groupId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testAddLeaderSuccess()
    {
        $stub = test::double(Group::class, [
            'getGroupId' => 'groupId123',
            'send' => true,
            'getSuccess' => true
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $group = new Group();
        $user = new User();
        $result = $group->addLeader($user);

        $this->assertSame($group, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['groups.addLeader', 'POST', [
            'roomId' => 'groupId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testRemoveLeaderFailed()
    {
        $stub = test::double(Group::class, [
            'getGroupId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $group = new Group();
        $user = new User();
        $result = $group->removeLeader($user);

        $this->assertSame(false, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['groups.removeLeader', 'POST', [
            'roomId' => 'groupId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testRemoveLeaderSuccess()
    {
        $stub = test::double(Group::class, [
            'getGroupId' => 'groupId123',
            'send' => true,
            'getSuccess' => true
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $group = new Group();
        $user = new User();
        $result = $group->removeLeader($user);

        $this->assertSame($group, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['groups.removeLeader', 'POST', [
            'roomId' => 'groupId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testAddModeratorFailed()
    {
        $stub = test::double(Group::class, [
            'getGroupId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $group = new Group();
        $user = new User();
        $result = $group->addModerator($user);

        $this->assertSame(false, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['groups.addModerator', 'POST', [
            'roomId' => 'groupId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testAddModeratorSuccess()
    {
        $stub = test::double(Group::class, [
            'getGroupId' => 'groupId123',
            'send' => true,
            'getSuccess' => true
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $group = new Group();
        $user = new User();
        $result = $group->addModerator($user);

        $this->assertSame($group, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['groups.addModerator', 'POST', [
            'roomId' => 'groupId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testRemoveModeratorFailed()
    {
        $stub = test::double(Group::class, [
            'getGroupId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $group = new Group();
        $user = new User();
        $result = $group->removeModerator($user);

        $this->assertSame(false, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['groups.removeModerator', 'POST', [
            'roomId' => 'groupId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testRemoveModeratorSuccess()
    {
        $stub = test::double(Group::class, [
            'getGroupId' => 'groupId123',
            'send' => true,
            'getSuccess' => true
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $group = new Group();
        $user = new User();
        $result = $group->removeModerator($user);

        $this->assertSame($group, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['groups.removeModerator', 'POST', [
            'roomId' => 'groupId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
