<?php

namespace ATDev\RocketChat\Roles;

use ATDev\RocketChat\Common\Request;
use ATDev\RocketChat\Users\User;

/**
 * Role class
 */
class Role extends Request
{
    use \ATDev\RocketChat\Roles\Data;

    /**
     * Gets role listing
     *
     * @return Collection|bool
     */
    public static function listing()
    {
        static::send("roles.list", "GET");

        if (!static::getSuccess()) {
            return false;
        }

        $roles = new Collection();

        foreach (static::getResponse()->roles as $role) {
            $roles->add(static::createOutOfResponse($role));
        }

        return $roles;
    }

    /**
     * Gets all the roles in the system which are updated after a given date
     *
     * @param string $updatedSince
     * @return array|false
     */
    public static function sync($updatedSince)
    {
        static::send("roles.sync", "GET", ["updatedSince" => $updatedSince]);
        if (!static::getSuccess()) {
            return false;
        }

        $roles = static::getResponse()->roles;

        $result = ["update" => new Collection(), "remove" => new Collection()];
        foreach ($roles->update as $role) {
            $result['update']->add(static::createOutOfResponse($role));
        }
        foreach ($roles->remove as $role) {
            $result['remove']->add(static::createOutOfResponse($role));
        }

        return $result;
    }

    /**
     * Creates a new role in the system
     *
     * @return Role|false
     */
    public function create()
    {
        static::send("roles.create", "POST", $this);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->role);
    }

    /**
     * Assigns a role to an user
     *
     * @param User $user
     * @param string $roomId
     * @return Role|false
     */
    public function addUserToRole(User $user, $roomId = '')
    {
        $data = [
            'roleName' => $this->name,
            'username' => $user->getUsername()
        ];
        if (!empty($roomId)) {
            $data["roomId"] = $roomId;
        }
        static::send("roles.addUserToRole", "POST", $data);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->role);
    }

    /**
     * Gets the users that belongs to a role
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Users\Collection|false
     */
    public function getUsersInRole($offset = 0, $count = 0)
    {
        static::send(
            "roles.getUsersInRole",
            "GET",
            ["offset" => $offset, "count" => $count, "role" => $this->getRole(), "roomId" => $this->getRoomId()]
        );
        if (!static::getSuccess()) {
            return false;
        }

        $users = new \ATDev\RocketChat\Users\Collection();
        $response = static::getResponse();

        if (isset($response->users)) {
            foreach ($response->users as $user) {
                $users->add(User::createOutOfResponse($user));
            }
        }
        if (isset($response->total)) {
            $users->setTotal($response->total);
        }

        return $users;
    }
}
