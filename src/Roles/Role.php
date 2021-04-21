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
     * @return $this|false
     */
    public function sync()
    {
        static::send("roles.sync", "GET", ["updatedSince" => $this->getUpdatedSince()]);
        if (!static::getSuccess()) {
            return false;
        }

        $roles = static::getResponse()->roles;

        $this->update = new Collection();
        foreach ($roles->update as $role) {
            $this->update->add(static::createOutOfResponse($role));
        }
        $this->remove = new Collection();
        foreach ($roles->remove as $role) {
            $this->remove->add(static::createOutOfResponse($role));
        }

        return $this;
    }

    /**
     * Creates a new role in the system
     *
     * @return Role|false
     */
    public function create()
    {
        $createData = [
            "name" => $this->name
        ];
        if (isset($this->scope)) {
            $createData["scope"] = $this->scope;
        }
        if (isset($this->description)) {
            $createData["description"] = $this->description;
        }

        static::send("roles.create", "POST", $createData);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->role);
    }

    /**
     * Assigns a role to an user
     *
     * @return Role|false
     */
    public function addUserToRole()
    {
        static::send("roles.addUserToRole", "POST", $this);
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
