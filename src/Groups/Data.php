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
}