<?php

namespace ATDev\RocketChat\Tests\RoomRoles;

class ResponseFixture1 extends \stdClass
{
    public function __construct()
    {
        $this->_id = 'roomRoleId123';
        $this->rid = 'roomId123';
        $this->u = (object) ['_id' => 'y65tAmHs93aDChMWu', 'username' => 'graywolf336'];
        $this->roles = ['admin', 'leader'];
    }
}

class ResponseFixture2 extends \stdClass
{
    public function __construct()
    {
        $this->_id = 'roomRoleId321';
        $this->rid = 'roomId123';
        $this->u = (object) ['_id' => 'userId123', 'username' => 'moder123'];
        $this->roles = [];
    }
}