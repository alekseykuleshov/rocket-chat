<?php

namespace ATDev\RocketChat\Groups;

use ATDev\RocketChat\Channels\Channel;
use ATDev\RocketChat\Common\Request;
use ATDev\RocketChat\Files\File;
use ATDev\RocketChat\Messages\Message;
use ATDev\RocketChat\RoomRoles\RoomRole;
use ATDev\RocketChat\Users\User;

/**
 * Group class
 */
class Group extends Request
{
    use \ATDev\RocketChat\Common\Room;
    use \ATDev\RocketChat\Groups\Data;

    /**
     * Gets groups listing
     *
     * @param int $offset
     * @param int $count
     * @return Collection|bool
     */
    public static function listing($offset = 0, $count = 0)
    {
        static::send("groups.list", "GET", ['offset' => $offset, 'count' => $count]);

        if (!static::getSuccess()) {
            return false;
        }

        $groups = new Collection();
        $response =static::getResponse();
        foreach ($response->groups as $group) {
            $groups->add(static::createOutOfResponse($group));
        }
        if (isset($response->total)) {
            $groups->setTotal($response->total);
        }
        if (isset($response->count)) {
            $groups->setCount($response->count);
        }
        if (isset($response->offset)) {
            $groups->setOffset($response->offset);
        }

        return $groups;
    }

