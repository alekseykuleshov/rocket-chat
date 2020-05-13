<?php namespace ATDev\RocketChat\Channels;

use \ATDev\RocketChat\Common\Request;

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
}