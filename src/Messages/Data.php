<?php namespace ATDev\RocketChat\Messages;

trait Data {

    /** @var string Message id from api */
    private $messageId;

    /* Required properties for creation */
    /** @var string The room id of where the message is to be sent */
    private $roomId;
    /** @var string */
    private $channel;
    /** @var string The text of the message to send */
    private $text;
    /** @var string This will cause the message's name to appear as the given alias */
    private $alias;
    /** @var string If provided, this will make the avatar on this message be an emoji */
    private $emoji;
    /** @var string If provided, this will make the avatar use the provided image url */
    private $avatar;

    /* Readonly properties returned from api */
    /** @var string Message text */
    private $msg;
    /** @var bool Indicates if urls from messages are parsed */
    private $parseUrls;
    /** @var bool */
    private $groupable;
    /** @var string timestamp */
    private $ts;
    /** @var string message user id */
    private $userId;
    /** @var string message user name */
    private $username;
    /** @var string Date-time */
    private $updatedAt;

    /**
     * Class constructor
     *
     * @param string $messageId
     */
    public function __construct($messageId = null) {
        if (!empty($messageId)) {
            $this->setMessageId($messageId);
        }
    }

    /**
     * @return string
     */
    public function getMessageId() {
        return $this->messageId;
    }

    /**
     * @param string $messageId
     * @return Data $this
     */
    public function setMessageId($messageId) {
        if (!(is_null($messageId) || is_string($messageId))) {
            $this->setDataError("Invalid message Id");
        } else {
            $this->messageId = $messageId;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getRoomId() {
        return $this->roomId;
    }

    /**
     * @param sting $roomId
     * @return Data $this
     */
    public function setRoomId($roomId) {
        if (!(is_null($roomId) || is_string($roomId))) {
            $this->setDataError("Invalid room Id");
        } else {
            $this->roomId = $roomId;
        }

        return $this;
    }

    /**
     * @TODO: if should use $this->text both for request and response as far as 'msg' is returned from API response
     * @return string
     */
    public function getMsg() {
        return $this->text;
    }

    /**
     * @param string $text The text of the message to send, is optional because of attachments.
     * @return Data $this
     */
    public function setText($text) {
        if (is_string($text)) {
            $this->text = $text;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getAlias() {
        return $this->alias;
    }

    /**
     * @param string|null $alias This will cause the message's name to appear as the given alias, but your username will still display.
     * @return Data $this
     */
    public function setAlias(string $alias = null) {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @param string $emoji If provided, this will make the avatar on this message be an emoji.
     * @return Data $this
     */
    public function setEmoji(string $emoji) {
        $this->emoji = $emoji;
        return $this;
    }

    /**
     * @param string $avatar If provided, this will make the avatar use the provided image url.
     * @return Data $this
     */
    public function setAvatar(string $avatar) {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return string
     */
    public function getChannel() {
        return $this->channel;
    }

    /**
     * @return bool
     */
    public function isParseUrls() {
        return $this->parseUrls;
    }

    /**
     * @param bool|null $parseUrls
     * @return Data $this
     */
    public function setParseUrls($parseUrls) {
        if (!is_bool($parseUrls)) {
            $this->setDataError("Invalid parseUrls value");
        } else {
            $this->parseUrls = $parseUrls;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isGroupable() {
        return $this->groupable;
    }

    /**
     * @param bool|null $groupable
     * @return Data $this
     */
    public function setGroupable($groupable) {
        if (!is_bool($groupable)) {
            $this->setDataError("Invalid groupable value");
        } else {
            $this->groupable = $groupable;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getTs() {
        return $this->ts;
    }

    /**
     * @param string $value
     * @return $this
     */
    private function setTs($value) {
        if (is_string($value)) {
            $this->ts = $value;
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
     */
    public function setUserId(string $userId = null) {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(string $username = null) {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string|null $updatedAt
     */
    public function setUpdatedAt(string $updatedAt = null) {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param \stdClass $response
     * @return Data $this
     */
    public function updateOutOfResponse($response) {
        if (isset($response->_id)) {
            $this->setMessageId($response->_id);
        }
        if (isset($response->alias)) {
            $this->setAlias($response->alias);
        }
        if (isset($response->msg)) {
            $this->setText($response->msg);
        }
        if (isset($response->parseUrls)) {
            $this->setParseUrls($response->parseUrls);
        }
        if (isset($response->groupable)) {
            $this->setGroupable($response->groupable);
        }
        if (isset($response->u)) {
            $this->setUserId($response->u->_id);
            $this->setUsername($response->u->username);
        }
        if (isset($response->ts)) {
            $this->setTs($response->ts);
        }
        if (isset($response->_updatedAt)) {
            $this->setUpdatedAt($response->_updatedAt);
        }

        return $this;
    }

    /**
     * Gets full user data to submit to api
     *
     * @return array
     */
    public function jsonSerialize() {
        $messageData = ['roomId' => $this->roomId];
        if (!is_null($this->text)) {
            $messageData['text'] = $this->text;
        }
        if (!is_null($this->avatar)) {
            $messageData['alias'] = $this->avatar;
        }
        if (!is_null($this->alias)) {
            $messageData['alias'] = $this->alias;
        }
        if (!is_null($this->emoji)) {
            $messageData['emoji'] = $this->emoji;
        }

        return $messageData;
    }

    /**
     * @param string $error
     * @return Data $this
     */
    private function setDataError($error) {
        static::setError($error);
        return $this;
    }
}
