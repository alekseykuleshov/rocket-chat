<?php

namespace ATDev\RocketChat\Invites;

/**
 * Invite data trait
 */
trait Data
{
    private $inviteId;

    private $days;

    private $maxUses;

    private $roomId;

    private $userId;

    private $createdAt;

    private $expires;

    private $uses;

    private $updatedAt;

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
    private function setInviteId($inviteId)
    {
        if (is_string($inviteId)) {
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
    private function setDays($days)
    {
        if (is_int($days)) {
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
    private function setMaxUses($maxUses)
    {
        if (is_int($maxUses)) {
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
    private function setRoomId($roomId)
    {
        if (is_string($roomId)) {
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

        return $this;
    }
}