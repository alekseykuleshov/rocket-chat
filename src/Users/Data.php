<?php namespace ATDev\RocketChat\Users;

use \Egulias\EmailValidator\EmailValidator;
use \Egulias\EmailValidator\Validation\RFCValidation;

/**
 * User data trait
 */
trait Data {

	/** @var string User id */
	private $userId;

	/* Required properties for creation */
	/** @var string User email */
	private $email;
	/** @var string User display name */
	private $name;
	/** @var string User password */
	private $password;
	/** @var string Username of user */
	private $username;

	/* Optional properties for creation */
	/** @var boolean Indicates if user is active, default true */
	private $active;
	/** @var array User roles, default ['user'] */
	private $roles;
	/** @var boolean Indicates if user should join default channels on creation, default true */
	private $joinDefaultChannels;
	/** @var boolean Indicates if user should change password on first login, default false */
	private $requirePasswordChange;
	/** @var boolean Indicates if user should receive welcome email, default false */
	private $sendWelcomeEmail;
	/** @var boolean Indicates if user email is verified, default false */
	private $verified;
	/** @var string User custom fields, default is undefined */
	private $customFields;

	/* Readonly properties returned from api */
	/** @var string Date-time user created at api */
	private $createdAt;
	/** @var string User type at the api */
	private $type;
	/** @var string User status */
	private $status;
	/** @var string Date-time user last logged in */
	private $lastLogin;
	/** @var string User status connection of the api */
	private $statusConnection;
	/** @var string User utc offset */
	private $utcOffset;

	/**
	 * Creates use out of api response
	 *
	 * @param \stdClass $response
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public static function createOutOfResponse($response) {

		$user = new self($response->_id);

		return $user->updateOutOfResponse($response);
	}

	/**
	 * Class constructor
	 *
	 * @param type $userId
	 */
	public function __construct($userId = null) {

		if (!empty($userId)) {

			$this->setUserId($userId);
		}
	}

	/**
	 * Sets user id
	 *
	 * @param string $userid
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function setUserId($userId) {

		if (!is_string($userId)) {

			$this->setError("Invalid user Id");
		} else {

			$this->userId = $userId;
		}

		return $this;
	}

	/**
	 * Gets user id
	 *
	 * @return string
	 */
	public function getUserId() {

		return $this->userId;
	}

	/**
	 * Sets user email
	 *
	 * @param string $email
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function setEmail($email) {

		if (!is_string($email)) {

			$this->setError("Invalid email");
		} else {

			$validator = new EmailValidator();
			if (!$validator->isValid($email, new RFCValidation())) {

				$this->setError("Invalid email");
			} else {

				$this->email = $email;
			}
		}

		return $this;
	}

	/**
	 * Gets user email
	 *
	 * @return string
	 */
	public function getEmail() {

		return $this->email;
	}

	/**
	 * Sets user display name
	 *
	 * @param string $name
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function setName($name) {

		if (!is_string($name)) {

			$this->setError("Invalid name");
		} else {

			$this->name = $name;
		}

		return $this;
	}

	/**
	 * Gets user display name
	 *
	 * @return string
	 */
	public function getName() {

		return $this->name;
	}

	/**
	 * Sets user password
	 *
	 * @param string $password
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function setPassword($password) {

		if (!is_string($password)) {

			$this->setError("Invalid password");
		} else {

			$this->password = $password;
		}

		return $this;
	}

	/**
	 * Gets user password
	 *
	 * @return string
	 */
	public function getPassword() {

		return null; // No way to get password now
	}

	/**
	 * Sets user name
	 *
	 * @param string $username
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function setUsername($username) {

		if (!is_string($password)) {

			$this->setError("Invalid user name");
		} else {

			$this->username = $username;
		}

		return $this;
	}

	/**
	 * Gets user name
	 *
	 * @return string
	 */
	public function getUsername() {

		return $this->username;
	}

	/**
	 * Sets if user is active
	 *
	 * @param boolean $active
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function setActive($active) {

		if (!is_boolean($active)) {

			$this->setError("Invalid active value");
		} else {

			$this->active = $active;
		}

		return $this;
	}

	/**
	 * Gets if user is active
	 *
	 * @return boolean
	 */
	public function getActive() {

		return $this->active;
	}

	/**
	 * Sets user roles
	 *
	 * @param array $roles
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function setRoles($roles) {

		if (!is_array($roles)) {

			$this->setError("Invalid roles value");
		} else {

			$this->roles = $roles;
		}

		return $this;
	}

	/**
	 * Gets user roles
	 *
	 * @return array
	 */
	public function getRoles() {

		return $this->roles;
	}

	/**
	 * Sets if user should join default channels
	 *
	 * @param boolean $joinDefaultChannels
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function setJoinDefaultChannels($joinDefaultChannels) {

		if (!is_boolean($joinDefaultChannels)) {

			$this->setError("Invalid join default channels value");
		} else {

			$this->joinDefaultChannels = $joinDefaultChannels;
		}

		return $this;
	}

	/**
	 * Gets if user should join default channels
	 *
	 * @return boolean
	 */
	public function getJoinDefaultChannels() {

		return $this->joinDefaultChannels;
	}

	/**
	 * Sets if user should change the password
	 *
	 * @param boolean $requirePasswordChange
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function setRequirePasswordChange($requirePasswordChange) {

		if (!is_boolean($requirePasswordChange)) {

			$this->setError("Invalid require password change value");
		} else {

			$this->requirePasswordChange = $requirePasswordChange;
		}

		return $this;
	}

	/**
	 * Gets if user should change the password
	 *
	 * @return boolean
	 */
	public function getRequirePasswordChange() {

		return $this->requirePasswordChange;
	}

