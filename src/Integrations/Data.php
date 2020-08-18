<?php

namespace ATDev\RocketChat\Integrations;

use ATDev\RocketChat\Users\User;

/**
 * Integration data trait
 */
trait Data
{
    /* Required */
    /** @var string The integration's id */
    private $integrationId;
    /** @var string The name of the integration */
    private $name;
    /** @var bool Whether this integration should be enabled or not */
    private $enabled;
    /** @var string The username who to post this the messages as */
    private $username;
    /** @var array The urls to call whenever this integration is triggered */
    private $urls;
    /** @var bool Whether the script should be enabled */
    private $scriptEnabled;
    /** @var string The type of integration to create */
    private $type;
    /** @var string The type of event (only for outgoing integration) */
    private $event;
    /** @var array The channel, group, or @username */
    private $channel;

    /* Optional */
    /** @var string The alias which should be applied to messages when this integration is processed */
    private $alias;
    /** @var string The logo to apply to the messages that this integration sends */
    private $avatar;
    /** @var array Specific words, separated by commas, which should trigger this integration */ // @todo
    private $triggerWords;
    /** @var string If your integration requires a special token from the server (api key), use this. */
    private $token;
    /** @var string Script triggered when this integration is triggered. */
    private $script;
    /** @var string The emoji which should be displayed as the avatar for messages from this integration */
    private $emoji;

    /** @var bool */
    private $impersonateUser;
    /** @var string */
    private $scriptCompiled;
    /** @var string */
    private $scriptError;
    /** @var string */
    private $userId;
    /** @var string */
    private $createdAt;
    /** @var string */
    private $updatedAt;
    /** @var User Integration created by user simple object */
    private $createdBy;

    /**
     * Data constructor.
     * @param string|null $integrationId
     */
    public function __construct($integrationId = null)
    {
        if (!empty($integrationId)) {
            $this->setIntegrationId($integrationId);
        }
    }

    /**
     * @return string
     */
    public function getIntegrationId()
    {
        return $this->integrationId;
    }

