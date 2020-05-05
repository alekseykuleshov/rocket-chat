<?php namespace ATDev\RocketChat\User;

use \ATDev\RocketChat\Base;

class User extends Base {

	use \ATDev\RocketChat\User\Data;

	/**
	 * Logs in user with provided credentials, or just get user with these credentials
	 *
	 * @param string $userName
	 * @param string $password
	 * @param boolean $auth
	 *
	 * @return \ATDev\RocketChat\User|boolean
	 */
	public static function login($userName, $password, $auth = true) {

		$user = self::send("login", "POST", ["user" => $userName, "password" => $password]);

		if (is_null($user->status) || ($user->status != "success")) {

			return false;
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
	 * @return \ATDev\RocketChat\User|boolean
	 */
	public static function me() {

		$user = self::send("me", "GET");

		if (is_null($user->success) || !$user->success) {

			return false;
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
	 * @return \ATDev\RocketChat\User|boolean
	 */
	public function create() {

		$userData = $this->getUserData();

		$user = self::send("users.create", "POST", $userData);

		if (is_null($user->success) || !$user->success) {

			return false;
		}

		return $this->updateOutOfResponse($user->user);
	}

	/**
	 * Updates user at api instance
	 *
	 * @return \ATDev\RocketChat\User|boolean
	 */
	public function update() {

		$userData = $this->getUserData();

		$user = self::send("users.update", "POST", ["userId" => $this->getUserId(), "data" => $userData]);

		if (is_null($user->success) || !$user->success) {

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

		if (is_null($user->success) || !$user->success) {

			return false;
		}

		return $this->updateOutOfResponse($user->user);
	}
}