<?php

namespace ATDev\RocketChat\Tests\Messages;

use ATDev\RocketChat\Messages\Data;
use ATDev\RocketChat\Users\Collection as UsersCollection;
use ATDev\RocketChat\Channels\Collection as ChannelsCollection;
use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

class DataTest extends TestCase
{
    public function testConstructorNoMessageId()
    {
        $mock = $this->getMockForTrait(Data::class);
        $stub = test::double(get_class($mock), ['setMessageId' => $mock]);
        $stub->construct();
        $stub->verifyNeverInvoked('setMessageId');
    }

    public function testConstructorWithMessageId()
    {
        $mock = $this->getMockForTrait(Data::class);
        $stub = test::double(get_class($mock), ['setMessageId' => $mock]);
        $stub->construct('message_id');
        $stub->verifyInvokedOnce('setMessageId', ['message_id']);
    }

    public function testInvalidMessageId()
    {
        $mock = $this->getMockForTrait(Data::class);
        $stub = test::double($mock, ['setDataError' => $mock]);

        $mock->setMessageId(123);
        $this->assertNull($mock->getMessageId());
        $stub->verifyInvokedOnce('setDataError', ['Invalid message Id']);
    }

    public function testValidMessageId()
    {
        $mock = $this->getMockForTrait(Data::class);
        $stub = test::double($mock, ['setDataError' => $mock]);

        $mock->setMessageId('message_id');
        $this->assertSame('message_id', $mock->getMessageId());

        $mock->setMessageId(null);
        $this->assertNull($mock->getMessageId());

        $stub->verifyNeverInvoked('setDataError');
    }

    public function testInvalidRoomId()
    {
        $mock = $this->getMockForTrait(Data::class);
        $stub = test::double($mock, ['setDataError' => $mock]);

        $mock->setRoomId(123);
        $this->assertNull($mock->getRoomId());
        $stub->verifyInvokedOnce('setDataError', ['Invalid room Id']);
    }

    public function testValidRoomId()
    {
        $mock = $this->getMockForTrait(Data::class);
        $stub = test::double($mock, ['setDataError' => $mock]);

        $mock->setRoomId('room_id');
        $this->assertSame('room_id', $mock->getRoomId());

        $mock->setRoomId(null);
        $this->assertNull($mock->getRoomId());

        $stub->verifyNeverInvoked('setDataError');
    }

    public function testSetText()
    {
        $mock = $this->getMockForTrait(Data::class);
        $mock->setText(['invalid_text_argument']);
        $this->assertNull($mock->getMsg());

        $mock->setText('valid_text');
        $this->assertSame('valid_text', $mock->getMsg());
    }

    public function testSetAlias()
    {
        $mock = $this->getMockForTrait(Data::class);
        $mock->setAlias(00000);
        $this->assertNull($mock->getAlias());

        $mock->setAlias('valid_alias');
        $this->assertSame('valid_alias', $mock->getAlias());
    }

    public function testSetEmoji()
    {
        $mock = $this->getMockForTrait(Data::class);
        $mock->setEmoji(00000);
        $this->assertNull($mock->getEmoji());

        $mock->setEmoji('valid_emoji');
        $this->assertSame('valid_emoji', $mock->getEmoji());
    }

    public function testSetAvatar()
    {
        $mock = $this->getMockForTrait(Data::class);
        $mock->setAvatar(00000);
        $this->assertNull($mock->getAvatar());

        $mock->setAvatar('valid_avatar_url');
        $this->assertSame('valid_avatar_url', $mock->getAvatar());
    }

    public function testJsonSerialize()
    {
        $mock = $this->getMockForTrait(Data::class);
        $mock->setRoomId('roomId');
        $this->assertSame(['roomId' => 'roomId'], $mock->jsonSerialize());

        $mock = $this->getMockForTrait(Data::class);
        $mock->setText('test text');
        $this->assertSame(['roomId' => null, 'text' => 'test text'], $mock->jsonSerialize());

        $mock = $this->getMockForTrait(Data::class);
        $mock->setAvatar('avatar');
        $this->assertSame(['roomId' => null, 'avatar' => 'avatar'], $mock->jsonSerialize());

        $mock = $this->getMockForTrait(Data::class);
        $mock->setAlias('alias');
        $this->assertSame(['roomId' => null, 'alias' => 'alias'], $mock->jsonSerialize());

        $mock = $this->getMockForTrait(Data::class);
        $mock->setEmoji('emoji');
        $this->assertSame(['roomId' => null, 'emoji' => 'emoji'], $mock->jsonSerialize());
    }

