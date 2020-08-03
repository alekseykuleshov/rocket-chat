<?php

namespace ATDev\RocketChat\Tests\Channels;

use ATDev\RocketChat\Channels\Counters;
use ATDev\RocketChat\Messages\Message;
use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Channels\Channel;
use ATDev\RocketChat\Users\User;

class ChannelTest extends TestCase
{
    public function testListingFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "createOutOfResponse" => "nothing"
        ]);

        $result = Channel::listing();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["channels.list", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("createOutOfResponse");
    }

    public function testListingSuccess()
    {
        $channel1 = new \ATDev\RocketChat\Tests\Common\ResponseFixture1();
        $channel2 = new \ATDev\RocketChat\Tests\Common\ResponseFixture2();
        $response = (object) [
            "channels" => [$channel1, $channel2],
            "offset" => 2,
            "count" => 10,
            "total" => 30
        ];

        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "createOutOfResponse" => function ($arg) { return get_class($arg); }
        ]);

        $coll = test::double("\ATDev\RocketChat\Channels\Collection", [
            "add" => true
        ]);

        $result = Channel::listing();

        $this->assertInstanceOf("\ATDev\RocketChat\Channels\Collection", $result);
        $stub->verifyInvokedOnce("send", ["channels.list", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("createOutOfResponse", [$channel1]);
        $stub->verifyInvokedOnce("createOutOfResponse", [$channel2]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture1"]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture2"]);
        $this->assertSame(2, $result->getOffset());
        $this->assertSame(10, $result->getCount());
        $this->assertSame(30, $result->getTotal());
    }

    public function testCreateFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $channel = new Channel();
        $result = $channel->create();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["channels.create", "POST", $channel]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testCreateSuccess()
    {
        $response = (object) ["channel" => "channel content"];

        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $channel = new Channel();
        $result = $channel->create();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["channels.create", "POST", $channel]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["channel content"]);
    }

    public function testDeleteFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => false,
            "setChannelId" => "nothing"
        ]);

        $channel = new Channel();
        $result = $channel->delete();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["channels.delete", "POST", ["roomId" => "channelId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("setChannelId");
    }

    public function testDeleteSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => true,
            "setChannelId" => "result"
        ]);

        $channel = new Channel();
        $result = $channel->delete();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["channels.delete", "POST", ["roomId" => "channelId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("setChannelId", [null]);
    }

    public function testInfoFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $channel = new Channel();
        $result = $channel->info();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["channels.info", "GET", ["roomId" => "channelId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testInfoSuccess()
    {
        $response = (object) ["channel" => "channel content"];

        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $channel = new Channel();
        $result = $channel->info();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["channels.info", "GET", ["roomId" => "channelId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["channel content"]);
    }

    public function testOpenFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $channel = new Channel();
        $result = $channel->open();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["channels.open", "POST", ["roomId" => "channelId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testOpenSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $channel = new Channel();
        $result = $channel->open();

        $this->assertSame($channel, $result);
        $stub->verifyInvokedOnce("send", ["channels.open", "POST", ["roomId" => "channelId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testInviteFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $channel = new Channel();
        $user = new User();
        $result = $channel->invite($user);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["channels.invite", "POST", ["roomId" => "channelId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testInviteSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $channel = new Channel();
        $user = new User();
        $result = $channel->invite($user);

        $this->assertSame($channel, $result);
        $stub->verifyInvokedOnce("send", ["channels.invite", "POST", ["roomId" => "channelId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testKickFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $channel = new Channel();
        $user = new User();
        $result = $channel->kick($user);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["channels.kick", "POST", ["roomId" => "channelId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testKickSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $channel = new Channel();
        $user = new User();
        $result = $channel->kick($user);

        $this->assertSame($channel, $result);
        $stub->verifyInvokedOnce("send", ["channels.kick", "POST", ["roomId" => "channelId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testAddOwnerFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $channel = new Channel();
        $user = new User();
        $result = $channel->addOwner($user);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["channels.addOwner", "POST", ["roomId" => "channelId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testAddOwnerSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $channel = new Channel();
        $user = new User();
        $result = $channel->addOwner($user);

        $this->assertSame($channel, $result);
        $stub->verifyInvokedOnce("send", ["channels.addOwner", "POST", ["roomId" => "channelId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testRemoveOwnerFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $channel = new Channel();
        $user = new User();
        $result = $channel->removeOwner($user);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["channels.removeOwner", "POST", ["roomId" => "channelId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testRemoveOwnerSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $user = test::double("\ATDev\RocketChat\Users\User", [
            "getUserId" => "userId123"
        ]);

        $channel = new Channel();
        $user = new User();
        $result = $channel->removeOwner($user);

        $this->assertSame($channel, $result);
        $stub->verifyInvokedOnce("send", ["channels.removeOwner", "POST", ["roomId" => "channelId123", "userId" => "userId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testMessagesFailed()
    {
        $stub = test::double('\ATDev\RocketChat\Channels\Channel', [
            'getRoomId' => 'channelId123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $messageStub = test::double('\ATDev\RocketChat\Messages\Message', ['createOutOfResponse' => 'nothing']);

        $channel = new Channel();
        $result = $channel->messages();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce(
            'send',
            ['channels.messages', 'GET', ['roomId' => 'channelId123', 'offset' => 0, 'count' => 0]]
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
        $stub = test::double('\ATDev\RocketChat\Channels\Channel', [
            'getRoomId' => 'channelId123',
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

        $channel = new Channel();
        $result = $channel->messages(2, 10);

        $this->assertInstanceOf('\ATDev\RocketChat\Messages\Collection', $result);
        $stub->verifyInvokedOnce(
            'send',
            ['channels.messages', 'GET', ['roomId' => 'channelId123', 'offset' => 2, 'count' => 10]]
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
        $stub = test::double(Channel::class, [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $channel = new Channel();
        $result = $channel->addAll(false);

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["channels.addAll", "POST", [
            "roomId" => "channelId123",
            "activeUsersOnly" => false
        ]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testAddAllSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Channels\Channel", [
            "getChannelId" => "channelId123",
            "send" => true,
            "getSuccess" => true,
            "getResponse" => (object) ["channel" => "channel-data"],
            "updateOutOfResponse" => "result"
        ]);

        $channel = new Channel();
        $result = $channel->addAll(true);

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["channels.addAll", "POST", [
            "roomId" => "channelId123",
            "activeUsersOnly" => true
        ]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", "channel-data");
    }

    public function testAddLeaderFailed()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => false
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $channel = new Channel();
        $user = new User();
        $result = $channel->addLeader($user);

        $this->assertSame(false, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['channels.addLeader', 'POST', [
            'roomId' => 'channelId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testAddLeaderSuccess()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => true
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $channel = new Channel();
        $user = new User();
        $result = $channel->addLeader($user);

        $this->assertSame($channel, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['channels.addLeader', 'POST', [
            'roomId' => 'channelId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testRemoveLeaderFailed()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => false
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $channel = new Channel();
        $user = new User();
        $result = $channel->removeLeader($user);

        $this->assertSame(false, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce("send", ['channels.removeLeader', 'POST', [
            'roomId' => 'channelId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testRemoveLeaderSuccess()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => true
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $channel = new Channel();
        $user = new User();
        $result = $channel->removeLeader($user);

        $this->assertSame($channel, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['channels.removeLeader', 'POST', [
            'roomId' => 'channelId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testAddModeratorFailed()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => false
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $channel = new Channel();
        $user = new User();
        $result = $channel->addModerator($user);

        $this->assertSame(false, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['channels.addModerator', 'POST', [
            'roomId' => 'channelId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testAddModeratorSuccess()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => true
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $channel = new Channel();
        $user = new User();
        $result = $channel->addModerator($user);

        $this->assertSame($channel, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['channels.addModerator', 'POST', [
            'roomId' => 'channelId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testRemoveModeratorFailed()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => false
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $channel = new Channel();
        $user = new User();
        $result = $channel->removeModerator($user);

        $this->assertSame(false, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['channels.removeModerator', 'POST', [
            'roomId' => 'channelId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testRemoveModeratorSuccess()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => true
        ]);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $channel = new Channel();
        $user = new User();
        $result = $channel->removeModerator($user);

        $this->assertSame($channel, $result);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('send', ['channels.removeModerator', 'POST', [
            'roomId' => 'channelId123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
    }

    public function testAnonymousReadFailed()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $messageStub = test::double(Message::class, ['createOutOfResponse' => 'nothing']);

        $channel = new Channel();
        $result = $channel->anonymousRead();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce(
            'send',
            ['channels.anonymousread', 'GET', ['roomId' => 'channelId123', 'offset' => 0, 'count' => 0]]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyInvokedMultipleTimes('getChannelId', 2);
        $stub->verifyNeverInvoked('getName');
        $messageStub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testAnonymousReadSuccess()
    {
        $message1 = new \ATDev\RocketChat\Tests\Messages\ResponseFixture1();
        $message2 = new \ATDev\RocketChat\Tests\Messages\ResponseFixture2();
        $response = (object) [
            'messages' => [$message1, $message2],
            'offset' => 2,
            'count' => 10,
            'total' => 30
        ];
        $stub = test::double(Channel::class, [
            'getChannelId' => null,
            'getName' => 'channel-name',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response
        ]);
        $messageStub = test::double(
            Message::class,
            ['createOutOfResponse' => function ($arg) {
                return $arg;
            }]
        );
        $collection = test::double('\ATDev\RocketChat\Messages\Collection', ['add' => true]);

        $channel = new Channel();
        $result = $channel->anonymousRead(2, 10);

        $this->assertInstanceOf('\ATDev\RocketChat\Messages\Collection', $result);
        $stub->verifyInvokedOnce(
            'send',
            ['channels.anonymousread', 'GET', ['roomName' => 'channel-name', 'offset' => 2, 'count' => 10]]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('getChannelId');
        $stub->verifyInvokedMultipleTimes('getName', 2);
        $messageStub->verifyInvokedOnce('createOutOfResponse', [$message1]);
        $messageStub->verifyInvokedOnce('createOutOfResponse', [$message2]);
        $collection->verifyInvokedOnce('add', [$message1]);
        $collection->verifyInvokedOnce('add', [$message2]);
        $this->assertSame(2, $result->getOffset());
        $this->assertSame(10, $result->getCount());
        $this->assertSame(30, $result->getTotal());
    }

    public function testArchiveFailed()
    {
        $stub = test::double(Channel::class, [
            "getRoomId" => "channelId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $channel = new Channel();
        $result = $channel->archive();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["channels.archive", "POST", ["roomId" => "channelId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testArchiveSuccess()
    {
        $stub = test::double(Channel::class, [
            "getRoomId" => "channelId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $channel = new Channel();
        $result = $channel->archive();

        $this->assertSame($channel, $result);
        $stub->verifyInvokedOnce("send", ["channels.archive", "POST", ["roomId" => "channelId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testUnarchiveFailed()
    {
        $stub = test::double(Channel::class, [
            "getRoomId" => "channelId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $channel = new Channel();
        $result = $channel->unarchive();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["channels.unarchive", "POST", ["roomId" => "channelId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testUnarchiveSuccess()
    {
        $stub = test::double(Channel::class, [
            "getRoomId" => "channelId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $channel = new Channel();
        $result = $channel->unarchive();

        $this->assertSame($channel, $result);
        $stub->verifyInvokedOnce("send", ["channels.unarchive", "POST", ["roomId" => "channelId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testCountersFailed()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);

        $counters = test::double(Counters::class, ['updateOutOfResponse' => 'result']);

        $channel = new Channel();
        $result = $channel->counters();

        $this->assertSame(false, $result);
        $stub->verifyInvokedMultipleTimes('getChannelId', 2);
        $stub->verifyNeverInvoked('getName');
        $stub->verifyInvokedOnce('send', ['channels.counters', 'GET', ['roomId' => 'channelId123']]);
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
        $stub = test::double(Channel::class, [
            'getChannelId' => null,
            'getName' => 'channel123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response
        ]);

        $countersStub = test::double(Counters::class, ['updateOutOfResponse' => 'result']);
        $userStub = test::double(User::class, ['getUserId' => 'userId123']);

        $channel = new Channel();
        $result = $channel->counters(new User());

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['channels.counters', 'GET', [
            'roomName' => 'channel123',
            'userId' => 'userId123'
        ]]);
        $stub->verifyInvokedOnce('getChannelId');
        $stub->verifyInvokedMultipleTimes('getName', 2);
        $userStub->verifyInvokedOnce('getUserId');
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $countersStub->verifyInvokedOnce('updateOutOfResponse', $response);
    }

    public function testJoinFailed()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $channel = new Channel();
        $result = $channel->join('join_code');

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['channels.join', 'POST', [
            'roomId' => 'channelId123', 'joinCode' => 'join_code'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testJoinSuccess()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => (object) ['channel' => 'channel data'],
            'updateOutOfResponse' => 'result'
        ]);

        $channel = new Channel();
        $result = $channel->join('join_code');

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['channels.join', 'POST', [
            'roomId' => 'channelId123', 'joinCode' => 'join_code'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', ['channel data']);
    }

    public function testLeaveFailed()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $channel = new Channel();
        $result = $channel->leave();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['channels.leave', 'POST', ['roomId' => 'channelId123']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testLeaveSuccess()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => (object) ['channel' => 'channel data'],
            'updateOutOfResponse' => 'result'
        ]);

        $channel = new Channel();
        $result = $channel->leave();

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['channels.leave', 'POST', ['roomId' => 'channelId123']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', ['channel data']);
    }

    public function testMembersFailed()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $userStub = test::double(User::class, ['createOutOfResponse' => 'nothing']);

        $channel = new Channel();
        $result = $channel->members();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce(
            'send',
            ['channels.members', 'GET', ['roomId' => 'channelId123', 'offset' => 0, 'count' => 0]]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyInvokedMultipleTimes('getChannelId', 2);
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
        $stub = test::double(Channel::class, [
            'getChannelId' => null,
            'getName' => 'channel-name',
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

        $channel = new Channel();
        $result = $channel->members(2, 10);

        $this->assertInstanceOf('\ATDev\RocketChat\Users\Collection', $result);
        $stub->verifyInvokedOnce(
            'send',
            ['channels.members', 'GET', ['roomName' => 'channel-name', 'offset' => 2, 'count' => 10]]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('getChannelId');
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
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $userStub = test::double(User::class, ['createOutOfResponse' => 'nothing']);

        $channel = new Channel();
        $result = $channel->moderators();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['channels.moderators', 'GET', ['roomId' => 'channelId123']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyInvokedMultipleTimes('getChannelId', 2);
        $stub->verifyNeverInvoked('getName');
        $userStub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testModeratorsSuccess()
    {
        $user1 = new \ATDev\RocketChat\Tests\Users\ResponseFixture1();
        $user2 = new \ATDev\RocketChat\Tests\Users\ResponseFixture2();
        $response = (object) ['moderators' => [$user1, $user2]];
        $stub = test::double(Channel::class, [
            'getChannelId' => null,
            'getName' => 'channel-name',
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

        $channel = new Channel();
        $result = $channel->moderators();

        $this->assertInstanceOf('\ATDev\RocketChat\Users\Collection', $result);
        $stub->verifyInvokedOnce('send', ['channels.moderators', 'GET', ['roomName' => 'channel-name']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('getChannelId');
        $stub->verifyInvokedMultipleTimes('getName', 2);
        $userStub->verifyInvokedOnce('createOutOfResponse', [$user1]);
        $userStub->verifyInvokedOnce('createOutOfResponse', [$user2]);
        $collection->verifyInvokedOnce('add', [$user1]);
        $collection->verifyInvokedOnce('add', [$user2]);
    }

    public function testOnlineFailed()
    {
        $stub = test::double(Channel::class, [
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $userStub = test::double(User::class, ['createOutOfResponse' => 'nothing']);

        $result = Channel::online();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['channels.online', 'GET']);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $userStub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testOnlineSuccess()
    {
        $user1 = (object) ['_id' => 'userId1', 'username' => 'username1'];
        $user2 = (object) ['_id' => 'userId2', 'username' => 'username2'];
        $response = (object) ['online' => [$user1, $user2]];
        $stub = test::double(Channel::class, [
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

        $result = Channel::online(['queryParam' => 'queryVal']);

        $this->assertInstanceOf('\ATDev\RocketChat\Users\Collection', $result);
        $stub->verifyInvokedOnce('send', ['channels.online', 'GET', [
            'query' => json_encode(['queryParam' => 'queryVal'])
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $userStub->verifyInvokedOnce('createOutOfResponse', [$user1]);
        $userStub->verifyInvokedOnce('createOutOfResponse', [$user2]);
        $collection->verifyInvokedOnce('add', [$user1]);
        $collection->verifyInvokedOnce('add', [$user2]);
    }

    public function testRenameFailed()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => false
        ]);

        $channel = new Channel();
        $result = $channel->rename('new-name');

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['channels.rename', 'POST', [
            'roomId' => 'channelId123',
            'name' => 'new-name'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testRenameSuccess()
    {
        $stub = test::double(Channel::class, [
            'getChannelId' => 'channelId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => (object) ['channel' => 'channel data'],
            'updateOutOfResponse' => 'result'
        ]);

        $channel = new Channel();
        $result = $channel->rename('new-name');

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['channels.rename', 'POST', [
            'roomId' => 'channelId123',
            'name' => 'new-name'
        ]]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', ['channel data']);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
