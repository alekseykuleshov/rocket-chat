<?php namespace ATDev\RocketChat\Channels;

/**
 * Channel data trait
 */
trait Data {

	/** @var string Channel id */
	private $channelId;

	/* Required properties for creation */
	/** @var string Channel name */
	private $name;

	/* Optional properties for creation */
	/** @var boolean Indicates if channel is read-only */
	private $readOnly;

	/* Readonly properties returned from api */
	/** @var string Room type */
	private $t;
	/** @var integer Messages total */
	private $msgs;
	/** @var integer Users total */
	private $usersCount;
	/** @var string Channel timestamp */
	private $ts;
	/** @var boolean Indicates is channel is default */
	private $default;
	/** @var boolean Contains channel sysMes */
	private $sysMes;

	/**
	 * Creates channel out of api response
	 *
	 * @param \stdClass $response
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	public static function createOutOfResponse($response) {

		$channel = new static($response->_id);

		return $channel->updateOutOfResponse($response);
	}

	/**
	 * Class constructor
	 *
	 * @param string $channelId
	 */
	public function __construct($channelId = null) {

		if (!empty($channelId)) {

			$this->setChannelId($channelId);
		}
	}

	/**
	 * Sets channel id
	 *
	 * @param string $channelId
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	public function setChannelId($channelId) {

		if (!(is_null($channelId) || is_string($channelId))) {

			$this->setDataError("Invalid channel Id");
		} else {

			$this->channelId = $channelId;
		}

		return $this;
	}

	/**
	 * Gets channel id
	 *
	 * @return string
	 */
	public function getChannelId() {

		return $this->channelId;
	}

	/**
	 * Sets channel name
	 *
	 * @param string $name
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	public function setName($name) {

		if (!(is_null($name) || is_string($name))) {

			$this->setDataError("Invalid name");
		} else {

			$this->name = $name;
		}

		return $this;
	}

	/**
	 * Gets channel name
	 *
	 * @return string
	 */
	public function getName() {

		return $this->name;
	}

	/**
	 * Sets if channel is read-only
	 *
	 * @param boolean $name
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	public function setReadOnly($readOnly) {

		if (!(is_bool($readOnly) || is_string($readOnly))) {

			$this->setDataError("Invalid read only value");
		} else {

			$this->readOnly = $readOnly;
		}

		return $this;
	}

	/**
	 * Gets if channel is read-only
	 *
	 * @return string
	 */
	public function getReadOnly() {

		return $this->readOnly;
	}

	/**
	 * Gets room type
	 *
	 * @return string
	 */
	public function getT() {

		return $this->t;
	}

	/**
	 * Gets messages count
	 *
	 * @return string
	 */
	public function getMsgs() {

		return $this->msgs;
	}

	/**
	 * Gets users count
	 *
	 * @return string
	 */
	public function getUsersCount() {

		return $this->usersCount;
	}

	/**
	 * Gets channel timestamp
	 *
	 * @return string
	 */
	public function getTs() {

		return $this->ts;
	}

	/**
	 * Gets if channel is default
	 *
	 * @return string
	 */
	public function getDefault() {

		return $this->default;
	}

	/**
	 * Gets channel sysMes
	 *
	 * @return string
	 */
	public function getSysMes() {

		return $this->sysMes;
	}

	/**
	 * Updates current channel out of api response
	 *
	 * @param \stdClass $response
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	public function updateOutOfResponse($response) {

		if (isset($response->_id)) {

			$this->setChannelId($response->_id);
		}

		if (isset($response->name)) {

			$this->setName($response->name);
		}

		if (isset($response->t)) {

			$this->setT($response->t);
		}

		if (isset($response->msgs)) {

			$this->setMsgs($response->msgs);
		}

		if (isset($response->usersCount)) {

			$this->setUsersCount($response->usersCount);
		}

		if (isset($response->ts)) {

			$this->setTs($response->ts);
		}

		if (isset($response->ro)) {

			$this->setReadOnly($response->ro);
		}

		if (isset($response->default)) {

			$this->setDefault($response->default);
		}

		if (isset($response->sysMes)) {

			$this->setSysMes($response->sysMes);
		}

		return $this;
	}

	/**
	 * Gets full channel data to submit to api
	 *
	 * @return array
	 */
	public function jsonSerialize() {

		$channelData = [
			"name" => $this->name
		];

		if (!is_null($this->readOnly)) {

			$channelData["readOnly"] = $this->readOnly;
		}

		return $channelData;
	}

	/**
	 * Sets room type
	 *
	 * @param string $value
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	private function setT($value) {

		if (is_string($value)) {

			$this->t = $value;
		}

		return $this;
	}

	/**
	 * Sets messages count
	 *
	 * @param int $value
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	private function setMsgs($value) {

		if (is_int($value)) {

			$this->msgs = $value;
		}

		return $this;
	}

	/**
	 * Sets user count
	 *
	 * @param int $usersCount
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	private function setUsersCount($usersCount) {

		if (is_int($usersCount)) {

			$this->usersCount = $usersCount;
		}

		return $this;
	}

	/**
	 * Sets channel timestamp
	 *
	 * @param int $ts
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	private function setTs($value) {

		if (is_string($value)) {

			$this->ts = $value;
		}

		return $this;
	}

	/**
	 * Sets if channel is default
	 *
	 * @param bool $default
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	private function setDefault($default) {

		if (is_bool($default)) {

			$this->default = $default;
		}

		return $default;
	}

	/**
	 * Sets channel sysMes
	 *
	 * @param bool $sysMes
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	private function setSysMes($sysMes) {

		if (is_bool($sysMes)) {

			$this->sysMes = $sysMes;
		}

		return $default;
	}

	/**
	 * Sets data error
	 *
	 * @param string $error
	 *
	 * @return \ATDev\RocketChat\Channels\Data
	 */
	private function setDataError($error) {

		static::setError($error);

		return $this;
	}
}