    public function testUpdateOutOfResponse1()
    {
        $messageFull = new ResponseFixture1();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($messageFull);

        $this->assertSame('7aDSXtjMA3KPLxLjt', $mock->getMessageId());
        $this->assertSame('GENERAL', $mock->getRoomId());
        $this->assertSame('test alias', $mock->getAlias());
        $this->assertSame('This is a test!', $mock->getMsg());
        $this->assertSame('http://res.guggy.com/logo_128.png', $mock->getAvatar());
        $this->assertSame(':sunglasses:', $mock->getEmoji());
        $this->assertInstanceOf(UsersCollection::class, $mock->getMentions());
        $this->assertSame('graywolf336', $mock->getMentions()->first()->getUsername());

        $this->assertNull($mock->isGroupable());
        $this->assertNull($mock->isParseUrls());
        $this->assertNull($mock->getUserId());
        $this->assertNull($mock->getUserName());
        $this->assertNull($mock->getTs());
        $this->assertNull($mock->getT());
        $this->assertNull($mock->getUpdatedAt());
        $this->assertNull($mock->getChannels());
    }

    public function testUpdateOutOfResponse2()
    {
        $messageFull = new ResponseFixture2();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($messageFull);

        $this->assertNull($mock->getMessageId());
        $this->assertNull($mock->getRoomId());
        $this->assertNull($mock->getAlias());
        $this->assertNull($mock->getMsg());
        $this->assertNull($mock->getAvatar());
        $this->assertNull($mock->getEmoji());
        $this->assertNull($mock->getMentions());

        $this->assertSame(false, $mock->isGroupable());
        $this->assertSame(true, $mock->isParseUrls());
        $this->assertSame('y65tAmHs93aDChMWu', $mock->getUserId());
        $this->assertSame('graywolf336', $mock->getUserName());
        $this->assertSame('2020-05-12T15:24:04.977Z', $mock->getTs());
        $this->assertSame('room_changed_privacy', $mock->getT());
        $this->assertSame('2018-10-05T13:48:49.535Z', $mock->getUpdatedAt());
        $this->assertInstanceOf(ChannelsCollection::class, $mock->getChannels());
        $this->assertSame('channel123', $mock->getChannels()->first()->getName());
    }

    public function testUpdateOutOfResponseFull()
    {
        $messageFull = new ResponseFixtureFull();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($messageFull);

        $this->assertSame('7aDSXtjMA3KPLxLjt', $mock->getMessageId());
        $this->assertSame('GENERAL', $mock->getRoomId());
        $this->assertSame('test alias', $mock->getAlias());
        $this->assertSame('This is a test!', $mock->getMsg());
        $this->assertSame('http://res.guggy.com/logo_128.png', $mock->getAvatar());
        $this->assertSame(':sunglasses:', $mock->getEmoji());
        $this->assertInstanceOf(UsersCollection::class, $mock->getMentions());
        $this->assertSame('graywolf336', $mock->getMentions()->first()->getUsername());

        $this->assertSame(false, $mock->isGroupable());
        $this->assertSame(true, $mock->isParseUrls());
        $this->assertSame('y65tAmHs93aDChMWu', $mock->getUserId());
        $this->assertSame('graywolf336', $mock->getUserName());
        $this->assertSame('2020-05-12T15:24:04.977Z', $mock->getTs());
        $this->assertSame('room_changed_privacy', $mock->getT());
        $this->assertSame('2018-10-05T13:48:49.535Z', $mock->getUpdatedAt());
        $this->assertInstanceOf(ChannelsCollection::class, $mock->getChannels());
        $this->assertSame('channel123', $mock->getChannels()->first()->getName());
    }

    public function testCreateOutOfResponse()
    {
        $mock = $this->getMockForTrait(Data::class);
        $stub = test::double(get_class($mock), ['updateOutOfResponse' => $mock]);

        $messageFull = new ResponseFixtureFull();
        $mock->createOutOfResponse($messageFull);

        $stub->verifyInvokedOnce('updateOutOfResponse', [$messageFull]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
