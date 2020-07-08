<?php

namespace ATDev\RocketChat\Tests\Ims;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;
use ATDev\RocketChat\Ims\Data;

class DataTest extends TestCase
{
    public function testConstructorNoRoomId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double(get_class($mock), ["setRoomId" => $mock]);

        $stub->construct();

        $stub->verifyNeverInvoked("setRoomId");
    }

    public function testConstructorWithRoomId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double(get_class($mock), ["setRoomId" => $mock]);

        $stub->construct("asd123asd");

        $stub->verifyInvokedOnce("setRoomId", ["asd123asd"]);
    }

    public function testJsonSerialize()
    {
        $mock = $this->getMockForTrait(Data::class);
        $mock->setUsername('username');
        $this->assertSame(['username' => 'username'], $mock->jsonSerialize());

        $mock = $this->getMockForTrait(Data::class);
        $mock->setUsernames('graywolf337, graywolf338');
        $this->assertSame(['usernames' => 'graywolf337, graywolf338'], $mock->jsonSerialize());
    }

    public function testCreateOutOfResponse()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double(get_class($mock), ["updateOutOfResponse" => $mock]);

        $imFull = new ResponseFixtureFull();
        $mock->createOutOfResponse($imFull);

        $stub->verifyInvokedOnce("updateOutOfResponse", [$imFull]);
    }

    public function testInvalidRoomId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setRoomId(123);
        $this->assertNull($mock->getRoomId());

        $stub->verifyInvokedOnce("setDataError", ["Invalid room Id"]);
    }

    public function testValidRoomId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setRoomId("123");
        $this->assertSame("123", $mock->getRoomId());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testGetters()
    {
        $imFull = new ResponseFixtureFull();

        $stub = $this->getMockBuilder(Data::class)
                     ->setMethods(
                         [
                             'getUpdatedAt', 'getT', 'getMsgs', 'getLm', 'getTopic', 'getTs', 'getLastMessage',
                             'getUsersCount', 'getSysMes', 'getReadOnly', 'getLastMessageId',
                             'getLastUserId', 'getLastUserName'
                         ])
                     ->getMockForTrait();

        $stub->method('getUpdatedAt')->willReturn($imFull->_updatedAt);
        $stub->method('getT')->willReturn($imFull->t);
        $stub->method('getMsgs')->willReturn($imFull->msgs);
        $stub->method('getLm')->willReturn($imFull->lm);
        $stub->method('getTopic')->willReturn($imFull->topic);
        $stub->method('getTs')->willReturn($imFull->ts);
        $stub->method('getLastMessage')->willReturn($imFull->lastMessage->msg);
        $stub->method('getUsersCount')->willReturn($imFull->usersCount);
        $stub->method('getSysMes')->willReturn($imFull->sysMes);
        $stub->method('getReadOnly')->willReturn($imFull->ro);
        $stub->method('getLastMessageId')->willReturn($imFull->lastMessage->_id);
        $stub->method('getLastUserId')->willReturn($imFull->lastMessage->u->_id);
        $stub->method('getLastUserName')->willReturn($imFull->lastMessage->u->username);

        $this->assertSame('2020-06-22T12:00:17.106Z', $stub->getUpdatedAt());
        $this->assertSame('d', $stub->getT());
        $this->assertSame(7, $stub->getMsgs());
        $this->assertSame('2020-06-23T15:22:46.020Z', $stub->getLm());
        $this->assertSame('Discuss all of the testing', $stub->getTopic());
        $this->assertSame('2020-06-22T09:21:24.884Z', $stub->getTs());
        $this->assertSame('Last message', $stub->getLastMessage());
        $this->assertSame(2, $stub->getUsersCount());
        $this->assertSame(false, $stub->getSysMes());
        $this->assertSame(false, $stub->getReadOnly());
        $this->assertSame('lastMessageId123', $stub->getLastMessageId());
        $this->assertSame('lastUserId123', $stub->getLastUserId());
        $this->assertSame('lastUserName123', $stub->getLastUserName());
    }

    public function testInvalidUsernames()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setUsernames(123);
        $this->assertNull($mock->getUsernames());

        $stub->verifyInvokedOnce("setDataError", ["Invalid usernames"]);
    }

    public function testValidUsernames()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setUsernames(["graywolf336", "graywolf337"]);
        $this->assertSame(["graywolf336", "graywolf337"], $mock->getUsernames());

        // And string value...
        $mock->setUsernames("graywolf336, graywolf337");
        $this->assertSame("graywolf336, graywolf337", $mock->getUsernames());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidUsername()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setUsername(123);
        $this->assertNull($mock->getUsername());

        $stub->verifyInvokedOnce("setDataError", ["Invalid username"]);
    }

    public function testValidUsername()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setUsername("graywolf336");
        $this->assertSame("graywolf336", $mock->getUsername());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testUpdateOutOfResponse()
    {
        $imFull = new ResponseFixtureFull();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($imFull);

        $this->assertSame("bZGWmZcbGZTmFQDuN", $mock->getRoomId());
        $this->assertSame("2020-06-22T12:00:17.106Z", $mock->getUpdatedAt());
        $this->assertSame("d", $mock->getT());
        $this->assertSame(7, $mock->getMsgs());
        $this->assertSame("2020-06-22T09:21:24.884Z", $mock->getTs());
        $this->assertSame("2020-06-23T15:22:46.020Z", $mock->getLm());
        $this->assertSame("Discuss all of the testing", $mock->getTopic());
        $this->assertSame(["graywolf336", "graywolf337"], $mock->getUsernames());
        $this->assertSame("lastMessageId123", $mock->getLastMessageId());
        $this->assertSame("Last message", $mock->getLastMessage());
        $this->assertSame("lastUserId123", $mock->getLastUserId());
        $this->assertSame("lastUserName123", $mock->getLastUserName());
        $this->assertSame(2, $mock->getUsersCount());
        $this->assertSame(false, $mock->getSysMes());
        $this->assertSame(false, $mock->getReadOnly());

        $im1 = new ResponseFixture1();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($im1);

        $this->assertSame("bZGWmZcbGZTmFQDuN", $mock->getRoomId());
        $this->assertNull($mock->getLm());
        $this->assertSame("2020-06-22T12:00:17.106Z", $mock->getUpdatedAt());
        $this->assertNull($mock->getTopic());
        $this->assertSame("d", $mock->getT());
        $this->assertNull($mock->getUsernames());
        $this->assertSame(7, $mock->getMsgs());
        $this->assertNull($mock->getLastMessage());
        $this->assertSame("2020-06-22T09:21:24.884Z", $mock->getTs());
        $this->assertNull($mock->getUsersCount());

        $im2 = new ResponseFixture2();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($im2);

        $this->assertNull($mock->getRoomId());
        $this->assertSame("2020-06-23T15:22:46.020Z", $mock->getLm());
        $this->assertNull($mock->getUpdatedAt());
        $this->assertSame("Discuss all of the testing", $mock->getTopic());
        $this->assertNull($mock->getT());
        $this->assertSame(['graywolf336', 'graywolf337'], $mock->getUsernames());
        $this->assertNull($mock->getMsgs());
        $this->assertSame("Last message", $mock->getLastMessage());
        $this->assertNull($mock->getTs());
        $this->assertSame(2, $mock->getUsersCount());
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
