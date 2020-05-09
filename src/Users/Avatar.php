<?php namespace ATDev\RocketChat\Users;

/**
 * User avatar trait
 */
trait Avatar {

	/** @var string Filepath of new user avatar to be uploaded */
	private $newAvatarFilepath;
	/** @var string Url to new user avatar to be applied */
	private $newAvatarUrl;

	/**
	 * Sets filepath of new user avatar to upload
	 *
	 * @param string $name
	 *
	 * @return \ATDev\RocketChat\Users\Avatar
	 */
	public function setNewAvatarFilepath($newAvatarFilepath) {

		if (!(is_null($newAvatarFilepath) || is_string($newAvatarFilepath))) {

			$this->setAvatarError("Invalid avatar filepath value");
		} else {

			$this->newAvatarFilepath = $newAvatarFilepath;
		}

		return $this;
	}

	/**
	 * Gets filepath of new user avatar to upload
	 *
	 * @return string
	 */
	public function getNewAvatarFilepath() {

		return $this->newAvatarFilepath;
	}

	/**
	 * Sets url of new user avatar to be applied
	 *
	 * @param string $name
	 *
	 * @return \ATDev\RocketChat\Users\Avatar
	 */
	public function setNewAvatarUrl($newAvatarUrl) {

		if (!(is_null($newAvatarUrl) || is_string($newAvatarUrl))) {

			$this->setAvatarError("Invalid avatar url value");
		} else {

			$this->newAvatarUrl = $newAvatarUrl;
		}

		return $this;
	}

	/**
	 * Gets url of new user avatar to be applied
	 *
	 * @return string
	 */
	public function getNewAvatarUrl() {

		return $this->newAvatarUrl;
	}

	/**
	 * Sets data error
	 *
	 * @param string $error
	 *
	 * @return \ATDev\RocketChat\Users\Data
	 */
	private function setAvatarError($error) {

		static::setError($error);

		return $this;
	}
}