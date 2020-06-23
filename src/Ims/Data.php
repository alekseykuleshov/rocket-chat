<?php

namespace ATDev\RocketChat\Ims;

/**
 * Im data trait
 */
trait Data
{

    /** @var string Room id */
    private $roomId;

    private $updatedAt;

    private $t;

    private $msgs;

    private $ts;

    private $lm;

    private $topic;

    private $usernames;

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
     * @param array $value
     * @return $this
     */
    private function setUsernames($value)
    {
        if (is_array($value)) {
            $this->usernames = $value;
        }

        return $this;
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

        return $this;
    }
}
