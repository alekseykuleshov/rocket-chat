<?php namespace ATDev\RocketChat;

class User extends Base {

	private $id;
	private $name;
	private $email;

	public function __construct($userId) {

		$this->id = $userId;
	}

	static public function login($name, $password, $auth = true) {

		$user = self::send("login", "POST", array("user" => $name, "password" => $password));

		if ( ! $user ) {

			return false;
		}

		if ( $auth ) {

			self::setAuthUserId($user->data->userId);
			self::setAuthToken($user->data->authToken);
		}

		return new self($user->data->userId);
	}

	static public function logout() {

		$user = self::send("logout", "GET");

		self::setAuthUserId(null);
		self::setAuthToken(null);
	}

	static public function me() {

		$user = self::send("me", "GET");

		if ( ! $user ) {

			return false;
		}

		$userData = new self($user->_id);
		$userData->name = $user->name;
		$userData->email = $user->emails[0]->address;

		return $userData;
	}

	public function getId() {

		return $this->id;
	}

	public function getName() {

		return $this->name;
	}

	public function setName($name) {

		$this->name = $name;

		return $this;
	}

	public function getEmail() {

		return $this->email;
	}

	public function setEmail($email) {

		$this->email = $email;

		return $this;
	}
}