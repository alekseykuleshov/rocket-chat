<?php namespace ATDev\RocketChat\Users;

use \ATDev\RocketChat\Common\Request;

/**
 * User class
 */
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

		static::send("login", "POST", ["user" => $userName, "password" => $password]);

		if (isset(static::getResponse()->status) && (static::getResponse()->status != "success")) { // Own error structure

			if (isset(static::getResponse()->error)) {

				static::setError(static::getResponse()->error);
			} else {

				static::setError("Unknown error occured while loggin in");
			}

			return false;
		}

		if ($auth) {

			static::setAuthUserId(static::getResponse()->data->userId);
			static::setAuthToken(static::getResponse()->data->authToken);
		}

		return static::createOutOfResponse(static::getResponse()->data->me);
	}

	/**
	 * Gets data of currently logged in user
	 *
	 * @return \ATDev\RocketChat\Users\User|boolean
	 */
	public static function me() {

		static::send("me", "GET");

		if (!static::getSuccess()) {

			return false;
		}

		return static::createOutOfResponse(static::getResponse());
	}

	/**
	 * Logs out currently logged in user
	 */
	public static function logout() {

		static::send("logout", "GET");

		static::setAuthUserId(null);
		static::setAuthToken(null);

		return true;
	}

	/**
	 * Gets user listing
	 *
	 * @return \ATDev\RocketChat\Users\Collection|boolean
	 */
	public static function listing() {

		static::send("users.list", "GET");

		if (!static::getSuccess()) {

			return false;
		}

		$users = new Collection();
		foreach(static::getResponse()->users as $user) {

			$users->add(static::createOutOfResponse($user));
		}

		return $users;
	}

	/**
	 * Creates user at api instance
	 *
	 * @return \ATDev\RocketChat\Users\User|boolean
	 */
	public function create() {

		static::send("users.create", "POST", $this);

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

		static::send("users.update", "POST", ["userId" => $this->getUserId(), "data" => $this]);

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

		static::send("users.info", "GET", ["userId" => $this->getUserId()]);

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

		static::send("users.delete", "POST", ["userId" => $this->getUserId()]);

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

			$result = static::send("users.setAvatar", "POST", ["userId" => $this->getUserId()], ["image" => $filepath]);

			if (!static::getSuccess()) {

				return false;
			}
		} elseif (!empty($avatarUrl = $this->getNewAvatarUrl())) {

			$result = static::send("users.setAvatar", "POST", ["userId" => $this->getUserId(), "avatarUrl" => $avatarUrl]);

			if (!static::getSuccess()) {

				return false;
			}
		}

		// Reset this after update
		return $this->setNewAvatarFilepath(null)->setNewAvatarUrl(null);
	}

	/**
	 * Gets avatar for user
	 *
	 * @return boolean|$this
	 */
	public function getAvatar() {

		$result = static::send("users.getAvatar", "GET", ["userId" => $this->getUserId()]);

		if (!static::getSuccess()) {

			return false;
		}

		if (!empty(static::getResponseUrl())) {

			$this->setAvatarUrl(static::getResponseUrl());
		}

		return $this;
	}
}