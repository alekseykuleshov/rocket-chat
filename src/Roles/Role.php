<?php

namespace ATDev\RocketChat\Roles;

use ATDev\RocketChat\Common\Request;

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
     * Create a new role in the system
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
}
