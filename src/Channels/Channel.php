<?php namespace ATDev\RocketChat\Channels;

use \ATDev\RocketChat\Common\Request;
use ATDev\RocketChat\Messages\Message;
use \ATDev\RocketChat\Users\User;

/**
 * Channel class
 */
class Channel extends Request {

	use \ATDev\RocketChat\Common\Room;
	use \ATDev\RocketChat\Channels\Data;

	/**
	 * Gets channel listing
	 *
	 * @return \ATDev\RocketChat\Channels\Collection|boolean
	 */
	public static function listing() {

		static::send("channels.list", "GET");

		if (!static::getSuccess()) {

			return false;
		}

		$channels = new Collection();
		foreach(static::getResponse()->channels as $channel) {

			$channels->add(static::createOutOfResponse($channel));
		}

		return $channels;
	}

	/**
	 * Creates channel at api instance
	 *
	 * @return \ATDev\RocketChat\Channels\Channel|boolean
	 */
	public function create() {

		static::send("channels.create", "POST", $this);

		if (!static::getSuccess()) {

			return false;
		}

		return $this->updateOutOfResponse(static::getResponse()->channel);
	}

	/**
	 * Deletes channel
	 *
	 * @return \ATDev\RocketChat\Channels\Channel|boolean
	 */
	public function delete() {

		static::send("channels.delete", "POST", ["roomId" => $this->getChannelId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this->setChannelId(null);
	}

	/**
	 * Gets channel info
	 *
	 * @return \ATDev\RocketChat\Channels\Channel|boolean
	 */
	public function info() {

		static::send("channels.info", "GET", ["roomId" => $this->getChannelId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this->updateOutOfResponse(static::getResponse()->channel);
	}

	/**
	 * Adds channel back to user list of channels
	 *
	 * @return \ATDev\RocketChat\Channels\Channel|boolean
	 */
	public function open() {

		static::send("channels.open", "POST", ["roomId" => $this->getChannelId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this;
	}

	/**
	 * Removes channel from user list of channels
	 *
	 * @return \ATDev\RocketChat\Channels\Channel|boolean
	 */
	public function close() {

		static::send("channels.close", "POST", ["roomId" => $this->getChannelId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this;
	}

	/**
	 * Invite user to channel
	 *
	 * @param \ATDev\RocketChat\Users\User $user
	 *
	 * @return \ATDev\RocketChat\Channels\Channel|boolean
	 */
	public function invite(User $user) {

		static::send("channels.invite", "POST", ["roomId" => $this->getChannelId(), "userId" => $user->getUserId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this;
	}

	/**
	 * Kicks user out of the channel
	 *
	 * @param \ATDev\RocketChat\Users\User $user
	 *
	 * @return \ATDev\RocketChat\Channels\Channel|boolean
	 */
	public function kick(User $user) {

		static::send("channels.kick", "POST", ["roomId" => $this->getChannelId(), "userId" => $user->getUserId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this;
	}

	/**
	 * Adds owner of the channel
	 *
	 * @param \ATDev\RocketChat\Users\User $user
	 *
	 * @return \ATDev\RocketChat\Channels\Channel|boolean
	 */
	public function addOwner(User $user) {

		static::send("channels.addOwner", "POST", ["roomId" => $this->getChannelId(), "userId" => $user->getUserId()]);

		if (!static::getSuccess()) {

			return false;
		}

		return $this;
	}

	/**
	 * Removes owner of the channel
	 *
	 * @param \ATDev\RocketChat\Users\User $user
	 *
	 * @return \ATDev\RocketChat\Channels\Channel|boolean
	 */
	public function removeOwner(User $user) {

		static::send("channels.removeOwner", "POST", ["roomId" => $this->getChannelId(), "userId" => $user->getUserId()]);

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
	        'channels.messages',
            'GET',
            ['roomId' => $this->getChannelId(), 'offset' => $offset, 'count' => $count]
        );
        if (!static::getSuccess()) {
            return false;
        }
        $response = static::getResponse();
        $messages = new \ATDev\RocketChat\Messages\Collection();
        foreach($response->messages as $message) {
            $messages->add(Message::createOutOfResponse($message));
        }

        return $messages;
    }
}