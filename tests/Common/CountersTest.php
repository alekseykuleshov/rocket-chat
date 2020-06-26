<?php

namespace ATDev\RocketChat\Tests\Common;

use PHPUnit\Framework\TestCase;
use ATDev\RocketChat\Common\Counters;

class CountersTest extends TestCase
{
    public function testUpdateOutOfResponse()
    {
        $countersFull = new CountersResponseFixtureFull();
        $mock = $this->getMockForAbstractClass(Counters::class);
        $mock->updateOutOfResponse($countersFull);

        $this->assertSame(true, $mock->getJoined());
        $this->assertSame(2, $mock->getMembers());
        $this->assertSame(0, $mock->getUnreads());
        $this->assertSame("2020-06-25T12:24:04.684Z", $mock->getUnreadsFrom());
        $this->assertSame(12, $mock->getMsgs());
        $this->assertSame("2020-06-25T12:24:04.653Z", $mock->getLatest());
        $this->assertSame(0, $mock->getUserMentions());

        $counters1 = new CountersResponseFixture1();
        $mock = $this->getMockForAbstractClass(Counters::class);
        $mock->updateOutOfResponse($counters1);

        $this->assertSame(true, $mock->getJoined());
        $this->assertNull($mock->getMsgs());
        $this->assertSame(2, $mock->getMembers());
        $this->assertNull($mock->getLatest());
        $this->assertSame(0, $mock->getUnreads());
        $this->assertNull($mock->getUserMentions());
        $this->assertSame("2020-06-25T12:24:04.684Z", $mock->getUnreadsFrom());

        $counters2 = new CountersResponseFixture2();
        $mock = $this->getMockForAbstractClass(Counters::class);
        $mock->updateOutOfResponse($counters2);

        $this->assertNull($mock->getJoined());
        $this->assertSame(12, $mock->getMsgs());
        $this->assertNull($mock->getMembers());
        $this->assertSame("2020-06-25T12:24:04.653Z", $mock->getLatest());
        $this->assertNull($mock->getUnreads());
        $this->assertSame(0, $mock->getUserMentions());
        $this->assertNull($mock->getUnreadsFrom());
    }
}