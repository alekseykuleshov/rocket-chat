<?php

namespace ATDev\RocketChat\Tests\Groups;

use ATDev\RocketChat\Channels\Channel;
use ATDev\RocketChat\Groups\Counters;
use ATDev\RocketChat\Groups\Group;
use ATDev\RocketChat\Groups\Collection as GroupsCollection;
use ATDev\RocketChat\Users\User;
use ATDev\RocketChat\Messages\Message;
use ATDev\RocketChat\Messages\Collection as MessagesCollection;
use ATDev\RocketChat\Tests\Messages\ResponseFixture1 as MessageFixture1;
use ATDev\RocketChat\Tests\Messages\ResponseFixture2 as MessageFixture2;
use ATDev\RocketChat\RoomRoles\RoomRole;
use ATDev\RocketChat\Tests\RoomRoles\ResponseFixture1 as RoomRolesFixture1;
use ATDev\RocketChat\Tests\RoomRoles\ResponseFixture2 as RoomRolesFixture2;
use ATDev\RocketChat\RoomRoles\Collection as RoomRolesCollection;
use ATDev\RocketChat\Files\File;
use ATDev\RocketChat\Tests\Files\ResponseFixture1 as FilesFixture1;
use ATDev\RocketChat\Tests\Files\ResponseFixture2 as FilesFixture2;
use ATDev\RocketChat\Files\Collection as FilesCollection;
use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

class GroupTest extends TestCase
{
    public function testListingFailed()
    {
        $stub = test::double(Group::class, [
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) [],
            'createOutOfResponse' => 'nothing'
        ]);

        $result = Group::listing();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.list', 'GET']);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testListingSuccess()
    {
        $group1 = new \ATDev\RocketChat\Tests\Common\ResponseFixture1();
        $group2 = new \ATDev\RocketChat\Tests\Common\ResponseFixture2();
        $response = (object) [
            'groups' => [$group1, $group2],
            'offset' => 2,
            'count' => 10,
            'total' => 30
        ];

        $stub = test::double(Group::class, [
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response,
            'createOutOfResponse' => function ($arg) { return get_class($arg); }
        ]);

        $coll = test::double(GroupsCollection::class, ['add' => true]);

        $result = Group::listing();

        $this->assertInstanceOf(GroupsCollection::class, $result);
        $stub->verifyInvokedOnce('send', ["groups.list", "GET"]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("createOutOfResponse", [$group1]);
        $stub->verifyInvokedOnce("createOutOfResponse", [$group2]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture1"]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture2"]);
        $this->assertSame(2, $result->getOffset());
        $this->assertSame(10, $result->getCount());
        $this->assertSame(30, $result->getTotal());
    }

    public function testListAllFailed()
    {
        $stub = test::double(Group::class, [
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) [],
            'createOutOfResponse' => 'nothing'
        ]);

        $result = Group::listAll();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.listAll', 'GET', ['offset' => 0, 'count' => 0]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testListAllSuccess()
    {
        $group1 = new \ATDev\RocketChat\Tests\Common\ResponseFixture1();
        $group2 = new \ATDev\RocketChat\Tests\Common\ResponseFixture2();
        $response = (object) [
            'groups' => [$group1, $group2],
            'offset' => 2,
            'count' => 10,
            'total' => 30
        ];

        $stub = test::double(Group::class, [
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response,
            'createOutOfResponse' => function ($arg) { return get_class($arg); }
        ]);

        $coll = test::double(GroupsCollection::class, ['add' => true]);

        $result = Group::listAll(10);

        $this->assertInstanceOf(GroupsCollection::class, $result);
        $stub->verifyInvokedOnce('send', ['groups.listAll', 'GET', ['offset' => 10, 'count' => 0]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('createOutOfResponse', [$group1]);
        $stub->verifyInvokedOnce('createOutOfResponse', [$group2]);
        $coll->verifyInvokedOnce('add', ['ATDev\RocketChat\Tests\Common\ResponseFixture1']);
        $coll->verifyInvokedOnce('add', ['ATDev\RocketChat\Tests\Common\ResponseFixture2']);
        $this->assertSame(2, $result->getOffset());
        $this->assertSame(10, $result->getCount());
        $this->assertSame(30, $result->getTotal());
    }

    public function testCreateFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            'send' => true,
            'getSuccess' => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $group = new Group();
        $result = $group->create();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ["groups.create", "POST", $group]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testCreateSuccess()
    {
        $response = (object) ["group" => "group content"];

        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            'send' => true,
            'getSuccess' => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $group = new Group();
        $result = $group->create();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce('send', ["groups.create", "POST", $group]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["group content"]);
    }

    public function testDeleteFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => false,
            "setGroupId" => "nothing"
        ]);

