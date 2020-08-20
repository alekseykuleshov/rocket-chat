<?php

namespace ATDev\RocketChat\Users;

use ATDev\RocketChat\Common\Request;

/**
 * User class
 */
class User extends Request
{
    use Data;

    /**
     * Gets user listing
     *
     * @return Collection|boolean
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
     * @return User|boolean
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
     * @return User|boolean
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
     * Update own basic information
     *
     * @return User|false
     */
    public function updateOwnBasicInfo()
    {
        $updateData = [
            "email" => $this->email,
            "name" => $this->name,
            "username" => $this->username,
        ];
        if (isset($this->password)) {
            $updateData["currentPassword"] = $this->password;
        }
        if (isset($this->newPassword)) {
            $updateData["newPassword"] = $this->newPassword;
        }
        if (isset($this->customFields)) {
            $updateData["customFields"] = $this->customFields;
        }

        static::send("users.updateOwnBasicInfo", "POST", ["data" => $updateData]);
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
        static::send("users.info", "GET", self::requestParams($this));

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
     * Deletes your own user. Requires `Allow Users to Delete Own Account` enabled
     *
     * @return $this|false
     */
    public function deleteOwnAccount()
    {
        static::send('users.deleteOwnAccount', 'POST', ['password' => $this->getPassword()]);
        if (!static::getSuccess()) {
            return false;
        }
        $this->setUserId(null);
        $this->setUsername(null);

        return $this;
    }

    /**
     * Sets avatar for user
     *
     * @param Avatar $avatar
     *
     * @return boolean|$this
     */
    public function setAvatar(Avatar $avatar)
    {
        if ($avatar::IS_FILE) {
            static::send("users.setAvatar", "POST", self::requestParams($this), ["image" => $avatar->getSource()]);

            if (!static::getSuccess()) {
                return false;
            }
        } else {
            static::send("users.setAvatar", "POST", array_merge(self::requestParams($this), ["avatarUrl" => $avatar->getSource()]));

            if (!static::getSuccess()) {
                return false;
            }
        }

        return $this;
    }

    /**
     * Gets avatar url for user
     *
     * @return boolean|$this
     */
    public function getAvatar()
    {
        static::send("users.getAvatar", "GET", self::requestParams($this));

        if (!static::getSuccess()) {
            return false;
        }

        if (!empty(static::getResponseUrl())) {
            $this->setAvatarUrl(static::getResponseUrl());
        }

        return $this;
    }

    /**
     * Reset user's avatar
     *
     * @return bool
     */
    public function resetAvatar()
    {
        static::send("users.resetAvatar", "POST", self::requestParams($this));
        return static::getSuccess();
    }

    /**
     * Gets all connected users presence
     *
     * @param string|null $from The last date you got a status change. ISO 8601 datetime. Timezone, milliseconds and seconds are optional
     * @return Collection|false
     */
    public static function presence($from = null)
    {
        static::send("users.presence", "GET", ['from' => $from]);
        if (!static::getSuccess()) {
            return false;
        }

        $users = new Collection();
        $response = static::getResponse();
        foreach ($response->users as $user) {
            $users->add(static::createOutOfResponse($user));
        }
        if (isset($response->full)) {
            $users->setFull($response->full);
        }

        return $users;
    }

    /**
     * Gets a user's presence if the query string userId or username is provided, otherwise it gets the callee's
     *
     * @return false|mixed
     */
    public function getPresence()
    {
        static::send('users.getPresence', 'GET', self::requestParams($this));
        if (!static::getSuccess()) {
            return false;
        }

        $response = static::getResponse();
        $result = new \stdClass();
        $result->presence = $response->presence;

        if (isset($response->connectionStatus)) {
            $result->connectionStatus = $response->connectionStatus;
        }
        if (isset($response->lastLogin)) {
            $result->lastLogin = $response->lastLogin;
        }

        return $result;
    }

    /**
     * Deactivate Idle users. Requires `edit-other-user-active-status` permission.
     *
     * @param int $daysIdle
     * @param string $role
     * @return int|false
     */
    public static function deactivateIdle($daysIdle, $role = 'user')
    {
        static::send("users.deactivateIdle", "POST", ['daysIdle' => $daysIdle, 'role' => $role]);
        if (!static::getSuccess()) {
            return false;
        }

        return static::getResponse()->count;
    }

    /**
     * Send email to reset your password.
     *
     * @param string $email
     * @return bool|string
     */
    public static function forgotPassword($email)
    {
        static::send("users.forgotPassword", "POST", ['email' => $email]);
        return static::getSuccess();
    }

    /**
     * Gets a user's Status if the query string userId or username is provided, otherwise it gets the callee's.
     *
     * @return false|User
     */
    public function getStatus()
    {
        static::send('users.getStatus', 'GET', self::requestParams($this));
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse());
    }

