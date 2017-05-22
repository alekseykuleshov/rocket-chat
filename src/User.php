<?php namespace ATDev\RocketChat;

class User extends Base {

	private $id;
	private $userName;
	private $email;
	private $name;
	private $password;

	private $active;
	private $roles;
	private $joinDefaultChannels;
	private $requirePasswordChange;
	private $sendWelcomeEmail;
	private $verified;
	private $customFields;

	public function __construct($userId = null) {

		$this->id = $userId;
	}

	static public function login($userName, $password, $auth = true) {

		$user = self::send("login", "POST", array("user" => $userName, "password" => $password));

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
		$userData->setName($user->name);
		$userData->setUserName($user->username);

		if ( ! empty($user->emails) ) {

			$userData->setEmail($user->emails[0]->address);
		}

		return $userData;
	}

	public function create() {

		$userData = getUserData();

		$user = self::send("users.create", "POST", $userData);

		if ( ! $user ) {

			return false;
		}

		$this->id = $user->user->_id;

		return $this;
	}

	public function update() {

		$userData = getUserData();

		$user = self::send("users.update", "POST", array("userId" => $this->getId(), "data" => $userData));

		if ( ! $user ) {

			return false;
		}

		return $this;
	}

	public function info() {

		$user = self::send("users.info", "GET", array("userId" => $this->getId()));

		if ( ! $user ) {

			return false;
		}

		$this->setName($user->user->name);
		$this->setUserName($user->user->username);

		if ( ! empty($user->user->emails) ) {

			$this->setEmail($user->user->emails[0]->address);
		}

		return $this;
	}

	public function getId() {

		return $this->id;
	}

	public function getUserName() {

		return $this->userName;
	}

	public function setUserName($userName) {

		$this->userName = $userName;

		return $this;
	}

	public function getName() {

		return $this->Name;
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

	public function getActive() {

		return $this->active;
	}

	public function setActive($active) {

		$this->active = $active;

		return $this;
	}

	public function getRoles() {

		return $this->roles;
	}

	public function setRoles($roles) {

		$this->roles = $roles;

		return $this;
	}

	public function getJoinDefaultChannels() {

		return $this->joinDefaultChannels;
	}

	public function setJoinDefaultChannels($joinDefaultChannels) {

		$this->joinDefaultChannels = $joinDefaultChannels;

		return $this;
	}

	public function getRequirePasswordChange() {

		return $this->requirePasswordChange;
	}

	public function setRequirePasswordChange($requirePasswordChange) {

		$this->requirePasswordChange = $requirePasswordChange;

		return $this;
	}

	public function getSendWelcomeEmail() {

		return $this->sendWelcomeEmail;
	}

	public function setSendWelcomeEmail($sendWelcomeEmail) {

		$this->sendWelcomeEmail = $sendWelcomeEmail;

		return $this;
	}

	public function getVerified() {

		return $this->verified;
	}

	public function setVerified($verified) {

		$this->verified = $verified;

		return $this;
	}

	public function getCustomFields() {

		return $this->customFields;
	}

	public function setCustomFields($customFields) {

		$this->customFields = $customFields;

		return $this;
	}

	public function getPassword() {

		return $this->password;
	}

	public function setPassword($password) {

		$this->password = $password;

		return $this;
	}

	private function getUserData() {

		$userData = array(
			"email" => $this->email,
			"name" => $this->name,
			"username" => $this->userName
		);

		if ( !is_null($this->password)) {

			$userData["password"] = $this->password;
		}

		if ( !is_null($this->active)) {

			$userData["active"] = $this->active;
		}

		if ( !is_null($this->roles)) {

			$userData["roles"] = $this->roles;
		}

		if ( !is_null($this->joinDefaultChannels)) {

			$userData["joinDefaultChannels"] = $this->joinDefaultChannels;
		}

		if ( !is_null($this->requirePasswordChange)) {

			$userData["requirePasswordChange"] = $this->requirePasswordChange;
		}

		if ( !is_null($this->sendWelcomeEmail)) {

			$userData["sendWelcomeEmail"] = $this->sendWelcomeEmail;
		}

		if ( !is_null($this->verified)) {

			$userData["verified"] = $this->verified;
		}

		if ( !is_null($this->customFields)) {

			$userData["customFields"] = $this->customFields;
		}

		return $userData;
	}
}