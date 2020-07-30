<?php

namespace ATDev\RocketChat\Invites;

/**
 * Invite data trait
 */
trait Data
{
    /** @var string Invite id */
    private $inviteId;

    /* Required properties for creation */
    /** @var integer The number of days that the invite will be valid for */
    private $days;
    /** @var integer The number of times that the invite can be used */
    private $maxUses;

    /* Readonly properties returned from api */
    /** @var string Room id */
    private $roomId;
    /** @var string User id */
    private $userId;
    /** @var string Date-time */
    private $createdAt;
    /** @var string Date-time */
    private $expires;
    /** @var integer */
    private $uses;
    /** @var string Date-time */
    private $updatedAt;
    /** @var boolean */
    private $valid;

    /**
     * Class constructor
     * @param string $inviteId
     */
    public function __construct($inviteId = null)
    {
        if (!empty($inviteId)) {
            $this->setInviteId($inviteId);
        }
    }

    /**
     * @return string
     */
    public function getInviteId()
    {
        return $this->inviteId;
    }

    /**
     * @param string $inviteId
     * @return $this
     */
    public function setInviteId($inviteId)
    {
        if (!(is_null($inviteId) || is_string($inviteId))) {
            $this->setDataError("Invalid invite Id");
        } else {
            $this->inviteId = $inviteId;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param int $days
     * @return $this
     */
    public function setDays($days)
    {
        if (!is_int($days)) {
            $this->setDataError("Invalid days value");
        } else {
            $this->days = $days;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxUses()
    {
        return $this->maxUses;
    }

    /**
     * @param int $maxUses
     * @return $this
     */
    public function setMaxUses($maxUses)
    {
        if (!is_int($maxUses)) {
            $this->setDataError("Invalid maxUses value");
        } else {
            $this->maxUses = $maxUses;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * @param string $roomId
     * @return $this
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
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     * @return $this
     */
    private function setUserId($userId)
    {
        if (is_string($userId)) {
            $this->userId = $userId;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return $this
     */
    private function setCreatedAt($createdAt)
    {
        if (is_string($createdAt)) {
            $this->createdAt = $createdAt;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param string $expires
     * @return $this
     */
    private function setExpires($expires)
    {
        if (is_string($expires)) {
            $this->expires = $expires;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getUses()
    {
        return $this->uses;
    }

    /**
     * @param int $uses
     * @return $this
     */
    private function setUses($uses)
    {
        if (is_int($uses)) {
            $this->uses = $uses;
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
     * @param string $updatedAt
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
     * @return bool
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * @param bool $valid
     * @return $this
     */
    private function setValid($valid)
    {
        if (is_bool($valid)) {
            $this->valid = $valid;
        }

        return $this;
    }

    /**
     * @param \stdClass $response
     * @return Data
     */
    public static function createOutOfResponse($response)
    {
        $invite = new static($response->_id);

        return $invite->updateOutOfResponse($response);
    }

    /**
     * @param \stdClass $response
     * @return $this
     */
    public function updateOutOfResponse($response)
    {
        if (isset($response->_id)) {
            $this->setInviteId($response->_id);
        }
        if (isset($response->days)) {
            $this->setDays($response->days);
        }
        if (isset($response->maxUses)) {
            $this->setMaxUses($response->maxUses);
        }
        if (isset($response->rid)) {
            $this->setRoomId($response->rid);
        }
        if (isset($response->userId)) {
            $this->setUserId($response->userId);
        }
        if (isset($response->createdAt)) {
            $this->setCreatedAt($response->createdAt);
        }
        if (isset($response->expires)) {
            $this->setExpires($response->expires);
        }
        if (isset($response->uses)) {
            $this->setUses($response->uses);
        }
        if (isset($response->_updatedAt)) {
            $this->setUpdatedAt($response->_updatedAt);
        }
        if (isset($response->valid)) {
            $this->setValid($response->valid);
        }

        return $this;
    }

    /**
     * @param string $error
     * @return Data $this
     */
    private function setDataError($error)
    {
        static::setError($error);

        return $this;
    }
}
