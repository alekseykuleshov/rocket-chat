<?php namespace ATDev\RocketChat\Users;

use \ATDev\RocketChat\Request;

class User extends Request {

	use \ATDev\RocketChat\Users\Data;
	use \ATDev\RocketChat\Users\Avatar;

	/**
	 * Logs in user with provided credentials, or just get user with these credentials
	 *
	 * @param string $userName
	 * @param string $password
	 * @param boolean $auth
	 *
	 * @return \ATDev\RocketChat\Users\User|boolean
	 */
	public static function login($userName, $password, $auth = true) {

		self::send("login", "POST", ["user" => $userName, "password" => $password]);

		if (isset(static::getResponse()->status) && (static::getResponse()->status != "success")) { // Own error structure

			if (isset(static::getResponse()->error)) {

				static::setError(static::getResponse()->error);
			} else {

				static::setError("Unknown error occured while loggin in");
			}

			return false;
		}

		if ($auth) {

			self::setAuthUserId(static::getResponse()->data->userId);
			self::setAuthToken(static::getResponse()->data->authToken);
		}

		return self::createOutOfResponse(static::getResponse()->data->me);
	}

	/**
	 * Gets data of currently logged in user
	 *
	 * @return \ATDev\RocketChat\Users\User|boolean
	 */
	public static function me() {

		self::send("me", "GET");

		if (!static::getSuccess()) {

			return false;
		}

		return self::createOutOfResponse(static::getResponse());
	}

	/**
	 * Logs out currently logged in user
	 */
	public static function logout() {

		self::send("logout", "GET");

		self::setAuthUserId(null);
		self::setAuthToken(null);
	}

	/**
	 * Gets user listing
	 *
	 * @return \ATDev\RocketChat\Users\Collection|boolean
	 */
	public static function listing() {

		self::send("users.list", "GET");

		if (!static::getSuccess()) {

			return false;
		}

		$users = new Collection();
		foreach(static::getResponse()->users as $user) {

			$users->add(self::createOutOfResponse($user));
		}

		return $users;
	}

	/**
	 * Creates user at api instance
	 *
	 * @return \ATDev\RocketChat\Users\User|boolean
	 */
	public function create() {

		self::send("users.create", "POST", $this);

		if (!static::getSuccess()) {

			return false;
		}

		return $this->updateOutOfResponse(static::getResponse()->user);
	}

	/**
	 * Updates user at api instance
	 *
	 * @return \ATDev\RocketChat\Users\User|boolean
	 */
	public function update() {

		self::send("users.update", "POST", ["userId" => $this->getUserId(), "data" => $this]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this->updateOutOfResponse(static::getResponse()->user);
	}

	/**
	 * Gets extended info of user
	 *
	 * @return boolean|$this
	 */
	public function info() {

		self::send("users.info", "GET", ["userId" => $this->getUserId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this->updateOutOfResponse(static::getResponse()->user);
	}

	/**
	 * Gets extended info of user
	 *
	 * @return boolean|$this
	 */
	public function delete() {

		self::send("users.delete", "POST", ["userId" => $this->getUserId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this->setUserId(null);
	}

	/**
	 * Sets avatar for user
	 *
	 * @return boolean|$this
	 */
	public function setAvatar() {

		if (!empty($filepath = $this->getNewAvatarFilepath())) {

			$result = self::send("users.setAvatar", "POST", ["userId" => $this->getUserId()], ["image" => $filepath]);

			if (!static::getSuccess()) {

				return false;
			}
		} elseif (!empty($avatarUrl = $this->getNewAvatarUrl())) {

			$result = self::send("users.setAvatar", "POST", ["userId" => $this->getUserId(), "avatarUrl" => $avatarUrl]);

			if (!static::getSuccess()) {

				return false;
			}
		}

		// Reset this after update
		$this->setNewAvatarFilepath(null);
		$this->setNewAvatarUrl(null);
	}

	/**
	 * Gets avatar for user
	 *
	 * @return boolean|$this
	 */
	public function getAvatar() {

		$result = self::send("users.getAvatar", "GET", ["userId" => $this->getUserId()]);

		if (!static::getSuccess()) {

			return false;
		}

		$this->setAvatarUrl(static::getResponseUrl());
	}
}