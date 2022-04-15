<?php

namespace ATDev\RocketChat;

use ATDev\RocketChat\Common\Request;
use ATDev\RocketChat\Users\User;

/**
 * Chat class
 */
class Chat extends Request
{

    /**
     * Logs in user with provided credentials, or just get user with these credentials
     *
     * @param string $userName
     * @param string $password
     * @param boolean $auth
     *
     * @return \ATDev\RocketChat\Users\User|boolean
     */
    public static function login($userName, $password, $auth = true)
    {
        static::send("login", "POST", ["user" => $userName, "password" => $password]);

        if (isset(static::getResponse()->status) && (static::getResponse()->status != "success")) { // Own error structure

            if (isset(static::getResponse()->error)) {
                static::setError(static::getResponse()->error);
            } else {
                static::setError("Unknown error occurred while logging in");
            }

            return false;
        }

        if ($auth) {
            static::setAuthUserId(static::getResponse()->data->userId);
            static::setAuthToken(static::getResponse()->data->authToken);
            static::setAuthPassword($password);
        }

        return User::createOutOfResponse(static::getResponse()->data->me);
    }

    /**
     * Gets data of currently logged in user
     *
     * @return \ATDev\RocketChat\Users\User|boolean
     */
    public static function me()
    {
        static::send("me", "GET");

        if (!static::getSuccess()) {
            return false;
        }

        return User::createOutOfResponse(static::getResponse());
    }

    /**
     * Logs out currently logged in user
     */
    public static function logout()
    {
        static::send("logout", "GET");

        static::setAuthUserId(null);
        static::setAuthToken(null);
        static::setAuthPassword(null);

        return true;
    }
}
