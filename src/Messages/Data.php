<?php

namespace ATDev\RocketChat\Messages;

use ATDev\RocketChat\Channels\Channel;
use ATDev\RocketChat\Users\User;

trait Data
{

    /** @var string Message id from api */
    private $messageId;

    /* Required properties for creation */
    /** @var string The room id of where the message is to be sent */
    private $roomId;
    /** @var string The text of the message to send */
    private $text;
    /** @var string This will cause the message's name to appear as the given alias */
    private $alias;
    /** @var string If provided, this will make the avatar on this message be an emoji */
    private $emoji;
    /** @var string If provided, this will make the avatar use the provided image url */
    private $avatar;

    /* Readonly properties returned from api */
    /** @var bool Indicates if urls from messages are parsed */
    private $parseUrls;
    /** @var bool */
    private $groupable;
    /** @var string timestamp */
    private $ts;
    /** @var string message type */
    private $t;
    /** @var string message user id */
    private $userId;
    /** @var string message user name */
    private $username;
    /** @var string Date-time */
    private $updatedAt;
    /** @var \ATDev\RocketChat\Users\Collection Users mentioned in message */
    private $mentions;
    /** @var \ATDev\RocketChat\Channels\Collection Channels mentioned in message */
    private $channels;

    /**
     * Class constructor
     *
     * @param string|null $messageId
     */
    public function __construct($messageId = null)
    {
        if (!empty($messageId)) {
            $this->setMessageId($messageId);
        }
    }

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param string $messageId
     * @return Data $this
     */
    public function setMessageId($messageId)
    {
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
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * @param string $roomId
     * @return Data $this
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
     * @return string The text of the message
     */
    public function getMsg()
    {
        return $this->text;
    }

    /**
     * @param string $text The text of the message to send, is optional because of attachments.
     * @return Data $this
     */
    public function setText($text)
    {
        if (is_string($text)) {
            $this->text = $text;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias This will cause the message's name to appear as the given alias, but your username will still display.
     * @return Data $this
     */
    public function setAlias($alias)
    {
        if (is_string($alias)) {
            $this->alias = $alias;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getEmoji()
    {
        return $this->emoji;
    }

    /**
     * @param string $emoji If provided, this will make the avatar on this message be an emoji.
     * @return Data $this
     */
    public function setEmoji($emoji)
    {
        if (is_string($emoji)) {
            $this->emoji = $emoji;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar If provided, this will make the avatar use the provided image url.
     * @return Data $this
     */
    public function setAvatar($avatar)
    {
        if (is_string($avatar)) {
            $this->avatar = $avatar;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isParseUrls()
    {
        return $this->parseUrls;
    }

    /**
     * @param bool $parseUrls
     * @return Data $this
     */
    private function setParseUrls($parseUrls)
    {
        if (!is_bool($parseUrls)) {
            $this->setDataError('Invalid parseUrls value');
        } else {
            $this->parseUrls = $parseUrls;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isGroupable()
    {
        return $this->groupable;
    }

    /**
     * @param bool $groupable
     * @return Data $this
     */
    private function setGroupable($groupable)
    {
        if (!is_bool($groupable)) {
            $this->setDataError('Invalid groupable value');
        } else {
            $this->groupable = $groupable;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    private function setUsername($username)
    {
        if (is_string($username)) {
            $this->username = $username;
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
     * Returns users collection mentioned in message
     *
     * @return \ATDev\RocketChat\Users\Collection
     */
    public function getMentions()
    {
        return $this->mentions;
    }

    /**
     * Sets users collection mentioned in message
     *
     * @param array $mentions
     * @return $this
     */
    private function setMentions($mentions = [])
    {
        if (is_array($mentions)) {
            $this->mentions = new \ATDev\RocketChat\Users\Collection();
            foreach ($mentions as $user) {
                $this->mentions->add(User::createOutOfResponse($user));
            }
        }

        return $this;
    }

    /**
     * Returns channels collection mentioned in message
     *
     * @return \ATDev\RocketChat\Channels\Collection
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * Sets channels collection mentioned in message
     *
     * @param array $channels
     * @return $this
     */
    private function setChannels($channels = [])
    {
        if (is_array($channels)) {
            $this->channels = new \ATDev\RocketChat\Channels\Collection();
            foreach ($channels as $channel) {
                $this->channels->add(Channel::createOutOfResponse($channel));
            }
        }

        return $this;
    }

    /**
     * @param \stdClass $response
     * @return Data
     */
    public static function createOutOfResponse($response)
    {
        $message = new static($response->_id);
        return $message->updateOutOfResponse($response);
    }

    /**
     * @param \stdClass $response
     * @return Data $this
     */
    public function updateOutOfResponse($response)
    {
        if (isset($response->_id)) {
            $this->setMessageId($response->_id);
        }
        if (isset($response->rid)) {
            $this->setRoomId($response->rid);
        }
        if (isset($response->alias)) {
            $this->setAlias($response->alias);
        }
        if (isset($response->msg)) {
            $this->setText($response->msg);
        }
        if (isset($response->emoji)) {
            $this->setEmoji($response->emoji);
        }
        if (isset($response->avatar)) {
            $this->setAvatar($response->avatar);
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
        if (isset($response->t)) {
            $this->setT($response->t);
        }
        if (isset($response->_updatedAt)) {
            $this->setUpdatedAt($response->_updatedAt);
        }
        if (isset($response->mentions)) {
            $this->setMentions($response->mentions);
        }
        if (isset($response->channels)) {
            $this->setChannels($response->channels);
        }

        return $this;
    }

    /**
     * Prepares message data to be sent to API
     *
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        $messageData = ['roomId' => $this->roomId];
        if (!is_null($this->text)) {
            $messageData['text'] = $this->text;
        }
        if (!is_null($this->avatar)) {
            $messageData['avatar'] = $this->avatar;
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
    private function setDataError($error)
    {
        static::setError($error);

        return $this;
    }
}
