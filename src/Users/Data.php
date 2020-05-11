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
	/** @var string Avatar Url */
	private $avatarUrl;

	/**
	 * Creates use out of api response
	 *
	 * @param \stdClass $response
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public static function createOutOfResponse($response) {

		$user = new static($response->_id);

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

		if (!(is_null($userId) || is_string($userId))) {

			$this->setDataError("Invalid user Id");
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

		if (!(is_null($email) || is_string($email))) {

			$this->setDataError("Invalid email");
		} else {

			if (!is_null($email)) {

				$validator = new EmailValidator();
				if (!$validator->isValid($email, new RFCValidation())) {

					$this->setDataError("Invalid email value");
				} else {

					$this->email = $email;
				}
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

		if (!(is_null($name) || is_string($name))) {

			$this->setDataError("Invalid name");
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

		if (!(is_null($password) || is_string($password))) {

			$this->setDataError("Invalid password");
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

		return $this->password;
	}

	/**
	 * Sets user name
	 *
	 * @param string $username
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function setUsername($username) {

		if (!(is_null($username) || is_string($username))) {

			$this->setDataError("Invalid user name");
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

		if (!(is_null($active) || is_bool($active))) {

			$this->setDataError("Invalid active value");
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

		if (!(is_null($roles) || is_array($roles))) {

			$this->setDataError("Invalid roles value");
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

		if (!(is_null($joinDefaultChannels) || is_bool($joinDefaultChannels))) {

			$this->setDataError("Invalid join default channels value");
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

		if (!(is_null($requirePasswordChange) || is_bool($requirePasswordChange))) {

			$this->setDataError("Invalid require password change value");
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

		if (!(is_null($sendWelcomeEmail) || is_bool($sendWelcomeEmail))) {

			$this->setDataError("Invalid send welcome email value");
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

		if (!(is_null($verified) || is_bool($verified))) {

			$this->setDataError("Invalid verified value");
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

		if (!(is_null($customFields) || is_string($customFields))) {

			$this->setDataError("Invalid custom fields name");
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
	 * Gets user avatar url
	 *
	 * @return string
	 */
	public function getAvatarUrl() {

		return $this->avatarUrl;
	}

	/**
	 * Updates current user out of api response
	 *
	 * @param \stdClass $response
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	public function updateOutOfResponse($response) {

		if (isset($response->_id)) {
			$this->setUserId($response->_id);
		}

		if (isset($response->createdAt)) {
			$this->setCreatedAt($response->createdAt);
		}

		if (isset($response->emails[0]->address)) {
			$this->setEmail($response->emails[0]->address);
		}

		if (isset($response->emails[0]->verified)) {
			$this->setVerified($response->emails[0]->verified);
		}

		if (isset($response->type)) {
			$this->setType($response->type);
		}

		if (isset($response->status)) {
			$this->setStatus($response->status);
		}

		if (isset($response->active)) {
			$this->setActive($response->active);
		}

		if (isset($response->roles)) {
			$this->setRoles($response->roles);
		}

		if (isset($response->name)) {
			$this->setName($response->name);
		}

		if (isset($response->lastLogin)) {
			$this->setLastLogin($response->lastLogin);
		}

		if (isset($response->statusConnection)) {
			$this->setStatusConnection($response->statusConnection);
		}

		if (isset($response->utcOffset)) {
			$this->setUtcOffset($response->utcOffset);
		}

		if (isset($response->username)) {
			$this->setUsername($response->username);
		}

		if (isset($response->avatarUrl)) {
			$this->setAvatarUrl($response->avatarUrl);
		}

		return $this;
	}

	/**
	 * Gets full user data to submit to api
	 *
	 * @return array
	 */
	public function jsonSerialize() {

		$userData = [
			"email" => $this->email,
			"name" => $this->name,
			"username" => $this->username
		];

		if (!is_null($this->password)) {

			$userData["password"] = $this->password;
		}

		if (!is_null($this->active)) {

			$userData["active"] = $this->active;
		}

		if (!is_null($this->roles)) {

			$userData["roles"] = $this->roles;
		}

		if (!is_null($this->joinDefaultChannels)) {

			$userData["joinDefaultChannels"] = $this->joinDefaultChannels;
		}

		if (!is_null($this->requirePasswordChange)) {

			$userData["requirePasswordChange"] = $this->requirePasswordChange;
		}

		if (!is_null($this->sendWelcomeEmail)) {

			$userData["sendWelcomeEmail"] = $this->sendWelcomeEmail;
		}

		if (!is_null($this->verified)) {

			$userData["verified"] = $this->verified;
		}

		if (!is_null($this->customFields)) {

			$userData["customFields"] = $this->customFields;
		}

		return $userData;
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

			$this->createdAt = $createdAt;
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
	 * Sets user avatar url
	 *
	 * @param string $avatarUrl
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	private function setAvatarUrl($avatarUrl) {

		if (is_string($avatarUrl)) {

			$this->avatarUrl = $avatarUrl;
		}

		return $this;
	}

	/**
	 * Sets data error
	 *
	 * @param string $error
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	private function setDataError($error) {

		static::setError($error);

		return $this;
	}
}