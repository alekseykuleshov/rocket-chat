<?php

namespace ATDev\RocketChat\Common;

abstract class Counters
{
    /** @var boolean flag that shows that user is joined the room or not */
    private $joined;
    /** @var integer count of current room members */
    private $members;
    /** @var integer count of unread messages for specified user (calling user or provided userId) */
    private $unreads;
    /** @var string start date-time of unread interval for specified user */
    private $unreadsFrom;
    /** @var integer count of messages in the room */
    private $msgs;
    /** @var string end date-time of unread interval for specified user (or date-time of last posted message) */
    private $latest;
    /** @var integer count of user mentions in messages */
    private $userMentions;

    /**
     * @return bool
     */
    public function getJoined()
    {
        return $this->joined;
    }

    /**
     * @param bool $joined
     * @return $this
     */
    private function setJoined($joined)
    {
        if (is_bool($joined)) {
            $this->joined = $joined;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param int $members
     * @return $this
     */
    private function setMembers($members)
    {
        if (is_int($members)) {
            $this->members = $members;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getUnreads()
    {
        return $this->unreads;
    }

    /**
     * @param int $unreads
     * @return $this
     */
    private function setUnreads($unreads)
    {
        if (is_int($unreads)) {
            $this->unreads = $unreads;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getUnreadsFrom()
    {
        return $this->unreadsFrom;
    }

    /**
     * @param string $unreadsFrom
     * @return $this
     */
    private function setUnreadsFrom($unreadsFrom)
    {
        if (is_string($unreadsFrom)) {
            $this->unreadsFrom = $unreadsFrom;
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
    public function getLatest()
    {
        return $this->latest;
    }

    /**
     * @param string $latest
     * @return $this
     */
    private function setLatest($latest)
    {
        if (is_string($latest)) {
            $this->latest = $latest;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getUserMentions()
    {
        return $this->userMentions;
    }

    /**
     * @param int $userMentions
     * @return $this
     */
    private function setUserMentions($userMentions)
    {
        if (is_int($userMentions)) {
            $this->userMentions = $userMentions;
        }
        return $this;
    }

    public function updateOutOfResponse($response)
    {
        if (isset($response->joined)) {
            $this->setJoined($response->joined);
        }

        if (isset($response->members)) {
            $this->setMembers($response->members);
        }

        if (isset($response->unreads)) {
            $this->setUnreads($response->unreads);
        }

        if (isset($response->unreadsFrom)) {
            $this->setUnreadsFrom($response->unreadsFrom);
        }

        if (isset($response->msgs)) {
            $this->setMsgs($response->msgs);
        }

        if (isset($response->latest)) {
            $this->setLatest($response->latest);
        }

        if (isset($response->userMentions)) {
            $this->setUserMentions($response->userMentions);
        }

        return $this;
    }
}
