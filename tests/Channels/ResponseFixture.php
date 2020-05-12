<?php namespace ATDev\RocketChat\Tests\Channels;

class ResponseFixture1 extends \stdClass {

	public function __construct() {

		$this->_id = "asd123asd";
		$this->t = "c";
		$this->usersCount = 3;
		$this->ts = "2020-05-12T15:24:04.977Z";
		$this->sysMes = true;
	}
}

class ResponseFixture2 extends \stdClass {

	public function __construct() {

		$this->name = "Channel Name";
		$this->msgs = 6;
		$this->ro = true;
		$this->default = false;
	}
}

class ResponseFixtureFull extends \stdClass {

	public function __construct() {

		foreach ([new ResponseFixture1(), new ResponseFixture2()] as $fixture) {

			foreach ($fixture as $key => $value) {

				$this->{$key} = $value;
			}
		}
	}
}