<?php

namespace ATDev\RocketChat\Users;

use ATDev\RocketChat\Common\Request;
use ATDev\RocketChat\Users\Avatar;

/**
 * User class
 */
class User extends Request
{
    use \ATDev\RocketChat\Users\Data;

    /**
     * Gets user listing
     *
     * @return \ATDev\RocketChat\Users\Collection|boolean
     */
    public static function listing()
    {
        static::send("users.list", "GET");

        if (!static::getSuccess()) {
            return false;
        }

        $users = new Collection();
        foreach (static::getResponse()->users as $user) {
            $users->add(static::createOutOfResponse($user));
        }

        return $users;
    }

    /**
     * Creates user at api instance
     *
     * @return \ATDev\RocketChat\Users\User|boolean
     */
    public function create()
    {
        static::send("users.create", "POST", $this);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->user);
    }

    /**
     * Updates user at api instance
     *
     * @return \ATDev\RocketChat\Users\User|boolean
     */
    public function update()
    {
        static::send("users.update", "POST", ["userId" => $this->getUserId(), "data" => $this]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->user);
    }

    /**
     * Gets extended info of user
     *
     * @return boolean|$this
     */
    public function info()
    {
        static::send("users.info", "GET", ["userId" => $this->getUserId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->user);
    }

    /**
     * Gets extended info of user
     *
     * @return boolean|$this
     */
    public function delete()
    {
        static::send("users.delete", "POST", ["userId" => $this->getUserId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->setUserId(null);
    }

    /**
     * Sets avatar for user
     *
     * @param \ATDev\RocketChat\Users\Avatar $avatar
     *
     * @return boolean|$this
     */
    public function setAvatar(Avatar $avatar)
    {
        if ($avatar::IS_FILE) {
            $result = static::send("users.setAvatar", "POST", ["userId" => $this->getUserId()], ["image" => $avatar->getSource()]);

            if (!static::getSuccess()) {
                return false;
            }
        } else {
            $result = static::send("users.setAvatar", "POST", ["userId" => $this->getUserId(), "avatarUrl" => $avatar->getSource()]);

            if (!static::getSuccess()) {
                return false;
            }
        }

        return $this;
    }

    /**
     * Gets avatar for user
     *
     * @return boolean|$this
     */
    public function getAvatar()
    {
        $result = static::send("users.getAvatar", "GET", ["userId" => $this->getUserId()]);

        if (!static::getSuccess()) {
            return false;
        }

        if (!empty(static::getResponseUrl())) {
            $this->setAvatarUrl(static::getResponseUrl());
        }

        return $this;
    }
}
