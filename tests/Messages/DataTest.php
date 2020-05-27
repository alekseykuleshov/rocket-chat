<?php namespace ATDev\RocketChat\Tests\Messages;

use ATDev\RocketChat\Messages\Data;
use \PHPUnit\Framework\TestCase;
use \AspectMock\Test as test;


class DataTest extends TestCase {
    public function testJsonSerialize() {
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

    public function testUpdateOutOfResponseFull() {
        $messageFull = new ResponseFixtureFull();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($messageFull);

        $this->assertSame('7aDSXtjMA3KPLxLjt', $mock->getMessageId());
        $this->assertSame('GENERAL', $mock->getRooomId());
        $this->assertSame('test alias', $mock->getAliasId());
        $this->assertSame('This is a test!', $mock->getMsgId());
        $this->assertSame(false, $mock->isGroupable());
        $this->assertSame(true, $mock->isParseUrls());
        $this->assertSame('y65tAmHs93aDChMWu', $mock->getUserId());
        $this->assertSame('graywolf336', $mock->getUserName());
        $this->assertSame('2020-05-12T15:24:04.977Z', $mock->getTs());
        $this->assertSame('room_changed_privacy', $mock->getT());
        $this->assertSame('2018-10-05T13:48:49.535Z', $mock->getUpdatedAt());
    }

    public function testCreateOutOfResponse() {
        $mock = $this->getMockForTrait(Data::class);
        $stub = test::double(get_class($mock), ['updateOutOfResponse' => $mock]);

        $messageFull = new ResponseFixtureFull();
        $mock->createOutOfResponse($messageFull);

        $stub->verifyInvokedOnce('updateOutOfResponse', [$messageFull]);
    }

    protected function tearDown(): void {
        test::clean(); // remove all registered test doubles
    }
}