    /**
     * Sets a user status when the status message and state is given
     *
     * @param $message
     * @param null $status
     * @return $this|false
     */
    public function setStatus($message, $status = null)
    {
        $params = ['message' => $message];
        if (isset($status) && is_string($status)) {
            $params['status'] = $status;
        }
        static::send("users.setStatus", "POST", $params);

        if (!static::getSuccess()) {
            return false;
        }

        $this->setStatusText($params['message']);
        if (isset($params['status'])) {
            $this->setStatusValue($params['status']);
        }

        return $this;
    }

    /**
     * Sets user active status
     *
     * @param bool $activeStatus
     * @return User|false
     */
    public function setActiveStatus($activeStatus)
    {
        static::send(
            "users.setActiveStatus",
            "POST",
            ['activeStatus' => $activeStatus, 'userId' => $this->getUserId()]
        );
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->user);
    }

    /**
     * Gets a suggestion a new username to user
     *
     * @return string|null|false
     */
    public static function getUsernameSuggestion()
    {
        static::send("users.getUsernameSuggestion", "GET");
        if (!static::getSuccess()) {
            return false;
        }

        return isset(static::getResponse()->result) ? static::getResponse()->result : null;
    }

    /**
     * Create a user authentication token. This is the same type of session token a user would get via login and
     * will expire the same way. Requires `user-generate-access-token` permission.
     *
     * @return \stdClass|null|false
     */
    public function createToken()
    {
        static::send('users.createToken', 'POST', self::requestParams($this));
        if (!static::getSuccess()) {
            return false;
        }

        return isset(static::getResponse()->data) ? static::getResponse()->data : null;
    }

    /**
     * Gets the user’s personal access tokens. Requires `create-personal-access-tokens` permission
     *
     * @return array|null|false
     */
    public static function getPersonalAccessTokens()
    {
        static::send("users.getPersonalAccessTokens", "GET");
        if (!static::getSuccess()) {
            return false;
        }

        return isset(static::getResponse()->tokens) ? static::getResponse()->tokens : null;
    }

    /**
     * Generate Personal Access Token. Requires `create-personal-access-tokens` permission.
     *
     * @param string $tokenName
     * @param bool $bypassTwoFactor
     * @return string|null|false
     */
    public static function generatePersonalAccessToken($tokenName, $bypassTwoFactor = false)
    {
        static::send("users.generatePersonalAccessToken", "POST", ['tokenName' => $tokenName, 'bypassTwoFactor' => $bypassTwoFactor]);
        if (!static::getSuccess()) {
            return false;
        }

        return isset(static::getResponse()->token) ? static::getResponse()->token : null;
    }

    /**
     * Regenerate a user personal access token. Requires `create-personal-access-tokens` permission
     *
     * @param string $tokenName
     * @return string|null|false
     */
    public static function regeneratePersonalAccessToken($tokenName)
    {
        static::send("users.regeneratePersonalAccessToken", "POST", ['tokenName' => $tokenName]);
        if (!static::getSuccess()) {
            return false;
        }

        return isset(static::getResponse()->token) ? static::getResponse()->token : null;
    }

    /**
     * Remove a personal access token. Requires `create-personal-access-tokens` permission.
     *
     * @param string $tokenName
     * @return bool
     */
    public static function removePersonalAccessToken($tokenName)
    {
        static::send("users.removePersonalAccessToken", "POST", ['tokenName' => $tokenName]);
        return static::getSuccess();
    }

    /**
     * Removes other access tokens
     *
     * @return bool
     */
    public static function removeOtherTokens()
    {
        static::send("users.removeOtherTokens", "POST");
        return static::getSuccess();
    }

    /**
     * Request the user's data for download
     *
     * @param bool $fullExport If needs a full export
     * @return false|mixed
     */
    public static function requestDataDownload($fullExport = false)
    {
        static::send("users.requestDataDownload", "GET", ['fullExport' => $fullExport]);
        if (!static::getSuccess()) {
            return false;
        }
        return static::getResponse()->exportOperation;
    }

    /**
     * Gets all preferences of the user
     *
     * @return Preferences|false
     */
    public function getPreferences()
    {
        static::send('users.getPreferences', 'GET');
        if (!static::getSuccess()) {
            return false;
        }

        return (new Preferences())->updateOutOfResponse(static::getResponse()->preferences);
    }

    /**
     * Sets user's preferences
     *
     * @param Preferences $preferences
     * @return User|false
     */
    public function setPreferences(Preferences $preferences)
    {
        static::send(
            'users.setPreferences',
            'POST',
            ['userId' => $this->getUserId(), 'data' => $preferences]
        );
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->user);
    }

    /**
     * Prepares request params to have `userId` or `username`
     *
     * @param User|null $user
     * @return array
     */
    private static function requestParams(User $user = null)
    {
        $params = [];
        if (isset($user) && !empty($user->getUserId())) {
            $params = ['userId' => $user->getUserId()];
        } elseif (isset($user) && !empty($user->getUsername())) {
            $params = ['username' => $user->getUsername()];
        }

        return $params;
    }
}
