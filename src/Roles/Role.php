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
}