    /**
     * Creates group at api instance
     *
     * @return Group|boolean
     */
    public function create()
    {
        static::send("groups.create", "POST", $this);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->group);
    }


    /**
     * Deletes group
     *
     * @return Group|boolean
     */
    public function delete()
    {
        static::send("groups.delete", "POST", ["roomId" => $this->getGroupId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->setGroupId(null);
    }

    /**
     * Gets group info
     *
     * @return Group|boolean
     */
    public function info()
    {
        static::send("groups.info", "GET", ["roomId" => $this->getGroupId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->group);
    }

    /**
     * Adds group back to user list of groups
     *
     * @return Group|boolean
     */
    public function open()
    {
        static::send("groups.open", "POST", ["roomId" => $this->getGroupId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Removes group from user list of groups
     *
     * @return Group|boolean
     */
    public function close()
    {
        static::send("groups.close", "POST", ["roomId" => $this->getGroupId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Invite user to group
     *
     * @param User $user
     * @return Group|boolean
     */
    public function invite(User $user)
    {
        static::send("groups.invite", "POST", ["roomId" => $this->getGroupId(), "userId" => $user->getUserId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Kicks user out of the group
     *
     * @param User $user
     * @return Group|boolean
     */
    public function kick(User $user)
    {
        static::send("groups.kick", "POST", ["roomId" => $this->getGroupId(), "userId" => $user->getUserId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Adds owner of the group
     *
     * @param User $user
     * @return Group|boolean
     */
    public function addOwner(User $user)
    {
        static::send("groups.addOwner", "POST", ["roomId" => $this->getGroupId(), "userId" => $user->getUserId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Removes owner of the group
     *
     * @param User $user
     * @return Group|boolean
     */
    public function removeOwner(User $user)
    {
        static::send("groups.removeOwner", "POST", ["roomId" => $this->getGroupId(), "userId" => $user->getUserId()]);

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
            'groups.messages',
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
     * Retrieves the files from a channel
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Files\Collection|false
     */
    public function files($offset = 0, $count = 0)
    {
        static::send(
            'groups.files',
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
     * Retrieves the messages from a private group, only if you're part of the group
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
        $options['roomId'] = $this->getGroupId();

        static::send('groups.history', 'GET', $options);
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
     * Adds all of the users of the Rocket.Chat server to the group
     *
     * @param false $activeUsersOnly
     * @return Group|false
     */
    public function addAll($activeUsersOnly = false)
    {
        static::send(
            'groups.addAll',
            'POST',
            ['roomId' => $this->getGroupId(), 'activeUsersOnly' => $activeUsersOnly]
        );
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->channel);
    }

    /**
     * Gives the role of Leader for a user in the current group
     *
     * @param User $user
     * @return $this|false
     */
    public function addLeader(User $user)
    {
        static::send(
            'groups.addLeader',
            'POST',
            ['roomId' => $this->getGroupId(), 'userId' => $user->getUserId()]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Removes the role of Leader for a user in the current group
     *
     * @param User $user
     * @return $this|false
     */
    public function removeLeader(User $user)
    {
        static::send(
            'groups.removeLeader',
            'POST',
            ['roomId' => $this->getGroupId(), 'userId' => $user->getUserId()]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Gives the role of moderator for a user in the current group
     *
     * @param User $user
     * @return $this|false
     */
    public function addModerator(User $user)
    {
        static::send(
            'groups.addModerator',
            'POST',
            ['roomId' => $this->getGroupId(), 'userId' => $user->getUserId()]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Removes the role of moderator from a user in the current group
     *
     * @param User $user
     * @return $this|false
     */
    public function removeModerator(User $user)
    {
        static::send(
            'groups.removeModerator',
            'POST',
            ['roomId' => $this->getGroupId(), 'userId' => $user->getUserId()]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Archives a private group, only if you're part of the group
     *
     * @return $this|false
     */
    public function archive()
    {
        static::send('groups.archive', 'POST', ['roomId' => $this->getRoomId()]);
        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Unarchives a private group
     *
     * @return $this|false
     */
    public function unarchive()
    {
        static::send('groups.unarchive', 'POST', ['roomId' => $this->getRoomId()]);
        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Gets group counters
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
        static::send('groups.counters', 'GET', $params);
        if (!static::getSuccess()) {
            return false;
        }

        return (new Counters())->updateOutOfResponse(static::getResponse());
    }

    /**
     * Causes the callee to be removed from the private group, if they're part of it and are not the last owner
     *
     * @return Group|false
     */
    public function leave()
    {
        static::send('groups.leave', 'POST', ['roomId' => $this->getGroupId()]);
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->group);
    }

    /**
     * Lists the users of participants of a private group
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Users\Collection|false
     */
    public function members($offset = 0, $count = 0)
    {
        static::send(
            'groups.members',
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
     * Lists all group moderators
     *
     * @return \ATDev\RocketChat\Users\Collection|false
     */
    public function moderators()
    {
        static::send('groups.moderators', 'GET', self::requestParams($this));
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
     * Changes the name of the private group
     *
     * @param string $name
     * @return Group|false
     */
    public function rename($name)
    {
        static::send(
            'groups.rename',
            'POST',
            ['roomId' => $this->getGroupId(), 'name' => $name]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->group);
    }

    /**
     * Lists all user's roles in the private group
     *
     * @return \ATDev\RocketChat\RoomRoles\Collection|false
     */
    public function roles()
    {
        static::send('groups.roles', 'GET', self::requestParams($this));
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
     * Sets the announcement for the group
     *
     * @param string $announcement
     * @return $this|false
     */
    public function setAnnouncement($announcement = '')
    {
        static::send(
            'groups.setAnnouncement',
            'POST',
            ['roomId' => $this->getGroupId(), 'announcement' => $announcement]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Sets the custom fields for the private group
     *
     * @param \stdClass $customFields
     * @return Group|false
     */
    public function setCustomFields($customFields)
    {
        static::send(
            'groups.setCustomFields',
            'POST',
            array_merge(self::requestParams($this), ['customFields' => $customFields])
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->group);
    }

    /**
     * Sets the type of room this group should be
     *
     * @param string $type
     * @return Channel|Group|false
     */
    public function setType($type = 'p')
    {
        static::send(
            'groups.setType',
            'POST',
            ['roomId' => $this->getGroupId(), 'type' => $type]
        );

        if (!static::getSuccess()) {
            return false;
        }

        if ($type == 'p') {
            $room = self::updateOutOfResponse(static::getResponse()->group);
        } else {
            $room = Channel::createOutOfResponse(static::getResponse()->group);
        }

        return $room;
    }

    /**
     * Sets the description for the private group
     *
     * @param string $description
     * @return $this|false
     */
    public function setDescription($description = '')
    {
        static::send(
            'groups.setDescription',
            'POST',
            ['roomId' => $this->getGroupId(), 'description' => $description]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Sets whether the group is read only or not
     *
     * @param bool $readOnly
     * @return Group|false
     */
    public function setReadOnly($readOnly = true)
    {
        static::send(
            'groups.setReadOnly',
            'POST',
            ['roomId' => $this->getGroupId(), 'readOnly' => $readOnly]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->group);
    }

    /**
     * Sets the topic for the private group
     *
     * @param string $message
     * @return Group|false
     */
    public function setTopic($message = '')
    {
        static::send(
            'groups.setTopic',
            'POST',
            ['roomId' => $this->getGroupId(), 'topic' => $message]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse());
    }

    /**
     * Prepares request params to have `roomId` or `roomName`
     *
     * @param Group|null $group
     * @return array
     * @TODO refactor to Room trait
     */
    private static function requestParams(Group $group = null)
    {
        $params = [];
        if (isset($group) && !empty($group->getRoomId())) {
            $params = ['roomId' => $group->getRoomId()];
        } elseif (isset($group) && !empty($group->getName())) {
            $params = ['roomName' => $group->getName()];
        }

        return $params;
    }
}