        $group = new Group();
        $result = $group->delete();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ["groups.delete", "POST", ["roomId" => "groupId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked("setGroupId");
    }

    public function testDeleteSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => true,
            "setGroupId" => "result"
        ]);

        $group = new Group();
        $result = $group->delete();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce('send', ["groups.delete", "POST", ["roomId" => "groupId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce("setGroupId", [null]);
    }

    public function testInfoFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $group = new Group();
        $result = $group->info();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ["groups.info", "GET", ["roomId" => "groupId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testInfoSuccess()
    {
        $response = (object) ["group" => "group content"];

        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $group = new Group();
        $result = $group->info();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce('send', ["groups.info", "GET", ["roomId" => "groupId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["group content"]);
    }

    public function testOpenFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->open();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ["groups.open", "POST", ["roomId" => "groupId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testOpenSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => true
        ]);

        $group = new Group();
        $result = $group->open();

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce('send', ["groups.open", "POST", ["roomId" => "groupId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testInviteFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => false
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->invite($user);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ["groups.invite", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testInviteSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => true
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->invite($user);

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce('send', ["groups.invite", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testKickFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => false
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->kick($user);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ["groups.kick", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testKickSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => true
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->kick($user);

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce('send', ["groups.kick", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testAddOwnerFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => false
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->addOwner($user);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ["groups.addOwner", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testAddOwnerSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => true
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->addOwner($user);

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce('send', ["groups.addOwner", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testRemoveOwnerFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => false
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->removeOwner($user);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ["groups.removeOwner", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testRemoveOwnerSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Groups\Group", [
            "getGroupId" => "groupId123",
            'send' => true,
            'getSuccess' => true
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $group = new Group();
        $user = new User();
        $result = $group->removeOwner($user);

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce('send', ["groups.removeOwner", "POST", ["roomId" => "groupId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce('getSuccess');
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

        $group = new Group();
        $result = $group->messages();

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

        $group = new Group();
        $result = $group->messages(2, 10);

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

        $group = new Group();
        $result = $group->addAll(true);

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

    public function testArchiveFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->archive();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.archive', 'POST', ['roomId' => 'groupId123']]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testArchiveSuccess()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => true
        ]);

        $group = new Group();
        $result = $group->archive();

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce('send', ['groups.archive', 'POST', ['roomId' => 'groupId123']]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testUnarchiveFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->unarchive();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.unarchive', 'POST', ['roomId' => 'groupId123']]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testUnarchiveSuccess()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => true
        ]);

        $group = new Group();
        $result = $group->unarchive();

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce('send', ['groups.unarchive', 'POST', ['roomId' => 'groupId123']]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testCountersFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);

        $counters = test::double(Counters::class, ['updateOutOfResponse' => 'result']);

        $group = new Group();
        $result = $group->counters();

        $this->assertSame(false, $result);
        $stub->verifyInvokedMultipleTimes('getRoomId', 2);
        $stub->verifyNeverInvoked('getName');
        $stub->verifyInvokedOnce('send', ['groups.counters', 'GET', ['roomId' => 'groupId123']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $counters->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testCountersSuccess()
    {
        $response = (object) [
            'joined' => true,
            'members' => 2,
            'unreads' => 0,
            'unreadsFrom' => '2018-02-21T21:08:51.026Z',
            'msgs' => 304,
            'latest' => '2018-02-21T21:08:51.026Z',
            'userMentions' => 0,
            'success' => true
        ];
        $stub = test::double(Group::class, [
            'getRoomId' => null,
            'getName' => 'group123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response
        ]);

        $countersStub = test::double(Counters::class, ['updateOutOfResponse' => 'result']);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $group = new Group();
        $result = $group->counters(new User());

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['groups.counters', 'GET', [
            'roomName' => 'group123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getRoomId');
        $stub->verifyInvokedMultipleTimes('getName', 2);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $countersStub->verifyInvokedOnce('updateOutOfResponse', $response);
    }

    public function testLeaveFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->leave();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.leave', 'POST', ['roomId' => 'groupId123']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testLeaveSuccess()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => (object) ['group' => 'group data'],
            'updateOutOfResponse' => 'result'
        ]);

        $group = new Group();
        $result = $group->leave();

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['groups.leave', 'POST', ['roomId' => 'groupId123']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', ['group data']);
    }

    public function testMembersFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $userStub = test::double(User::class, ['createOutOfResponse' => 'nothing']);

        $group = new Group();
        $result = $group->members();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce(
            'send',
            ['groups.members', 'GET', ['roomId' => 'groupId123', 'offset' => 0, 'count' => 0]]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyInvokedMultipleTimes('getRoomId', 2);
        $stub->verifyNeverInvoked('getName');
        $userStub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testMembersSuccess()
    {
        $user1 = new \ATDev\RocketChat\Tests\Users\ResponseFixture1();
        $user2 = new \ATDev\RocketChat\Tests\Users\ResponseFixture2();
        $response = (object) [
            'members' => [$user1, $user2],
            'offset' => 2,
            'count' => 10,
            'total' => 30
        ];
        $stub = test::double(Group::class, [
            'getRoomId' => null,
            'getName' => 'group-name',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response
        ]);
        $userStub = test::double(
            User::class,
            ['createOutOfResponse' => function ($arg) {
                return $arg;
            }]
        );
        $collection = test::double('\ATDev\RocketChat\Users\Collection', ['add' => true]);

        $group = new Group();
        $result = $group->members(2, 10);

        $this->assertInstanceOf('\ATDev\RocketChat\Users\Collection', $result);
        $stub->verifyInvokedOnce(
            'send',
            ['groups.members', 'GET', ['roomName' => 'group-name', 'offset' => 2, 'count' => 10]]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('getRoomId');
        $stub->verifyInvokedMultipleTimes('getName', 2);
        $userStub->verifyInvokedOnce('createOutOfResponse', [$user1]);
        $userStub->verifyInvokedOnce('createOutOfResponse', [$user2]);
        $collection->verifyInvokedOnce('add', [$user1]);
        $collection->verifyInvokedOnce('add', [$user2]);
        $this->assertSame(2, $result->getOffset());
        $this->assertSame(10, $result->getCount());
        $this->assertSame(30, $result->getTotal());
    }

    public function testModeratorsFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $userStub = test::double(User::class, ['createOutOfResponse' => 'nothing']);

        $group = new Group();
        $result = $group->moderators();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.moderators', 'GET', ['roomId' => 'groupId123']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyInvokedMultipleTimes('getRoomId', 2);
        $stub->verifyNeverInvoked('getName');
        $userStub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testModeratorsSuccess()
    {
        $user1 = new \ATDev\RocketChat\Tests\Users\ResponseFixture1();
        $user2 = new \ATDev\RocketChat\Tests\Users\ResponseFixture2();
        $response = (object) ['moderators' => [$user1, $user2]];
        $stub = test::double(Group::class, [
            'getRoomId' => null,
            'getName' => 'group-name',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response
        ]);
        $userStub = test::double(
            User::class,
            ['createOutOfResponse' => function ($arg) {
                return $arg;
            }]
        );
        $collection = test::double('\ATDev\RocketChat\Users\Collection', ['add' => true]);

        $group = new Group();
        $result = $group->moderators();

        $this->assertInstanceOf('\ATDev\RocketChat\Users\Collection', $result);
        $stub->verifyInvokedOnce('send', ['groups.moderators', 'GET', ['roomName' => 'group-name']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('getRoomId');
        $stub->verifyInvokedMultipleTimes('getName', 2);
        $userStub->verifyInvokedOnce('createOutOfResponse', [$user1]);
        $userStub->verifyInvokedOnce('createOutOfResponse', [$user2]);
        $collection->verifyInvokedOnce('add', [$user1]);
        $collection->verifyInvokedOnce('add', [$user2]);
    }

    public function testRenameFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->rename('new-name');

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.rename', 'POST', [
            'roomId' => 'groupId123',
            'name' => 'new-name'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testRenameSuccess()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => (object) ['group' => 'group data'],
            'updateOutOfResponse' => 'result'
        ]);

        $group = new Group();
        $result = $group->rename('new-name');

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['groups.rename', 'POST', [
            'roomId' => 'groupId123',
            'name' => 'new-name'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', ['group data']);
    }

    public function testSetDescriptionFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->setDescription('channel description');

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.setDescription', 'POST', [
            'roomId' => 'groupId123',
            'description' => 'channel description'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testSetDescriptionSuccess()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => true
        ]);

        $group = new Group();
        $result = $group->setDescription();

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce('send', ['groups.setDescription', 'POST', [
            'roomId' => 'groupId123',
            'description' => ''
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testSetAnnouncementFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->setAnnouncement('channel announcement');

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.setAnnouncement', 'POST', [
            'roomId' => 'groupId123',
            'announcement' => 'channel announcement'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testSetAnnouncementSuccess()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => true
        ]);

        $group = new Group();
        $result = $group->setAnnouncement();

        $this->assertSame($group, $result);
        $stub->verifyInvokedOnce('send', ['groups.setAnnouncement', 'POST', [
            'roomId' => 'groupId123',
            'announcement' => ''
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testSetCustomFieldsFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $customFields = new \stdClass();
        $customFields->test = 'value';
        $group = new Group();
        $result = $group->setCustomFields($customFields);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.setCustomFields', 'POST', [
            'roomId' => 'groupId123',
            'customFields' => $customFields
        ]]);
        $stub->verifyNeverInvoked('getName');
        $stub->verifyInvokedMultipleTimes('getRoomId', 2);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testSetCustomFieldsSuccess()
    {
        $stub = test::double(Group::class, [
            'getName' => 'groupName123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => (object) ['group' => 'group data'],
            'updateOutOfResponse' => 'result'
        ]);

        $customFields = new \stdClass();
        $group = new Group();
        $result = $group->setCustomFields($customFields);

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['groups.setCustomFields', 'POST', [
            'roomName' => 'groupName123',
            'customFields' => $customFields
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('getRoomId');
        $stub->verifyInvokedMultipleTimes('getName', 2);
        $stub->verifyInvokedOnce('updateOutOfResponse', ['group data']);
    }

    public function testSetReadOnlyFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->setReadOnly();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.setReadOnly', 'POST', [
            'roomId' => 'groupId123',
            'readOnly' => true
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testSetReadOnlySuccess()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => (object) ['group' => 'group data'],
            'updateOutOfResponse' => 'result'
        ]);

        $group = new Group();
        $result = $group->setReadOnly(false);

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['groups.setReadOnly', 'POST', [
            'roomId' => 'groupId123',
            'readOnly' => false
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', ['group data']);
    }

    public function testSetTopicFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->setTopic('test topic');

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.setTopic', 'POST', [
            'roomId' => 'groupId123',
            'topic' => 'test topic'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testSetTopicSuccess()
    {
        $response = (object) ['topic' => 'topic set'];
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response,
            'updateOutOfResponse' => 'result'
        ]);

        $group = new Group();
        $result = $group->setTopic();

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['groups.setTopic', 'POST', [
            'roomId' => 'groupId123',
            'topic' => ''
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', [$response]);
    }

    public function testSetTypeFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->setType('p');

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.setType', 'POST', [
            'roomId' => 'groupId123',
            'type' => 'p'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testSetTypePrivateSuccess()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => (object) ['group' => 'group data'],
            'updateOutOfResponse' => 'result'
        ]);
        $channelStub = test::double(Channel::class, [
            'createOutOfResponse' => 'no-result'
        ]);

        $group = new Group();
        $result = $group->setType();

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['groups.setType', 'POST', [
            'roomId' => 'groupId123',
            'type' => 'p'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $channelStub->verifyNeverInvoked('createOutOfResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', ['group data']);
    }

    public function testSetTypeChatSuccess()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => (object) ['group' => 'group data'],
            'updateOutOfResponse' => 'result'
        ]);
        $channelStub = test::double(Channel::class, [
            'createOutOfResponse' => 'result'
        ]);

        $group = new Group();
        $result = $group->setType('c');

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['groups.setType', 'POST', [
            'roomId' => 'groupId123',
            'type' => 'c'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $channelStub->verifyInvokedOnce('createOutOfResponse', ['group data']);
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testRolesFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->roles();

        $this->assertSame(false, $result);
        $stub->verifyNeverInvoked('getName');
        $stub->verifyInvokedMultipleTimes('getRoomId', 2);
        $stub->verifyInvokedOnce('send', ['groups.roles', 'GET', ['roomId' => 'groupId123']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
    }

    public function testRolesSuccess()
    {
        $role1 = new RoomRolesFixture1();
        $role2 = new RoomRolesFixture2();
        $response = (object) ['roles' => [$role1, $role2]];
        $stub = test::double(Group::class, [
            'getRoomId' => null,
            'getName' => 'groupName123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response
        ]);
        $roomRoleStub = test::double(
            RoomRole::class,
            ['createOutOfResponse' => function ($arg) { return get_class($arg); }]
        );
        $roomRoleCol = test::double(RoomRolesCollection::class, ['add' => true]);

        $group = new Group();
        $result = $group->roles();

        $this->assertInstanceOf(RoomRolesCollection::class, $result);
        $stub->verifyInvokedOnce('getRoomId');
        $stub->verifyInvokedMultipleTimes('getName', 2);
        $stub->verifyInvokedOnce('send', ['groups.roles', 'GET', ['roomName' => 'groupName123']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $roomRoleStub->verifyInvokedOnce('createOutOfResponse', [$role1]);
        $roomRoleStub->verifyInvokedOnce('createOutOfResponse', [$role2]);
        $roomRoleCol->verifyInvokedOnce('add', [RoomRolesFixture1::class]);
        $roomRoleCol->verifyInvokedOnce('add', [RoomRolesFixture2::class]);
    }

    public function testHistoryFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->history(['inclusive' => true, 'latest' => 'test-latest']);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['groups.history', 'GET', [
            'offset' => 0,
            'count' => 0,
            'inclusive' => true,
            'latest' => 'test-latest',
            'roomId' => 'groupId123',
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
    }

    public function testHistorySuccess()
    {
        $message1 = new MessageFixture1();
        $message2 = new MessageFixture2();
        $response = (object) ['messages' => [$message1, $message2]];
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response
        ]);
        $messageStub = test::double(Message::class, [
            'createOutOfResponse' => function ($arg) { return get_class($arg); }
        ]);
        $mentionsColl = test::double(MessagesCollection::class, ['add' => true]);

        $group = new Group();
        $result = $group->history(['offset' => 10, 'inclusive' => true]);

        $this->assertInstanceOf(MessagesCollection::class, $result);
        $stub->verifyInvokedOnce('send', ['groups.history', 'GET', [
            'offset' => 10,
            'count' => 0,
            'inclusive' => true,
            'roomId' => 'groupId123',
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $messageStub->verifyInvokedOnce('createOutOfResponse', [$message1]);
        $messageStub->verifyInvokedOnce('createOutOfResponse', [$message2]);
        $mentionsColl->verifyInvokedOnce('add', [MessageFixture1::class]);
        $mentionsColl->verifyInvokedOnce('add', [MessageFixture2::class]);
    }

    public function testFilesFailed()
    {
        $stub = test::double(Group::class, [
            'getRoomId' => 'groupId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $group = new Group();
        $result = $group->files();

        $this->assertSame(false, $result);
        $stub->verifyInvokedMultipleTimes('getRoomId', 2);
        $stub->verifyNeverInvoked('getName');
        $stub->verifyInvokedOnce('send', ['groups.files', 'GET', [
            'roomId' => 'groupId123',
            'offset' => 0,
            'count' => 0
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
    }

    public function testFilesSuccess()
    {
        $file1 = new FilesFixture1();
        $file2 = new FilesFixture2();
        $response = (object) ['files' => [$file1, $file2]];
        $stub = test::double(Group::class, [
            'getRoomId' => null,
            'getName' => 'groupName123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response
        ]);
        $fileStub = test::double(File::class, [
            'createOutOfResponse' => function ($arg) { return get_class($arg); }
        ]);
        $filesColl = test::double(FilesCollection::class, ['add' => true]);

        $group = new Group();
        $result = $group->files(10);

        $this->assertInstanceOf(FilesCollection::class, $result);
        $stub->verifyInvokedOnce('send', ['groups.files', 'GET', [
            'roomName' => 'groupName123',
            'offset' => 10,
            'count' => 0
        ]]);
        $stub->verifyInvokedOnce('getRoomId');
        $stub->verifyInvokedMultipleTimes('getName', 2);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $fileStub->verifyInvokedOnce('createOutOfResponse', [$file1]);
        $fileStub->verifyInvokedOnce('createOutOfResponse', [$file2]);
        $filesColl->verifyInvokedOnce('add', [FilesFixture1::class]);
        $filesColl->verifyInvokedOnce('add', [FilesFixture2::class]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
