<?php namespace ATDev\RocketChat\Channels;

/**
 * Channel data trait
 */
trait Data {

	/**
	 * Sets channel id
	 *
	 * @param string $channelId
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	public function setChannelId($channelId) {

		return $this->setRoomId($groupId);
	}

	/**
	 * Gets channel id
	 *
	 * @return string
	 */
	public function getChannelId() {

		return $this->getRoomId();
	}
}