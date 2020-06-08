<?php

namespace ATDev\RocketChat\Tests\Messages;

use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;
use ATDev\RocketChat\Messages\Message;

class MessageTest extends TestCase
{
    public function testGetMessageFailed()
    {
        $stub = test::double('ATDev\RocketChat\Messages\Message', [
            'getMessageId' => 'messageId123',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) [],
            'updateOutOfResponse' => 'nothing'
        ]);

        $message = new Message();
        $result = $message->getMessage();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['chat.getMessage', 'GET', ['msgId' => 'messageId123']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testGetMessageSuccess()
    {
        $response = (object) ['message' => 'message_content'];
        $stub = test::double('ATDev\RocketChat\Messages\Message', [
            'getMessageId' => 'messageId123',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response,
            'updateOutOfResponse' => 'result'
        ]);

        $message = new Message();
        $result = $message->getMessage();

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['chat.getMessage', 'GET', ['msgId' => 'messageId123']]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', ['message_content']);
    }

    public function testPostMessageFailed()
    {
        $stub = test::double('ATDev\RocketChat\Messages\Message', [
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) [],
            'updateOutOfResponse' => 'nothing'
        ]);

        $message = new Message();
        $result = $message->postMessage();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', ['chat.postMessage', 'POST', $message]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse');
    }

    public function testPostMessageSuccess()
    {
        $response = (object) ['message' => 'message content'];
        $stub = test::double('ATDev\RocketChat\Messages\Message', [
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response,
            'updateOutOfResponse' => 'result'
        ]);

        $message = new Message();
        $result = $message->postMessage();

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', ['chat.postMessage', 'POST', $message]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', ['message content']);
    }

    public function testUpdateFailed()
    {
        $stub = test::double('ATDev\RocketChat\Messages\Message', [
            'getRoomId' => 'roomIdw',
            'getMessageId' => 'messageIda',
            'getMsg' => 'updated text',
            'send' => true,
            'getSuccess' => false,
            'getResponse' => (object) [],
            'updateOutOfResponse' => 'nothing'
        ]);

        $message = new Message();
        $result = $message->update();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', [
            'chat.update', 'POST', ['roomId' => 'roomIdw', 'msgId' => 'messageIda', 'text' => 'updated text']
        ]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('getResponse');
        $stub->verifyNeverInvoked('updateOutOfResponse', ['message updated content']);
    }

    public function testUpdateSuccess()
    {
        $response = (object) ['message' => 'message updated content'];
        $stub = test::double('ATDev\RocketChat\Messages\Message', [
            'getRoomId' => 'roomIdw',
            'getMessageId' => 'messageIda',
            'getMsg' => 'updated text',
            'send' => true,
            'getSuccess' => true,
            'getResponse' => $response,
            'updateOutOfResponse' => 'result'
        ]);

        $message = new Message();
        $result = $message->update();

        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('send', [
            'chat.update', 'POST', ['roomId' => 'roomIdw', 'msgId' => 'messageIda', 'text' => 'updated text']
        ]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('getResponse');
        $stub->verifyInvokedOnce('updateOutOfResponse', ['message updated content']);
    }

    public function testDeleteFailed()
    {
        $stub = test::double('\ATDev\RocketChat\Messages\Message', [
            'getRoomId' => 'roomId123w',
            'getMessageId' => 'messageId123a',
            'send' => true,
            'getSuccess' => false
        ]);

        $message = new Message();
        $result = $message->delete();

        $this->assertSame(false, $result);
        $stub->verifyInvokedOnce('send', [
            'chat.delete', 'POST', ['roomId' => 'roomId123w', 'msgId' => 'messageId123a', 'asUser' => false]
        ]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyNeverInvoked('setMessageId');
    }

    public function testDeleteSuccess()
    {
        $stub = test::double('\ATDev\RocketChat\Messages\Message', [
            'getRoomId' => 'roomId123w',
            'getMessageId' => 'messageId123a',
            'send' => true,
            'getSuccess' => true
        ]);

        $message = new Message();
        $result = $message->delete(true);

        $this->assertSame($message, $result);
        $stub->verifyInvokedOnce('send', [
            'chat.delete', 'POST', ['roomId' => 'roomId123w', 'msgId' => 'messageId123a', 'asUser' => true]
        ]);
        $stub->verifyInvokedOnce('getSuccess');
        $stub->verifyInvokedOnce('setMessageId', [null]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
