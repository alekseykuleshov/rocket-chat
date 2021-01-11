<?php

namespace ATDev\RocketChat\Tests\Messages;

class ResponseFixture1 extends \stdClass
{
    public function __construct()
    {
        $this->_id = "7aDSXtjMA3KPLxLjt";
        $this->rid = 'GENERAL';
        $this->alias = 'test alias';
        $this->emoji = ':sunglasses:';
        $this->avatar = 'http://res.guggy.com/logo_128.png';
        $this->msg = 'This is a test!';
        $this->mentions = [(object) ['_id' => 'y65tAmHs93aDChMWu', 'username' => 'graywolf336']];
    }
}

class ResponseFixture2 extends \stdClass
{
    public function __construct()
    {
        $this->ts = '2020-05-12T15:24:04.977Z';
        $this->_updatedAt = '2018-10-05T13:48:49.535Z';
        $this->u = (object) ['_id' => 'y65tAmHs93aDChMWu', 'username' => 'graywolf336'];
        $this->groupable = false;
        $this->parseUrls = true;
        $this->t = 'room_changed_privacy';
        $this->attachments = [];
        $this->channels = [(object) ['_id' => 'y65tAmHs93aDChMWu', 'name' => 'channel123']];
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
