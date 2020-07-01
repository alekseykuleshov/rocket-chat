<?php

namespace ATDev\RocketChat\Ims;

/**
 * Im data trait
 */
trait Data
{

    /** @var string Room id */
    private $roomId;
    /** @var string */
    private $updatedAt;
    /** @var string */
    private $t;
    /** @var integer  */
    private $msgs;
    /** @var string */
    private $ts;
    /** @var string */
    private $lm;
    /** @var string */
    private $topic;
    /** @var string|array */
    private $usernames;
    /** @var string */
    private $lastMessage;
    /** @var string */
    private $lastMessageId;
    /** @var string */
    private $lastUserId;
    /** @var string */
    private $lastUserName;
    /** @var integer */
    private $usersCount;
    /** @var string */
    private $username;
    /** @var string */
    private $latest;
    /** @var string */
    private $oldest;
    /** @var boolean */
    private $inclusive;
    /** @var boolean */
    private $unreads;
    /** @var boolean */
    private $sysMes;
    /** @var boolean */
    private $readOnly;

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
     * Gets full im data to submit to api
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $imData = [
            "username" => $this->username,
            "usernames" => $this->usernames
        ];

        return $imData;
    }

    /**
     * Creates im out of api response
     *
     * @param \stdClass $response
     *
     * @return \ATDev\RocketChat\Ims\Data
     */
    public static function createOutOfResponse($response)
    {
        $im = new static($response->_id);

        return $im->updateOutOfResponse($response);
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
     * Sets room id
     *
     * @param string $roomId
     *
     * @return \ATDev\RocketChat\Ims\Data
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
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param $updatedAt
     * @return $this
     */
    private function setUpdatedAt($updatedAt)
    {
        if (is_string($updatedAt)) {
            $this->updatedAt = $updatedAt;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getT()
    {
        return $this->t;
    }

    /**
     * @param string $value
     * @return $this
     */
    private function setT($value)
    {
        if (is_string($value)) {
            $this->t = $value;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getMsgs()
    {
        return $this->msgs;
    }

    /**
     * @param int $value
     * @return $this
     */
    private function setMsgs($value)
    {
        if (is_int($value)) {
            $this->msgs = $value;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getLm()
    {
        return $this->lm;
    }

    /**
     * @param string $value
     * @return $this
     */
    private function setLm($value)
    {
        if (is_string($value)) {
            $this->lm = $value;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param string $value
     * @return $this
     */
    private function setTopic($value)
    {
        if (is_string($value)) {
            $this->topic = $value;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * @param string $value
     * @return $this
     */
    private function setTs($value)
    {
        if (is_string($value)) {
            $this->ts = $value;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getUsernames()
    {
        return $this->usernames;
    }

    /**
     * @param string|array $usernames
     * @return $this
     */
    public function setUsernames($usernames)
    {
        if (!(is_string($usernames) || is_array($usernames))) {
            $this->setDataError("Invalid usernames");
        } else {
            $this->usernames = $usernames;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getLastMessage()
    {
        return $this->lastMessage;
    }

    /**
     * @param string $lastMessage
     * @return $this
     */
    private function setLastMessage($lastMessage)
    {
        if (is_string($lastMessage)) {
            $this->lastMessage = $lastMessage;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getUsersCount()
    {
        return $this->usersCount;
    }

    /**
     * @param int $usersCount
     * @return $this
     */
    private function setUsersCount($usersCount)
    {
        if (is_int($usersCount)) {
            $this->usersCount = $usersCount;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param $username
     * @return $this
     */
    public function setUsername($username)
    {
        if (!is_string($username)) {
            $this->setDataError("Invalid username");
        } else {
            $this->username = $username;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getDirectMessageId()
    {
        return $this->roomId;
    }

    /**
     * @return string
     */
    public function getLatest()
    {
        return $this->latest;
    }

    /**
     * @param string $latest
     * @return $this
     */
    public function setLatest($latest)
    {
        if (is_string($latest)) {
            $this->latest = $latest;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getOldest()
    {
        return $this->oldest;
    }

    /**
     * @param string $oldest
     * @return $this
     */
    public function setOldest($oldest)
    {
        if (is_string($oldest)) {
            $this->oldest = $oldest;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function getInclusive()
    {
        return $this->inclusive;
    }

    /**
     * @param bool $inclusive
     * @return $this
     */
    public function setInclusive($inclusive)
    {
        if (is_bool($inclusive)) {
            $this->inclusive = $inclusive;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function getUnreads()
    {
        return $this->unreads;
    }

    /**
     * @param bool $unreads
     * @return $this
     */
    public function setUnreads($unreads)
    {
        if (is_bool($unreads)) {
            $this->unreads = $unreads;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function getSysMes()
    {
        return $this->sysMes;
    }

    /**
     * @param bool $sysMes
     * @return $this
     */
    public function setSysMes($sysMes)
    {
        if (is_bool($sysMes)) {
            $this->sysMes = $sysMes;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function getReadOnly()
    {
        return $this->readOnly;
    }

    /**
     * @param bool $readOnly
     * @return $this
     */
    public function setReadOnly($readOnly)
    {
        if (is_bool($readOnly)) {
            $this->readOnly = $readOnly;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getLastMessageId()
    {
        return $this->lastMessageId;
    }

    /**
     * @param string $lastMessageId
     * @return $this
     */
    public function setLastMessageId($lastMessageId)
    {
        if (is_string($lastMessageId)) {
            $this->lastMessageId = $lastMessageId;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getLastUserId()
    {
        return $this->lastUserId;
    }

    /**
     * @param string $lastUserId
     * @return $this
     */
    public function setLastUserId($lastUserId)
    {
        if (is_string($lastUserId)) {
            $this->lastUserId = $lastUserId;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getLastUserName()
    {
        return $this->lastUserName;
    }

    /**
     * @param string $lastUserName
     * @return $this
     */
    public function setLastUserName($lastUserName)
    {
        if (is_string($lastUserName)) {
            $this->lastUserName = $lastUserName;
        }
        return $this;
    }

    /**
     * @param $directMessageId
     * @return Data
     */
    public function setDirectMessageId($directMessageId)
    {
        return $this->setRoomId($directMessageId);
    }

    /**
     * Updates current im out of api response
     *
     * @param \stdClass $response
     * @return \ATDev\RocketChat\Ims\Data
     */
    public function updateOutOfResponse($response)
    {
        if (isset($response->_id)) {
            $this->setRoomId($response->_id);
        }

        if (isset($response->_updatedAt)) {
            $this->setUpdatedAt($response->_updatedAt);
        }

        if (isset($response->t)) {
            $this->setT($response->t);
        }

        if (isset($response->msgs)) {
            $this->setMsgs($response->msgs);
        }

        if (isset($response->ts)) {
            $this->setTs($response->ts);
        }

        if (isset($response->lm)) {
            $this->setLm($response->lm);
        }

        if (isset($response->topic)) {
            $this->setTopic($response->topic);
        }

        if (isset($response->usernames)) {
            $this->setUsernames($response->usernames);
        }

        if (isset($response->lastMessage)) {
            $this->setLastMessageId($response->lastMessage->_id);
            $this->setLastMessage($response->lastMessage->msg);
            $this->setLastUserId($response->lastMessage->u->_id);
            $this->setLastUserName($response->lastMessage->u->username);
        }

        if (isset($response->usersCount)) {
            $this->setUsersCount($response->usersCount);
        }

        if (isset($response->sysMes)) {
            $this->setSysMes($response->sysMes);
        }

        if (isset($response->ro)) {
            $this->setReadOnly($response->ro);
        }

        return $this;
    }

    /**
     * Sets data error
     *
     * @param string $error
     *
     * @return \ATDev\RocketChat\Ims\Data
     */
    private function setDataError($error)
    {
        static::setError($error);

        return $this;
    }
}
