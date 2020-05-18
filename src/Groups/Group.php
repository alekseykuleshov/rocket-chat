<?php namespace ATDev\RocketChat\Groups;

use \ATDev\RocketChat\Common\Request;
use \ATDev\RocketChat\Users\User;

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


	/**
	 * Deletes group
	 *
	 * @return \ATDev\RocketChat\Groups\Group|boolean
	 */
	public function delete() {

		static::send("groups.delete", "POST", ["roomId" => $this->getGroupId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this->setGroupId(null);
	}

	/**
	 * Gets group info
	 *
	 * @return \ATDev\RocketChat\Groups\Group|boolean
	 */
	public function info() {

		static::send("groups.info", "GET", ["roomId" => $this->getGroupId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this->updateOutOfResponse(static::getResponse()->group);
	}

	/**
	 * Adds group back to user list of groups
	 *
	 * @return \ATDev\RocketChat\Groups\Group|boolean
	 */
	public function open() {

		static::send("groups.open", "POST", ["roomId" => $this->getGroupId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this;
	}

	/**
	 * Removes group from user list of groups
	 *
	 * @return \ATDev\RocketChat\Groups\Group|boolean
	 */
	public function close() {

		static::send("groups.close", "POST", ["roomId" => $this->getGroupId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this;
	}

	/**
	 * Invite user to group
	 *
	 * @param \ATDev\RocketChat\Users\User $user
	 *
	 * @return \ATDev\RocketChat\Groups\Group|boolean
	 */
	public function invite(User $user) {

		static::send("groups.invite", "POST", ["roomId" => $this->getGroupId(), "userId" => $user->getUserId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this;
	}

	/**
	 * Kicks user out of the group
	 *
	 * @param \ATDev\RocketChat\Users\User $user
	 *
	 * @return \ATDev\RocketChat\Groups\Group|boolean
	 */
	public function kick(User $user) {

		static::send("groups.kick", "POST", ["roomId" => $this->getGroupId(), "userId" => $user->getUserId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this;
	}

	/**
	 * Adds owner of the group
	 *
	 * @param \ATDev\RocketChat\Users\User $user
	 *
	 * @return \ATDev\RocketChat\Groups\Group|boolean
	 */
	public function addOwner(User $user) {

		static::send("groups.addOwner", "POST", ["roomId" => $this->getGroupId(), "userId" => $user->getUserId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this;
	}

	/**
	 * Removes owner of the group
	 *
	 * @param \ATDev\RocketChat\Users\User $user
	 *
	 * @return \ATDev\RocketChat\Groups\Group|boolean
	 */
	public function removeOwner(User $user) {

		static::send("groups.removeOwner", "POST", ["roomId" => $this->getGroupId(), "userId" => $user->getUserId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this;
	}
}