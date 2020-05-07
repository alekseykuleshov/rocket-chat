<?php namespace ATDev\RocketChat\Users;

use \ATDev\RocketChat\Request;

class User extends Request {

	use \ATDev\RocketChat\Users\Data;

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

		$user = self::send("login", "POST", ["user" => $userName, "password" => $password]);

		if (!isset($user->status) || ($user->status != "success")) {

			if (isset($user->error)) {

				static::setError($user->error);
			} else {

				static::setError("Unknown error occured in api");
			}
		}

		if ($auth) {

			self::setAuthUserId($user->data->userId);
			self::setAuthToken($user->data->authToken);
		}

		return self::createOutOfResponse($user->data->me);
	}

	/**
	 * Gets data of currently logged in user
	 *
	 * @return \ATDev\RocketChat\Users\User|boolean
	 */
	public static function me() {

		$user = self::send("me", "GET");

		if (!isset($user->success) || !$user->success) {

			if (isset($user->error)) {

				static::setError($user->error);
			} else {

				static::setError("Unknown error occured in api");
			}
		}

		return self::createOutOfResponse($user);
	}

	/**
	 * Logs out currently logged in user
	 */
	public static function logout() {

		$user = self::send("logout", "GET");

		self::setAuthUserId(null);
		self::setAuthToken(null);
	}

	/**
	 * Creates user at api instance
	 *
	 * @return \ATDev\RocketChat\Users\User|boolean
	 */
	public function create() {

		$userData = $this->getUserData();

		$user = self::send("users.create", "POST", $userData);

		if (!isset($user->success) || !$user->success) {

			if (isset($user->error)) {

				static::setError($user->error);
			} else {

				static::setError("Unknown error occured in api");
			}

			return false;
		}

		return $this->updateOutOfResponse($user->user);
	}

	/**
	 * Updates user at api instance
	 *
	 * @return \ATDev\RocketChat\Users\User|boolean
	 */
	public function update() {

		$userData = $this->getUserData();

		$user = self::send("users.update", "POST", ["userId" => $this->getUserId(), "data" => $userData]);

		if (!isset($user->success) || !$user->success) {

			if (isset($user->error)) {

				static::setError($user->error);
			} else {

				static::setError("Unknown error occured in api");
			}

			return false;
		}

		return $this->updateOutOfResponse($user->user);
	}

	/**
	 * Gets extended info of user
	 *
	 * @return boolean|$this
	 */
	public function info() {

		$user = self::send("users.info", "GET", ["userId" => $this->getUserId()]);

		if (!isset($user->success) || !$user->success) {

			if (isset($user->error)) {

				static::setError($user->error);
			} else {

				static::setError("Unknown error occured in api");
			}

			return false;
		}

		return $this->updateOutOfResponse($user->user);
	}
}