<?php

namespace ATDev\RocketChat\Tests\Common;

class CountersResponseFixture1 extends \stdClass
{
    public function __construct()
    {
        $this->joined = true;
        $this->members = 2;
        $this->unreads = 0;
        $this->unreadsFrom = "2020-06-25T12:24:04.684Z";
    }
}

class CountersResponseFixture2 extends \stdClass
{
    public function __construct()
    {
        $this->msgs = 12;
        $this->latest = "2020-06-25T12:24:04.653Z";
        $this->userMentions = 0;
    }
}

class CountersResponseFixtureFull extends \stdClass
{
    public function __construct()
    {
        foreach ([new CountersResponseFixture1(), new CountersResponseFixture2()] as $fixture) {
            foreach ($fixture as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }
}
