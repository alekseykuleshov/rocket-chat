<?php

namespace ATDev\RocketChat\Ims;

/**
 * Im data trait
 */
trait Data
{

    /** @var string Room id */
    private $roomId;

    /* Required properties for creation */
    /**
     * Required if usernames is not provided
     * @var string The username to open a direct message session
     */
    private $username;
    /**
     * Required if username is not provided
     * @var string|array List of usernames to open a multiple direct message session
     */
    private $usernames;

    /* Readonly properties returned from api */
    /** @var string Date-time */
    private $updatedAt;
    /** @var string Room type */
    private $t;
    /** @var integer Messages total */
    private $msgs;
    /** @var string Room timestamp */
    private $ts;
    /** @var string Last message timestamp */
    private $lm;
    /** @var string Last message */
    private $lastMessage;
    /** @var string Last message id */
    private $lastMessageId;
    /** @var string User id of last message */
    private $lastUserId;
    /** @var string Username of last message */
    private $lastUserName;
    /** @var integer Users total */
    private $usersCount;
    /** @var boolean Contains room sysMes */
    private $sysMes;
    /** @var boolean Indicates if room is read-only */
    private $readOnly;

    /* Required property for setTopic method */
    /** @var string The direct message topic to set */
    private $topic;

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
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $imData = [];
        if (!is_null($this->username)) {
            $imData['username'] = $this->username;
        }
        if (!is_null($this->usernames)) {
            $imData['usernames'] = $this->usernames;
        }

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
        if (!is_string($roomId)) {
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
    private function setTopicMessage($value)
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
        return $this->getRoomId();
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
    private function setSysMes($sysMes)
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
    private function setReadOnly($readOnly)
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
    private function setLastMessageId($lastMessageId)
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
    private function setLastUserId($lastUserId)
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
    private function setLastUserName($lastUserName)
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
            $this->setTopicMessage($response->topic);
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
