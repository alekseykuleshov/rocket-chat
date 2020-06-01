<?php namespace ATDev\RocketChat\Groups;

use \ATDev\RocketChat\Common\Request;
use \ATDev\RocketChat\Messages\Message;
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
     * @param int $offset
     * @param int $count
     * @return Collection|bool
     */
	public static function listing($offset = 0, $count = 0) {
		static::send("groups.list", "GET", ['offset' => $offset, 'count' => $count]);

		if (!static::getSuccess()) {
			return false;
		}

		$groups = new Collection();
        $response =static::getResponse();
		foreach($response->groups as $group) {
			$groups->add(static::createOutOfResponse($group));
		}
        if (isset($response->total)) {
            $groups->setTotal($response->total);
        }
        if (isset($response->count)) {
            $groups->setCount($response->count);
        }
        if (isset($response->offset)) {
            $groups->setOffset($response->offset);
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

    /**
     * Lists all of the specific channel messages on the server
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Messages\Collection|bool
     */
    public function messages($offset = 0, $count = 0) {
        static::send(
            'groups.messages',
            'GET',
            ['roomId' => $this->getRoomId(), 'offset' => $offset, 'count' => $count]
        );
        if (!static::getSuccess()) {
            return false;
        }
        $response = static::getResponse();
        $messages = new \ATDev\RocketChat\Messages\Collection();
        if (isset($response->messages)) {
            foreach ($response->messages as $message) {
                $messages->add(Message::createOutOfResponse($message));
            }
        }
        if (isset($response->total)) {
            $messages->setTotal($response->total);
        }
        if (isset($response->count)) {
            $messages->setCount($response->count);
        }
        if (isset($response->offset)) {
            $messages->setOffset($response->offset);
        }

        return $messages;
    }
}