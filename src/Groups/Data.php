<?php namespace ATDev\RocketChat\Groups;

/**
 * Group data trait
 */
trait Data {

	/**
	 * Sets group id
	 *
	 * @param string $groupId
	 *
	 * @return \ATDev\RocketChat\Groups\Data
	 */
	public function setGroupId($groupId) {

		return $this->setRoomId($groupId);
	}

	/**
	 * Gets group id
	 *
	 * @return string
	 */
	public function getGroupId() {

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