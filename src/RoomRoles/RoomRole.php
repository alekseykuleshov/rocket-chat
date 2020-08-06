<?php

namespace ATDev\RocketChat\RoomRoles;

use ATDev\RocketChat\Users\User;

/**
 * Class RoomRole
 * Room-wide special users and their roles
 *
 * @package ATDev\RocketChat\RoomRoles
 */
class RoomRole
{
    /** @var string The id of this object */
    private $roomRoleId;
    /** @var string The room id this user and role belongs to */
    private $roomId;
    /** @var User A simple user object with the user id and username */
    private $user;
    /** @var array The collection of roles of the user in the room */
    private $roles;

    /**
     * RoomRole constructor.
     * @param string|null $roomRoleId
     */
    public function __construct($roomRoleId = null)
    {
        if (!empty($roomRoleId)) {
            $this->setRoomRoleId($roomRoleId);
        }
    }

    public static function createOutOfResponse($response)
    {
        $roomRole = new static($response->_id);
        return $roomRole->updateOutOfResponse($response);
    }

    public function updateOutOfResponse($response)
    {
        if (isset($response->_id)) {
            $this->setRoomRoleId($response->_id);
        }
        if (isset($response->rid)) {
            $this->setRoomId($response->rid);
        }
        if (isset($response->u)) {
            $this->setUser($response->u);
        }
        if (isset($response->roles)) {
            $this->setRoles($response->roles);
        }

        return $this;
    }

    /**
     * Returns id of this RoomRole object
     *
     * @return string
     */
    public function getRoomRoleId()
    {
        return $this->roomRoleId;
    }

    /**
     * Sets id to this RoomRole object
     *
     * @param string $roomRoleId
     * @return RoomRole
     */
    private function setRoomRoleId($roomRoleId)
    {
        if (is_string($roomRoleId)) {
            $this->roomRoleId = $roomRoleId;
        }
        return $this;
    }

    /**
     * Returns room id this user and role belongs to
     *
     * @return string
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * Sets room id this user and role belongs to
     *
     * @param string $roomId
     * @return RoomRole
     */
    private function setRoomId($roomId)
    {
        if (is_string($roomId)) {
            $this->roomId = $roomId;
        }
        return $this;
    }

    /**
     * Returns a user object with the user id and username set
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets a user object  with the user id and username
     *
     * @param \stdClass $user
     * @return RoomRole
     */
    public function setUser($user)
    {
        if (is_object($user) && isset($user->_id)) {
            $this->user = User::createOutOfResponse($user);
        }
        return $this;
    }

    /**
     * Returns array of roles of the user in the room
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Sets roles of the user in the room
     *
     * @param array $roles
     * @return RoomRole
     */
    private function setRoles($roles)
    {
        if (is_array($roles)) {
            $this->roles = $roles;
        }
        return $this;
    }
}
