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
}
