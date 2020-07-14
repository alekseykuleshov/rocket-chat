<?php

namespace ATDev\RocketChat\Common;

/**
 * Room data trait
 */
trait Room
{

    /** @var string Room id */
    private $roomId;

    /* Required properties for creation */
    /** @var string Room name */
    private $name;

    /* Optional properties for creation */
    /** @var boolean Indicates if room is read-only */
    private $readOnly;

    /* Readonly properties returned from api */
    /** @var string Room type */
    private $t;
    /** @var integer Messages total */
    private $msgs;
    /** @var integer Users total */
    private $usersCount;
    /** @var string Room timestamp */
    private $ts;
    /** @var boolean Indicates is room is default */
    private $default;
    /** @var boolean Contains room sysMes */
    private $sysMes;

    /**
     * Creates room out of api response
     *
     * @param \stdClass $response
     *
     * @return \ATDev\RocketChat\Common\Room
     */
    public static function createOutOfResponse($response)
    {
        $room = new static($response->_id);

        return $room->updateOutOfResponse($response);
    }

    /**
     * Class constructor
     *
     * @param string $roomId
     */
    public function __construct($roomId = null)
    {
        if (!empty($roomId)) {
            $this->setRoomId($roomId);
        }
    }

    /**
     * Sets room id
     *
     * @param string $roomId
     *
     * @return \ATDev\RocketChat\Common\Room
     */
    public function setRoomId($roomId)
    {
        if (!(is_null($roomId) || is_string($roomId))) {
            $this->setDataError("Invalid room Id");
        } else {
            $this->roomId = $roomId;
        }

        return $this;
    }

    /**
     * Gets room id
     *
     * @return string
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * Sets room name
     *
     * @param string $name
     *
     * @return \ATDev\RocketChat\Common\Room
     */
    public function setName($name)
    {
        if (!(is_null($name) || is_string($name))) {
            $this->setDataError("Invalid name");
        } else {
            $this->name = $name;
        }

        return $this;
    }

    /**
     * Gets room name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets if room is read-only
     *
     * @param boolean $name
     *
     * @return \ATDev\RocketChat\Common\Room
     */
    public function setReadOnly($readOnly)
    {
        if (!(is_bool($readOnly) || is_string($readOnly))) {
            $this->setDataError("Invalid read only value");
        } else {
            $this->readOnly = $readOnly;
        }

        return $this;
    }

    /**
     * Gets if room is read-only
     *
     * @return string
     */
    public function getReadOnly()
    {
        return $this->readOnly;
    }

    /**
     * Gets room type
     *
     * @return string
     */
    public function getT()
    {
        return $this->t;
    }

    /**
     * Gets messages count
     *
     * @return string
     */
    public function getMsgs()
    {
        return $this->msgs;
    }

    /**
     * Gets users count
     *
     * @return string
     */
    public function getUsersCount()
    {
        return $this->usersCount;
    }

    /**
     * Gets room timestamp
     *
     * @return string
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * Gets if room is default
     *
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Gets room sysMes
     *
     * @return string
     */
    public function getSysMes()
    {
        return $this->sysMes;
    }

    /**
     * Updates current room out of api response
     *
     * @param \stdClass $response
     *
     * @return \ATDev\RocketChat\Common\Room
     */
    public function updateOutOfResponse($response)
    {
        if (isset($response->_id)) {
            $this->setroomId($response->_id);
        }

        if (isset($response->rid)) {
            $this->setroomId($response->rid);
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
     * Gets full room data to submit to api
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $roomData = [
            "name" => $this->name
        ];

        if (!is_null($this->readOnly)) {
            $roomData["readOnly"] = $this->readOnly;
        }

        return $roomData;
    }

    /**
     * Sets room type
     *
     * @param string $value
     *
     * @return \ATDev\RocketChat\Common\Room
     */
    private function setT($value)
    {
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
     * @return \ATDev\RocketChat\Common\Room
     */
    private function setMsgs($value)
    {
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
     * @return \ATDev\RocketChat\Common\Room
     */
    private function setUsersCount($usersCount)
    {
        if (is_int($usersCount)) {
            $this->usersCount = $usersCount;
        }

        return $this;
    }

    /**
     * Sets room timestamp
     *
     * @param int $ts
     *
     * @return \ATDev\RocketChat\Common\Room
     */
    private function setTs($value)
    {
        if (is_string($value)) {
            $this->ts = $value;
        }

        return $this;
    }

    /**
     * Sets if room is default
     *
     * @param bool $default
     *
     * @return \ATDev\RocketChat\Common\Room
     */
    private function setDefault($default)
    {
        if (is_bool($default)) {
            $this->default = $default;
        }

        return $this;
    }

    /**
     * Sets room sysMes
     *
     * @param bool $sysMes
     *
     * @return \ATDev\RocketChat\Common\Room
     */
    private function setSysMes($sysMes)
    {
        if (is_bool($sysMes)) {
            $this->sysMes = $sysMes;
        }

        return $this;
    }

    /**
     * Sets data error
     *
     * @param string $error
     *
     * @return \ATDev\RocketChat\Common\Room
     */
    private function setDataError($error)
    {
        static::setError($error);

        return $this;
    }
}
