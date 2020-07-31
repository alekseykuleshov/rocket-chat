<?php

namespace ATDev\RocketChat\Channels;

use ATDev\RocketChat\Common\Request;
use ATDev\RocketChat\Common\Room;
use ATDev\RocketChat\Messages\Message;
use ATDev\RocketChat\Users\User;

/**
 * Channel class
 */
class Channel extends Request
{
    use Room;
    use Data;

    /**
     * Gets channel listing
     *
     * @param int $offset
     * @param int $count
     * @return Collection|bool
     */
    public static function listing($offset = 0, $count = 0)
    {
        static::send("channels.list", "GET", ['offset' => $offset, 'count' => $count]);
        if (!static::getSuccess()) {
            return false;
        }

        $channels = new Collection();
        $response = static::getResponse();
        if (isset($response->channels)) {
            foreach ($response->channels as $channel) {
                $channels->add(static::createOutOfResponse($channel));
            }
        }
        if (isset($response->total)) {
            $channels->setTotal($response->total);
        }
        if (isset($response->count)) {
            $channels->setCount($response->count);
        }
        if (isset($response->offset)) {
            $channels->setOffset($response->offset);
        }

        return $channels;
    }

    /**
     * Creates channel at api instance
     *
     * @return Channel|boolean
     */
    public function create()
    {
        static::send("channels.create", "POST", $this);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->channel);
    }

    /**
     * Deletes channel
     *
     * @return Channel|boolean
     */
    public function delete()
    {
        static::send("channels.delete", "POST", ["roomId" => $this->getChannelId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->setChannelId(null);
    }

    /**
     * Gets channel info
     *
     * @return Channel|boolean
     */
    public function info()
    {
        static::send("channels.info", "GET", ["roomId" => $this->getChannelId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->channel);
    }

    /**
     * Adds channel back to user list of channels
     *
     * @return Channel|boolean
     */
    public function open()
    {
        static::send("channels.open", "POST", ["roomId" => $this->getChannelId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Removes channel from user list of channels
     *
     * @return Channel|boolean
     */
    public function close()
    {
        static::send("channels.close", "POST", ["roomId" => $this->getChannelId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Invite user to channel
     *
     * @param User $user
     * @return Channel|boolean
     */
    public function invite(User $user)
    {
        static::send("channels.invite", "POST", ["roomId" => $this->getChannelId(), "userId" => $user->getUserId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Kicks user out of the channel
     *
     * @param User $user
     * @return Channel|boolean
     */
    public function kick(User $user)
    {
        static::send("channels.kick", "POST", ["roomId" => $this->getChannelId(), "userId" => $user->getUserId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Adds owner of the channel
     *
     * @param User $user
     * @return Channel|boolean
     */
    public function addOwner(User $user)
    {
        static::send("channels.addOwner", "POST", ["roomId" => $this->getChannelId(), "userId" => $user->getUserId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Removes owner of the channel
     *
     * @param User $user
     * @return Channel|boolean
     */
    public function removeOwner(User $user)
    {
        static::send("channels.removeOwner", "POST", ["roomId" => $this->getChannelId(), "userId" => $user->getUserId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Lists all of the specific channel messages on the server
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Messages\Collection|bool
     */
    public function messages($offset = 0, $count = 0)
    {
        static::send(
            'channels.messages',
            'GET',
            ['roomId' => $this->getRoomId(), 'offset' => $offset, 'count' => $count]
        );
        if (!static::getSuccess()) {
            return false;
        }
        $response = static::getResponse();
        $messages = new \ATDev\RocketChat\Messages\Collection();
        if (isset($response->messages)) {
            foreach ($response->messages as $message) {
                $messages->add(Message::createOutOfResponse($message));
            }
        }
        if (isset($response->total)) {
            $messages->setTotal($response->total);
        }
        if (isset($response->count)) {
            $messages->setCount($response->count);
        }
        if (isset($response->offset)) {
            $messages->setOffset($response->offset);
        }

        return $messages;
    }

    /**
     * Adds all of the users of the Rocket.Chat server to the channel
     *
     * @param false $activeUsersOnly
     * @return Channel|false
     */
    public function addAll($activeUsersOnly = false)
    {
        static::send(
            'channels.addAll',
            'POST',
            ['roomId' => $this->getChannelId(), 'activeUsersOnly' => $activeUsersOnly]
        );
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->channel);
    }

    /**
     * Gives the role of Leader for a user in the current channel
     *
     * @param User $user
     * @return $this|false
     */
    public function addLeader(User $user)
    {
        static::send(
            'channels.addLeader',
            'POST',
            ['roomId' => $this->getChannelId(), 'userId' => $user->getUserId()]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Gives the role of moderator for a user in the current channel
     *
     * @param User $user
     * @return $this|false
     */
    public function addModerator(User $user)
    {
        static::send(
            'channels.addModerator',
            'POST',
            ['roomId' => $this->getChannelId(), 'userId' => $user->getUserId()]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Gets the messages in public channels to an anonymous user
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Messages\Collection|false
     */
    public function anonymousRead($offset = 0, $count = 0)
    {
        static::send(
            'channels.anonymousread',
            'GET',
            array_merge(self::requestParams($this), ['offset' => $offset, 'count' => $count])
        );

        if (!static::getSuccess()) {
            return false;
        }
        $response = static::getResponse();
        $messages = new \ATDev\RocketChat\Messages\Collection();
        if (isset($response->messages)) {
            foreach ($response->messages as $message) {
                $messages->add(Message::createOutOfResponse($message));
            }
        }
        if (isset($response->total)) {
            $messages->setTotal($response->total);
        }
        if (isset($response->count)) {
            $messages->setCount($response->count);
        }
        if (isset($response->offset)) {
            $messages->setOffset($response->offset);
        }

        return $messages;
    }

    /**
     * Archives a channel
     *
     * @return $this|false
     */
    public function archive()
    {
        static::send('channels.archive', 'POST', ['roomId' => $this->getRoomId()]);
        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Unarchives a channel
     *
     * @return $this|false
     */
    public function unarchive()
    {
        static::send('channels.unarchive', 'POST', ['roomId' => $this->getRoomId()]);
        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Lists all of the channels the calling user has joined
     *
     * @param int $offset
     * @param int $count
     * @return Collection|false
     */
    public static function listJoined($offset = 0, $count = 0)
    {
        static::send('channels.list.joined', 'GET', ['offset' => $offset, 'count' => $count]);
        if (!static::getSuccess()) {
            return false;
        }

        $channels = new Collection();
        $response = static::getResponse();
        if (isset($response->channels)) {
            foreach ($response->channels as $channel) {
                $channels->add(static::createOutOfResponse($channel));
            }
        }
        if (isset($response->total)) {
            $channels->setTotal($response->total);
        }
        if (isset($response->count)) {
            $channels->setCount($response->count);
        }
        if (isset($response->offset)) {
            $channels->setOffset($response->offset);
        }

        return $channels;
    }

    /**
     * Gets channel counters
     *
     * @param User|null $user
     * @return Counters|false
     */
    public function counters(User $user = null)
    {
        $params = self::requestParams($this);
        if (isset($user)) {
            $params = array_merge($params, ['userId' => $user->getUserId()]);
        }
        static::send('channels.counters', 'GET', $params);
        if (!static::getSuccess()) {
            return false;
        }

        return (new Counters())->updateOutOfResponse(static::getResponse());
    }

    /**
     * Prepares request params to have `roomId` or `roomName`
     *
     * @param Channel|null $channel
     * @return array
     */
    private static function requestParams(Channel $channel = null)
    {
        $params = [];
        if (isset($channel) && !empty($channel->getChannelId())) {
            $params = ['roomId' => $channel->getChannelId()];
        } elseif (isset($channel) && !empty($channel->getName())) {
            $params = ['roomName' => $channel->getName()];
        }

        return $params;
    }
}
