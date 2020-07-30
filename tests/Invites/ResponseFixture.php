<?php

namespace ATDev\RocketChat\Tests\Invites;

class ResponseFixture1 extends \stdClass
{
    public function __construct()
    {
        $this->_id = "inviteId123";
        $this->days = 5;
        $this->maxUses = 3;
        $this->rid = "roomId123";
        $this->userId = "userId123";
    }
}

class ResponseFixture2 extends \stdClass
{
    public function __construct()
    {
        $this->createdAt = "2019-12-20T03:31:56.774Z";
        $this->expires = "2019-12-21T03:31:56.774Z";
        $this->uses = 1;
        $this->_updatedAt = "2019-12-20T03:33:40.065Z";
        $this->valid = true;
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