	/**
	 * Sets if user should receive welcome email
	 *
	 * @param boolean $sendWelcomeEmail
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function setSendWelcomeEmail($sendWelcomeEmail) {

		if (!is_boolean($sendWelcomeEmail)) {

			$this->setError("Invalid send welcome email value");
		} else {

			$this->sendWelcomeEmail = $sendWelcomeEmail;
		}

		return $this;
	}

	/**
	 * Gets if user should receive welcome email
	 *
	 * @return boolean
	 */
	public function getSendWelcomeEmail() {

		return $this->sendWelcomeEmail;
	}

	/**
	 * Sets if user email should be verified
	 *
	 * @param boolean $verified
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function setVerified($verified) {

		if (!is_boolean($verified)) {

			$this->setError("Invalid verified value");
		} else {

			$this->verified = $verified;
		}

		return $this;
	}

	/**
	 * Gets if user email should be verified
	 *
	 * @return boolean
	 */
	public function getVerified() {

		return $this->verified;
	}

	/**
	 * Sets user custom fields
	 *
	 * @param string $customFields
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function setCustomFields($customFields) {

		if (!is_string($customFields)) {

			$this->setError("Invalid custom fields name");
		} else {

			$this->customFields = $customFields;
		}

		return $this;
	}

	/**
	 * Gets user custom fields
	 *
	 * @return string
	 */
	public function getCustomFields() {

		return $this->customFields;
	}

	/**
	 * Gets the date-time user created at api
	 *
	 * @return string
	 */
	public function getCreatedAt() {

		return $this->createdAt;
	}

	/**
	 * Gets user type at the api
	 *
	 * @return string
	 */
	public function getType() {

		return $this->type;
	}

	/**
	 * Gets user status
	 *
	 * @return string
	 */
	public function getStatus() {

		return $this->status;
	}

	/**
	 * Gets date-time user last logged in
	 *
	 * @return string
	 */
	public function getLastLogin() {

		return $this->lastLogin;
	}

	/**
	 * Gets user status connection of the api
	 *
	 * @return string
	 */
	public function getStatusConnection() {

		return $this->statusConnection;
	}

	/**
	 * Gets user utc offset
	 *
	 * @return float
	 */
	public function getUtcOffset() {

		return $this->utcOffset;
	}

	/**
	 * Updates current user out of api response
	 *
	 * @param \stdClass $response
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function updateOutOfResponse($response) {

		if (!is_null($response->_id)) {
			$this->setUserId($response->_id);
		}

		if (!is_null($response->createdAt)) {
			$this->setCreatedAt($response->createdAt);
		}

		if (!is_null($user->user->emails[0]->address)) {
			$this->setEmail($user->user->emails[0]->address);
		}

		if (!is_null($user->user->emails[0]->verified)) {
			$this->setVerified($user->user->emails[0]->verified);
		}

		if (!is_null($response->type)) {
			$this->setType($response->type);
		}

		if (!is_null($response->status)) {
			$this->setStatus($response->status);
		}

		if (!is_null($response->active)) {
			$this->setActive($response->active);
		}

		if (!is_null($response->roles)) {
			$this->setRoles($response->roles);
		}

		if (!is_null($response->name)) {
			$this->setName($response->name);
		}

		if (!is_null($response->lastLogin)) {
			$this->setLastLogin($response->lastLogin);
		}

		if (!is_null($response->statusConnection)) {
			$this->setStatusConnection($response->statusConnection);
		}

		if (!is_null($response->utcOffset)) {
			$this->setUtcOffset($response->utcOffset);
		}

		if (!is_null($response->username)) {
			$this->setUsername($response->username);
		}

		return $this;
	}

	/**
	 * Sets the date-time user created at api
	 *
	 * @param string $createdAt
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	private function setCreatedAt($createdAt) {

		if (is_string($createdAt)) {

			$this->customFields = $customFields;
		}

		return $this;
	}

	/**
	 * Sets user type at the api
	 *
	 * @param string $type
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	private function setType($type) {

		if (is_string($type)) {

			$this->type = $type;
		}

		return $this;
	}

	/**
	 * Sets user status
	 *
	 * @param string $status
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	private function setStatus($status) {

		if (is_string($status)) {

			$this->status = $status;
		}

		return $this;
	}

	/**
	 * Sets date-time user last logged in
	 *
	 * @param string $lastLogin
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	private function setLastLogin($lastLogin) {

		if (is_string($lastLogin)) {

			$this->lastLogin = $lastLogin;
		}

		return $this;
	}

	/**
	 * Sets user status connection of the api
	 *
	 * @param string $statusConnection
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	private function setStatusConnection($statusConnection) {

		if (is_string($statusConnection)) {

			$this->statusConnection = $statusConnection;
		}

		return $this;
	}

	/**
	 * Sets user utc offset
	 *
	 * @param string $utcOffset
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	private function setUtcOffset($utcOffset) {

		if (is_float($utcOffset)) {

			$this->utcOffset = $utcOffset;
		}

		return $this;
	}

	/**
	 * Gets full user data to submit to api
	 *
	 * @return array
	 */
	private function getUserData() {

		$userData = [
			"email" => $this->email,
			"name" => $this->name,
			"username" => $this->username
		];

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