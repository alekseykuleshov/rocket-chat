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

		return $this->setRoomId($channelId);
	}

	/**
	 * Gets channel id
	 *
	 * @return string
	 */
	public function getChannelId() {

		return $this->getRoomId();
	}

	/**
	 * Sets room id
	 *
	 * @param string $roomId
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	abstract public function setRoomId($roomId);

	/**
	 * Gets room id
	 *
	 * @return string
	 */
	abstract public function getRoomId();
}