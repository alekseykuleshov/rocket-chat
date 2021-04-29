<?php

namespace ATDev\RocketChat\Tests\Ims;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Ims\Im;

class ImTest extends TestCase
{
    public function testListingFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "createOutOfResponse" => "nothing"
        ]);

        $result = Im::listing();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["im.list", "GET"]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("createOutOfResponse");
    }

    public function testListingSuccess()
    {
        $im1 = new \ATDev\RocketChat\Tests\Common\ResponseFixture1();
        $im2 = new \ATDev\RocketChat\Tests\Common\ResponseFixture2();
        $response = (object) [
            "ims" => [$im1, $im2],
            "offset" => 2,
            "count" => 10,
            "total" => 30
        ];

        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "createOutOfResponse" => function ($arg) { return get_class($arg); }
        ]);

        $coll = test::double("\ATDev\RocketChat\Ims\Collection", [
            "add" => true
        ]);

        $result = Im::listing();

        $this->assertInstanceOf("\ATDev\RocketChat\Ims\Collection", $result);
        $stub->verifyInvokedOnce("send", ["im.list", "GET", []]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("createOutOfResponse", [$im1]);
        $stub->verifyInvokedOnce("createOutOfResponse", [$im2]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture1"]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture2"]);
        $this->assertSame(2, $result->getOffset());
        $this->assertSame(10, $result->getCount());
        $this->assertSame(30, $result->getTotal());
    }

    public function testListingSuccessWithPaging()
    {
        $im1 = new \ATDev\RocketChat\Tests\Common\ResponseFixture1();
        $im2 = new \ATDev\RocketChat\Tests\Common\ResponseFixture2();
        $response = (object) [
            "ims" => [$im1, $im2],
            "offset" => 2,
            "count" => 10,
            "total" => 30
        ];

        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "createOutOfResponse" => function ($arg) { return get_class($arg); }
        ]);

        $coll = test::double("\ATDev\RocketChat\Ims\Collection", [
            "add" => true
        ]);

        $result = Im::listing(5, 10);

        $this->assertInstanceOf("\ATDev\RocketChat\Ims\Collection", $result);
        $stub->verifyInvokedOnce("send", ["im.list", "GET", ['offset' => 5, 'count' => 10]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("createOutOfResponse", [$im1]);
        $stub->verifyInvokedOnce("createOutOfResponse", [$im2]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture1"]);
        $coll->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Common\ResponseFixture2"]);
        $this->assertSame(2, $result->getOffset());
        $this->assertSame(10, $result->getCount());
        $this->assertSame(30, $result->getTotal());
    }

    public function testCreateFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $im = new Im();
        $result = $im->create();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["im.create", "POST", $im]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testCreateSuccess()
    {
        $response = (object) ["room" => "room content"];

        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $im = new Im();
        $result = $im->create();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["im.create", "POST", $im]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["room content"]);
    }

    public function testCreateManyUsersSuccess()
    {
        $response = (object) ["room" => "room content"];

        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $im = new Im();
        $result = $im->create();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["im.create", "POST", $im]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", ["room content"]);
    }

    public function testOpenFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $im = new Im();
        $result = $im->open();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["im.open", "POST", ["roomId" => "directMessageId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testOpenSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $im = new Im();
        $result = $im->open();

        $this->assertSame($im, $result);
        $stub->verifyInvokedOnce("send", ["im.open", "POST", ["roomId" => "directMessageId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testCloseFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "send" => true,
            "getSuccess" => false
        ]);

        $im = new Im();
        $result = $im->close();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["im.close", "POST", ["roomId" => "directMessageId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testCloseSuccess()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "send" => true,
            "getSuccess" => true
        ]);

        $im = new Im();
        $result = $im->close();

        $this->assertSame($im, $result);
        $stub->verifyInvokedOnce("send", ["im.close", "POST", ["roomId" => "directMessageId123"]]);
        $stub->verifyInvokedOnce("getSuccess");
    }

    public function testCountersFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "getUsername" => "graywolf337",
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) []
        ]);

        $counters = test::double("\ATDev\RocketChat\Ims\Counters", [
            "updateOutOfResponse" => "result"
        ]);

        $im = new Im();
        $result = $im->counters();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["im.counters", "GET", ["roomId" => "directMessageId123", "username" => "graywolf337"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $counters->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testCountersSuccess()
    {
        $response = (object) [
            "joined" => true,
            "members" => 2,
            "unreads" => 0,
            "unreadsFrom" => "2018-02-21T21:08:51.026Z",
            "msgs" => 0,
            "latest" => "2018-02-21T21:08:51.026Z",
            "userMentions" => 0,
            "success" => true
        ];

        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "getUsername" => "graywolf337",
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response
        ]);

        $counters = test::double("\ATDev\RocketChat\Ims\Counters", [
            "updateOutOfResponse" => "result"
        ]);

        $im = new Im();
        $result = $im->counters();

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["im.counters", "GET", ["roomId" => "directMessageId123", "username" => "graywolf337"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $counters->verifyInvokedOnce("updateOutOfResponse", $response);
    }

    public function testHistoryFailed()
    {
        $stub = test::double('\ATDev\RocketChat\Ims\Im', [
            'getDirectMessageId' => 'directMessageId123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $messageStub = test::double('\ATDev\RocketChat\Messages\Message', ['createOutOfResponse' => 'nothing']);

        $im = new Im();
        $result = $im->history();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce(
            'send',
            ['im.history', 'GET', ['offset' => 0, 'count' => 0, 'roomId' => 'directMessageId123']]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $messageStub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testHistorySuccess()
    {
        $message1 = new \ATDev\RocketChat\Tests\Messages\ResponseFixture1();
        $message2 = new \ATDev\RocketChat\Tests\Messages\ResponseFixture2();
        $response = (object) [
            "messages" => [$message1, $message2],
            "unreadNotLoaded" => 2
        ];
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            'getDirectMessageId' => 'directMessageId123',
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

        $im = new Im();
        $result = $im->history([
            'offset' => 2, 'count' => 10, 'latest' => '2019-09-30T13:42:25.304Z',
            'oldest' => '2019-05-30T13:42:25.304Z', 'inclusive' => true, 'unreads' => true
        ]);

        $this->assertInstanceOf('\ATDev\RocketChat\Messages\Collection', $result);
        $stub->verifyInvokedOnce(
            'send',
            [
                'im.history',
                'GET',
                [
                    'offset' => 2, 'count' => 10, 'latest' => '2019-09-30T13:42:25.304Z',
                    'oldest' => '2019-05-30T13:42:25.304Z', 'inclusive' => true, 'unreads' => true,
                    'roomId' => 'directMessageId123'
                ]
            ]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $messageStub->verifyInvokedOnce('createOutOfResponse', [$message1]);
        $messageStub->verifyInvokedOnce('createOutOfResponse', [$message2]);
        $collection->verifyInvokedOnce('add', [$message1]);
        $collection->verifyInvokedOnce('add', [$message2]);
        $this->assertSame(2, $result->getUnreadNotLoaded());
    }

    public function testListEveryoneFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "createOutOfResponse" => "nothing"
        ]);

        $result = Im::listEveryone();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["im.list.everyone", "GET", ['offset' => 0, 'count' => 0]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("createOutOfResponse");
    }

    public function testListEveryoneSuccess()
    {
        $im1 = new \ATDev\RocketChat\Tests\Ims\ResponseFixture1();
        $im2 = new \ATDev\RocketChat\Tests\Ims\ResponseFixture2();
        $response = (object) [
            "ims" => [$im1, $im2],
            "offset" => 2,
            "count" => 10,
            "total" => 30
        ];

        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "createOutOfResponse" => function ($arg) { return get_class($arg); }
        ]);

        $collection = test::double("\ATDev\RocketChat\Ims\Collection", ["add" => true]);

        $result = Im::listEveryone(2, 10);

        $this->assertInstanceOf("\ATDev\RocketChat\Ims\Collection", $result);
        $stub->verifyInvokedOnce("send", ["im.list.everyone", "GET", ["offset" => 2, "count" => 10]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("createOutOfResponse", [$im1]);
        $stub->verifyInvokedOnce("createOutOfResponse", [$im2]);
        $collection->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Ims\ResponseFixture1"]);
        $collection->verifyInvokedOnce("add", ["ATDev\RocketChat\Tests\Ims\ResponseFixture2"]);
        $this->assertSame(2, $result->getOffset());
        $this->assertSame(10, $result->getCount());
        $this->assertSame(30, $result->getTotal());
    }

    public function testMembersFailed()
    {
        $stub = test::double('\ATDev\RocketChat\Ims\Im', [
            'getDirectMessageId' => 'directMessageId123',
            'getUsername' => 'username123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $memberStub = test::double('\ATDev\RocketChat\Users\User', ['createOutOfResponse' => 'nothing']);

        $im = new Im();
        $result = $im->members();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce(
            'send',
            [
                'im.members',
                'GET',
                ['offset' => 0, 'count' => 0, 'roomId' => 'directMessageId123', 'username' => 'username123']
            ]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $memberStub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testMembersSuccess()
    {
        $member1 = new \ATDev\RocketChat\Tests\Users\ResponseFixture1();
        $member2 = new \ATDev\RocketChat\Tests\Users\ResponseFixture2();
        $response = (object) [
            "members" => [$member1, $member2],
            "offset" => 2,
            "count" => 10,
            "total" => 30
        ];
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            'getDirectMessageId' => 'directMessageId123',
            'getUsername' => 'username123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response
        ]);
        $memberStub = test::double(
            '\ATDev\RocketChat\Users\User',
            ['createOutOfResponse' => function ($arg) {
                return $arg;
            }]
        );
        $collection = test::double('\ATDev\RocketChat\Users\Collection', ['add' => true]);

        $im = new Im();
        $result = $im->members(2, 10);

        $this->assertInstanceOf('\ATDev\RocketChat\Users\Collection', $result);
        $stub->verifyInvokedOnce(
            'send',
            [
                'im.members',
                'GET',
                ['offset' => 2, 'count' => 10, 'roomId' => 'directMessageId123', 'username' => 'username123']
            ]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $memberStub->verifyInvokedOnce('createOutOfResponse', [$member1]);
        $memberStub->verifyInvokedOnce('createOutOfResponse', [$member2]);
        $collection->verifyInvokedOnce('add', [$member1]);
        $collection->verifyInvokedOnce('add', [$member2]);
        $this->assertSame(2, $result->getOffset());
        $this->assertSame(10, $result->getCount());
        $this->assertSame(30, $result->getTotal());
    }

    public function testMessagesOthersFailed()
    {
        $stub = test::double('\ATDev\RocketChat\Ims\Im', [
            'getDirectMessageId' => 'directMessageId123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $messageStub = test::double('\ATDev\RocketChat\Messages\Message', ['createOutOfResponse' => 'nothing']);

        $im = new Im();
        $result = $im->messagesOthers();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce(
            'send',
            [
                'im.messages.others',
                'GET',
                ['offset' => 0, 'count' => 0, 'roomId' => 'directMessageId123']
            ]
        );
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $messageStub->verifyNeverInvoked('createOutOfResponse');
    }

    public function testMessagesOthersSuccess()
    {
        $message1 = new \ATDev\RocketChat\Tests\Messages\ResponseFixture1();
        $message2 = new \ATDev\RocketChat\Tests\Messages\ResponseFixture2();
        $response = (object) [
            "messages" => [$message1, $message2],
            "offset" => 2,
            "count" => 10,
            "total" => 30
        ];
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            'getDirectMessageId' => 'directMessageId123',
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

        $im = new Im();
        $result = $im->messagesOthers(2, 10);

        $this->assertInstanceOf('\ATDev\RocketChat\Messages\Collection', $result);
        $stub->verifyInvokedOnce(
            'send',
            [
                'im.messages.others',
                'GET',
                ['offset' => 2, 'count' => 10, 'roomId' => 'directMessageId123']
            ]
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

    public function testMessagesFailed()
    {
        $stub = test::double('\ATDev\RocketChat\Ims\Im', [
            'getDirectMessageId' => 'directMessageId123',
            'getUsername' => 'graywolf337',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) []
        ]);
        $messageStub = test::double('\ATDev\RocketChat\Messages\Message', ['createOutOfResponse' => 'nothing']);

        $im = new Im();
        $result = $im->messages();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce(
            'send',
            [
                'im.messages',
                'GET',
                ['offset' => 0, 'count' => 0, 'roomId' => 'directMessageId123', 'username' => 'graywolf337']
            ]
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
            "messages" => [$message1, $message2],
            "offset" => 2,
            "count" => 10,
            "total" => 30
        ];
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            'getDirectMessageId' => 'directMessageId123',
            'getUsername' => 'graywolf337',
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

        $im = new Im();
        $result = $im->messages(2, 10);

        $this->assertInstanceOf('\ATDev\RocketChat\Messages\Collection', $result);
        $stub->verifyInvokedOnce(
            'send',
            [
                'im.messages',
                'GET',
                ['offset' => 2, 'count' => 10, 'roomId' => 'directMessageId123', 'username' => 'graywolf337']
            ]
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

    public function testSetTopicFailed()
    {
        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "send" => true,
            "getSuccess" => false,
            "getResponse" => (object) [],
            "updateOutOfResponse" => "nothing"
        ]);

        $im = new Im();
        $result = $im->setTopic("some text");

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce("send", ["im.setTopic", "POST", ["roomId" => "directMessageId123", "topic" => "some text"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyNeverInvoked("getResponse");
        $stub->verifyNeverInvoked("updateOutOfResponse");
    }

    public function testSetTopicSuccess()
    {
        $response = (object) ["topic" => "some text"];

        $stub = test::double("\ATDev\RocketChat\Ims\Im", [
            "getDirectMessageId" => "directMessageId123",
            "send" => true,
            "getSuccess" => true,
            "getResponse" => $response,
            "updateOutOfResponse" => "result"
        ]);

        $im = new Im();
        $result = $im->setTopic("some text");

        $this->assertSame("result", $result);
        $stub->verifyInvokedOnce("send", ["im.setTopic", "POST", ["roomId" => "directMessageId123", "topic" => "some text"]]);
        $stub->verifyInvokedOnce("getSuccess");
        $stub->verifyInvokedOnce("getResponse");
        $stub->verifyInvokedOnce("updateOutOfResponse", $response);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