    /**
     * @param string $integrationId
     * @return Data $this
     */
    public function setIntegrationId($integrationId)
    {
        if (!(is_null($integrationId) || is_string($integrationId))) {
            $this->setDataError('Invalid integration Id');
        } else {
            $this->integrationId = $integrationId;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Data
     */
    public function setName($name)
    {
        if (!(is_null($name) || is_string($name))) {
            $this->setDataError('Invalid integration name');
        } else {
            $this->name = $name;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return Data
     */
    public function setEnabled($enabled)
    {
        if (!(is_null($enabled) || is_bool($enabled))) {
            $this->setDataError('Invalid integration `enabled` value');
        } else {
            $this->$enabled = $enabled;
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
     * @return Data
     */
    public function setUsername($username)
    {
        if (!(is_null($username) || is_string($username))) {
            $this->setDataError('Invalid integration `username` value');
        } else {
            $this->username = $username;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @param array $urls
     * @return Data
     */
    public function setUrls($urls)
    {
        if (!(is_null($urls) || is_array($urls) || array_reduce($urls, 'is_string', true))) {
            $this->setDataError('Invalid integration `urls` value');
        } else {
            $this->urls = $urls;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isScriptEnabled()
    {
        return $this->scriptEnabled;
    }

    /**
     * @param bool $scriptEnabled
     * @return Data
     */
    public function setScriptEnabled($scriptEnabled)
    {
        if (!(is_null($scriptEnabled) || is_bool($scriptEnabled))) {
            $this->setDataError('Invalid integration `scriptEnabled` value');
        } else {
            $this->scriptEnabled = $scriptEnabled;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Data
     */
    public function setType($type)
    {
        if (!(is_null($type) || in_array($type, ['webhook-outgoing', 'webhook-incoming']))) {
            $this->setDataError('Invalid integration `type` value');
        } else {
            $this->type = $type;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param string $event
     * @return Data
     */
    public function setEvent($event)
    {
        if (!(is_null($event) || in_array($event, ['sendMessage', 'fileUploaded', 'roomArchived', 'roomCreated', 'roomJoined', 'roomLeft', 'userCreated']))) {
            $this->setDataError('Invalid integration `event` value');
        } else {
            $this->event = $event;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param array $channel
     * @return Data
     */
    public function setChannel($channel)
    {
        if (!(is_null($channel) || is_array($channel) || array_reduce($channel, 'is_string', true))) {
            $this->setDataError('Invalid integration `channel` value');
        } else {
            $this->channel = $channel;
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
     * @param string $alias
     * @return Data
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
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     * @return Data
     */
    public function setAvatar($avatar)
    {
        if (is_string($avatar)) {
            $this->avatar = $avatar;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getTriggerWords()
    {
        return $this->triggerWords;
    }

    /**
     * @param array $triggerWords
     * @return Data
     */
    public function setTriggerWords($triggerWords)
    {
        if (is_array($triggerWords) && array_reduce($triggerWords, 'is_string', true)) {
            $this->triggerWords = $triggerWords;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Data
     */
    public function setToken($token)
    {
        if (is_string($token)) {
            $this->token = $token;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * @param string $script
     * @return Data
     */
    public function setScript($script)
    {
        if (is_string($script)) {
            $this->script = $script;
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
     * @param string $emoji
     * @return Data
     */
    public function setEmoji($emoji)
    {
        if (is_string($emoji)) {
            $this->emoji = $emoji;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isImpersonateUser()
    {
        return $this->impersonateUser;
    }

    /**
     * @param bool $impersonateUser
     * @return Data
     */
    private function setImpersonateUser($impersonateUser)
    {
        if (is_bool($impersonateUser)) {
            $this->impersonateUser = $impersonateUser;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScriptCompiled()
    {
        return $this->scriptCompiled;
    }

    /**
     * @param string $scriptCompiled
     * @return Data
     */
    private function setScriptCompiled($scriptCompiled)
    {
        if (is_string($scriptCompiled)) {
            $this->scriptCompiled = $scriptCompiled;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScriptError()
    {
        return $this->scriptError;
    }

    /**
     * @param string $scriptError
     * @return Data
     */
    public function setScriptError($scriptError)
    {
        if (is_string($scriptError)) {
            $this->scriptError = $scriptError;
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
     * @return Data
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
     * @return Data
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     * @return Data
     */
    private function setUpdatedAt($updatedAt)
    {
        if (is_string($updatedAt)) {
            $this->updatedAt = $updatedAt;
        }
        return $this;
    }

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param \stdClass $createdBy
     * @return Data
     */
    private function setCreatedBy($createdBy)
    {
        if (is_object($createdBy) && isset($createdBy->_id)) {
            $this->$createdBy = User::createOutOfResponse($createdBy);
        }
        return $this;
    }

    /**
     * Prepares integration data to be sent to API
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $integrationData = [
            'type' => $this->type,
            'name' => $this->name,
            'enabled' => $this->enabled,
            'event' => $this->event,
            'username' => $this->username,
            'urls' => $this->urls,
            'scriptEnabled' => $this->scriptEnabled,
            'channel' => join(',', $this->channel),
        ];

        if (!is_null($this->triggerWords)) {
            $integrationData['triggerWords'] = join(',', $this->triggerWords);
        }
        if (!is_null($this->alias)) {
            $integrationData['alias'] = $this->alias;
        }
        if (!is_null($this->avatar)) {
            $integrationData['avatar'] = $this->avatar;
        }
        if (!is_null($this->emoji)) {
            $integrationData['emoji'] = $this->emoji;
        }
        if (!is_null($this->token)) {
            $integrationData['token'] = $this->token;
        }
        if (!is_null($this->script)) {
            $integrationData['script'] = $this->script;
        }

        return $integrationData;
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
