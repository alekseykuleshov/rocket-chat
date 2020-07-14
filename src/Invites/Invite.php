<?php

namespace ATDev\RocketChat\Invites;

use ATDev\RocketChat\Common\Request;
use ATDev\RocketChat\Common\RoomClass;

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

    /**
     * Creates or return an existing invite with the specified parameters
     *
     * @return Invite|bool
     */
    public function findOrCreateInvite()
    {
        static::send(
            "findOrCreateInvite",
            "POST",
            ["rid" => $this->getRoomId(), "days" => $this->getDays(), "maxUses" => $this->getMaxUses()]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return $this::updateOutOfResponse(static::getResponse());
    }

    /**
     * Removes an invite from the server
     *
     * @return Invite|bool
     */
    public function removeInvite()
    {
        static::send("removeInvite/{$this->getInviteId()}", "DELETE");

        if (!static::getSuccess()) {
            return false;
        }

        return $this->setInviteId(null);
    }

    /**
     * Report to the server that an invite token was used
     *
     * @return Invite|bool
     */
    public function useInviteToken()
    {
        static::send("useInviteToken", "POST", ["token" => $this->getInviteId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return (new RoomClass())->updateOutOfResponse(static::getResponse()->room);
    }

    /**
     * Checks if an invite token is valid
     *
     * @return Invite|bool
     */
    public function validateInviteToken()
    {
        static::send("validateInviteToken", "POST", ["token" => $this->getInviteId()]);

        if (!static::getSuccess()) {
            return false;
        }
        
        return $this::updateOutOfResponse(static::getResponse());
    }
}