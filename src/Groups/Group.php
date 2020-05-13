<?php namespace ATDev\RocketChat\Groups;

use \ATDev\RocketChat\Common\Request;

/**
 * Group class
 */
class Group extends Request {

	use \ATDev\RocketChat\Common\Room;
	use \ATDev\RocketChat\Groups\Data;

	/**
	 * Gets groups listing
	 *
	 * @return \ATDev\RocketChat\Groups\Collection|boolean
	 */
	public static function listing() {

		static::send("groups.list", "GET");

		if (!static::getSuccess()) {

			return false;
		}

		$groups = new Collection();
		foreach(static::getResponse()->groups as $group) {

			$groups->add(static::createOutOfResponse($group));
		}

		return $groups;
	}

	/**
	 * Creates group at api instance
	 *
	 * @return \ATDev\RocketChat\Groups\Group|boolean
	 */
	public function create() {

		static::send("groups.create", "POST", $this);

		if (!static::getSuccess()) {

			return false;
		}

		return $this->updateOutOfResponse(static::getResponse()->group);
	}
}