<?php

namespace ATDev\RocketChat\Tests\Roles;

class ResponseFixture1 extends \stdClass
{
    public function __construct()
    {
        $this->_id = 'moderator';
        $this->description = 'description';
        $this->mandatory2fa = false;
    }
}

class ResponseFixture2 extends \stdClass
{
    public function __construct()
    {
        $this->protected = true;
        $this->name = 'moderator';
        $this->scope = 'Subscriptions';
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
