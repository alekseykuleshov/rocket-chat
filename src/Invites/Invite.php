<?php

namespace ATDev\RocketChat\Invites;

use ATDev\RocketChat\Common\Request;

/**
 * Invite class
 */
class Invite extends Request
{
    use \ATDev\RocketChat\Invites\Data;

    /**
     * Gets invite listing
     *
     * @return Collection|bool
     */
    public static function listing()
    {
        static::send("listInvites", "GET");

        if (!static::getSuccess()) {
            return false;
        }

        $invites = new Collection();

        foreach (static::getResponse() as $invite) {
            $invites->add(static::createOutOfResponse($invite));
        }

        return $invites;
    }
}