<?php

namespace ATDev\RocketChat\Tests\Ims;

class ResponseFixture1 extends \stdClass
{
    public function __construct()
    {
        $this->_id = 'bZGWmZcbGZTmFQDuN';
        $this->_updatedAt = '2020-06-22T12:00:17.106Z';
        $this->t = 'd';
        $this->msgs = 7;
        $this->ts = '2020-06-22T09:21:24.884Z';
    }
}

class ResponseFixture2 extends \stdClass
{
    public function __construct()
    {
        $this->lm = '2020-06-23T15:22:46.020Z';
        $this->topic = 'Discuss all of the testing';
        $this->usernames = ['graywolf336', 'graywolf337'];
        $this->lastMessage = (object) ['msg' => 'Last message'];
        $this->usersCount = 2;
    }
}

class ResponseFixtureFull extends \stdClass
{
    public function __construct()
    {
        foreach ([new ResponseFixture1(), new ResponseFixture2()] as $fixture) {
            foreach ($fixture as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }
}
