<?php

namespace ATDev\RocketChat\Channels;

use ATDev\RocketChat\Common\Request;
use ATDev\RocketChat\Common\Room;
use ATDev\RocketChat\Files\File;
use ATDev\RocketChat\Groups\Group;
use ATDev\RocketChat\Messages\Message;
use ATDev\RocketChat\RoomRoles\RoomRole;
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
     * Removes the role of Leader for a user in the current channel
     *
     * @param User $user
     * @return $this|false
     */
    public function removeLeader(User $user)
    {
        static::send(
            'channels.removeLeader',
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
     * Removes the role of moderator from a user in the current channel
     *
     * @param User $user
     * @return $this|false
     */
    public function removeModerator(User $user)
    {
        static::send(
            'channels.removeModerator',
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
     * Joins yourself to the channel
     *
     * @param string $joinCode
     * @return Channel|false
     */
    public function join($joinCode)
    {
        static::send('channels.join', 'POST', [
            'roomId' => $this->getChannelId(), 'joinCode' => $joinCode
        ]);
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->channel);
    }

    /**
     * Causes the callee to be removed from the channel
     *
     * @return Channel|false
     */
    public function leave()
    {
        static::send('channels.leave', 'POST', ['roomId' => $this->getChannelId()]);
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->channel);
    }

    /**
     * Lists all channel users
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Users\Collection|false
     */
    public function members($offset = 0, $count = 0)
    {
        static::send(
            'channels.members',
            'GET',
            array_merge(self::requestParams($this), ['offset' => $offset, 'count' => $count])
        );
        if (!static::getSuccess()) {
            return false;
        }

        $members = new \ATDev\RocketChat\Users\Collection();
        $response = static::getResponse();
        if (isset($response->members)) {
            foreach ($response->members as $user) {
                $members->add(User::createOutOfResponse($user));
            }
        }
        if (isset($response->total)) {
            $members->setTotal($response->total);
        }
        if (isset($response->count)) {
            $members->setCount($response->count);
        }
        if (isset($response->offset)) {
            $members->setOffset($response->offset);
        }

        return $members;
    }

    /**
     * Channel Moderators List
     *
     * @return \ATDev\RocketChat\Users\Collection|false
     */
    public function moderators()
    {
        static::send('channels.moderators', 'GET', self::requestParams($this));
        if (!static::getSuccess()) {
            return false;
        }

        $moderators = new \ATDev\RocketChat\Users\Collection();
        $response = static::getResponse();
        if (isset($response->moderators)) {
            foreach ($response->moderators as $user) {
                $moderators->add(User::createOutOfResponse($user));
            }
        }

        return $moderators;
    }

    /**
     * Lists all online users of a channel
     *
     * @param array|null $query
     * @return \ATDev\RocketChat\Users\Collection|false
     */
    public function online()
    {
        $query = ['_id' => $this->getChannelId()];

        static::send('channels.online', 'GET', ['query' => json_encode($query)]);
        if (!static::getSuccess()) {
            return false;
        }

        $users = new \ATDev\RocketChat\Users\Collection();
        $response = static::getResponse();
        if (isset($response->online)) {
            foreach ($response->online as $user) {
                $users->add(User::createOutOfResponse($user));
            }
        }

        return $users;
    }

    /**
      * Lists all online users of all channels
      *
      * @param array|null $query
      * @return \ATDev\RocketChat\Users\Collection|false
      */
    public static function onlineAll()
    {
        static::send('channels.online', 'GET', ['query' => json_encode(null)]);
        if (!static::getSuccess()) {
            return false;
        }

        $users = new \ATDev\RocketChat\Users\Collection();
        $response = static::getResponse();
        if (isset($response->online)) {
            foreach ($response->online as $user) {
                $users->add(User::createOutOfResponse($user));
            }
        }

        return $users;
    }

    /**
     * Changes the name of the channel
     *
     * @param $name
     * @return Channel|false
     */
    public function rename($name)
    {
        static::send(
            'channels.rename',
            'POST',
            ['roomId' => $this->getChannelId(), 'name' => $name]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->channel);
    }

    /**
     * Gets all user's the mentions of a channel
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Messages\Collection|false
     */
    public function getAllUserMentionsByChannel($offset = 0, $count = 0)
    {
        static::send(
            'channels.getAllUserMentionsByChannel',
            'GET',
            ['roomId' => $this->getChannelId(), 'offset' => $offset, 'count' => $count]
        );

        if (!static::getSuccess()) {
            return false;
        }

        $messages = new \ATDev\RocketChat\Messages\Collection();
        $response = static::getResponse();
        if (isset($response->mentions)) {
            foreach ($response->mentions as $message) {
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
     * Lists all user's roles in the channel
     *
     * @return \ATDev\RocketChat\RoomRoles\Collection|false
     */
    public function roles()
    {
        static::send('channels.roles', 'GET', self::requestParams($this));
        if (!static::getSuccess()) {
            return false;
        }

        $roomRoles = new \ATDev\RocketChat\RoomRoles\Collection();
        $response = static::getResponse();
        if (isset($response->roles)) {
            foreach ($response->roles as $roomRole) {
                $roomRoles->add(RoomRole::createOutOfResponse($roomRole));
            }
        }

        return $roomRoles;
    }

    /**
     * Sets whether the channel is a default channel or not
     *
     * @param bool $default
     * @return Channel|false
     */
    public function setDefault($default = true)
    {
        static::send(
            'channels.setDefault',
            'POST',
            ['roomId' => $this->getChannelId(), 'default' => $default]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->channel);
    }

    /**
     * Sets the code required to join the channel
     *
     * @param string $joinCode
     * @return Channel|false
     */
    public function setJoinCode($joinCode)
    {
        static::send(
            'channels.setJoinCode',
            'POST',
            ['roomId' => $this->getChannelId(), 'joinCode' => $joinCode]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->channel);
    }

    /**
     * Sets the description for the channel
     *
     * @param string $description
     * @return $this|false
     */
    public function setDescription($description = '')
    {
        static::send(
            'channels.setDescription',
            'POST',
            ['roomId' => $this->getChannelId(), 'description' => $description]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Sets the announcement for the channel
     *
     * @param string $announcement
     * @return $this|false
     */
    public function setAnnouncement($announcement = '')
    {
        static::send(
            'channels.setAnnouncement',
            'POST',
            ['roomId' => $this->getChannelId(), 'announcement' => $announcement]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Sets the custom fields for the channel
     *
     * @param \stdClass $customFields
     * @return Channel|false
     */
    public function setCustomFields($customFields)
    {
        static::send(
            'channels.setCustomFields',
            'POST',
            array_merge(self::requestParams($this), ['customFields' => $customFields])
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->channel);
    }

    /**
     * Sets whether the channel is read only or not
     *
     * @param bool $readOnly
     * @return Channel|false
     */
    public function setReadOnly($readOnly = true)
    {
        static::send(
            'channels.setReadOnly',
            'POST',
            ['roomId' => $this->getChannelId(), 'readOnly' => $readOnly]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->channel);
    }

    /**
     * Sets the topic for the channel
     *
     * @param string $message
     * @return Channel|false
     */
    public function setTopic($message = '')
    {
        static::send(
            'channels.setTopic',
            'POST',
            ['roomId' => $this->getChannelId(), 'topic' => $message]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse());
    }

    /**
     * Sets the type of room this channel should be
     *
     * @param string $type
     * @return Channel|Group|false
     * @TODO: Room types are described here: https://docs.rocket.chat/api/schema-definition/the-room-object#room-types
     * Room type values should be described in constants in Room class
     */
    public function setType($type = 'c')
    {
        static::send(
            'channels.setType',
            'POST',
            ['roomId' => $this->getChannelId(), 'type' => $type]
        );

        if (!static::getSuccess()) {
            return false;
        }

        if ($type == 'p') {
            $room = Group::createOutOfResponse(static::getResponse()->channel);
        } else {
            $room = self::updateOutOfResponse(static::getResponse()->channel);
        }

        return $room;
    }

    /**
     * Retrieves the messages from a channel
     *
     * @param array $options
     * @return \ATDev\RocketChat\Messages\Collection|false
     */
    public function history($options = [])
    {
        $options = array_replace([
            'offset' => 0,
            'count' => 0
        ], $options);
        $options['roomId'] = $this->getChannelId();

        static::send('channels.history', 'GET', $options);
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

        return $messages;
    }

    /**
     * Retrieves the files from a channel
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Files\Collection|false
     */
    public function files($offset = 0, $count = 0)
    {
        static::send(
            'channels.files',
            'GET',
            array_merge(self::requestParams($this), ['offset' => $offset, 'count' => $count])
        );
        if (!static::getSuccess()) {
            return false;
        }
        $response = static::getResponse();
        $files = new \ATDev\RocketChat\Files\Collection();
        if (isset($response->files)) {
            foreach ($response->files as $file) {
                $files->add(File::createOutOfResponse($file));
            }
        }
        if (isset($response->total)) {
            $files->setTotal($response->total);
        }
        if (isset($response->count)) {
            $files->setCount($response->count);
        }
        if (isset($response->offset)) {
            $files->setOffset($response->offset);
        }

        return $files;
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
