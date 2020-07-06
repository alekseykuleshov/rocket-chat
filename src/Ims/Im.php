<?php

namespace ATDev\RocketChat\Ims;

use ATDev\RocketChat\Common\Request;
use ATDev\RocketChat\Messages\Message;
use ATDev\RocketChat\Users\User;

/**
 * Im class
 */
class Im extends Request
{
    use \ATDev\RocketChat\Ims\Data;

    /**
     * Gets direct message listing
     *
     * @param int $offset
     * @param int $count
     * @return Collection|bool
     */
    public static function listing($offset = 0, $count = 0)
    {
        static::send("im.list", "GET", ['offset' => $offset, 'count' => $count]);

        if (!static::getSuccess()) {
            return false;
        }

        $ims = new Collection();
        $response = static::getResponse();

        if (isset($response->ims)) {
            foreach ($response->ims as $im) {
                $ims->add(static::createOutOfResponse($im));
            }
        }
        if (isset($response->total)) {
            $ims->setTotal($response->total);
        }
        if (isset($response->count)) {
            $ims->setCount($response->count);
        }
        if (isset($response->offset)) {
            $ims->setOffset($response->offset);
        }

        return $ims;
    }

    /**
     * Creates direct message session with another user
     *
     * @return \ATDev\RocketChat\Ims\Im|boolean
     */
    public function create()
    {
        static::send("im.create", "POST", $this);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->room);
    }

    /**
     * Adds direct message back to user list of direct messages
     *
     * @return $this|bool
     */
    public function open()
    {
        static::send("im.open", "POST", ["roomId" => $this->getDirectMessageId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Removes direct message from user list of direct messages
     *
     * @return \ATDev\RocketChat\Ims\Im|boolean
     */
    public function close()
    {
        static::send("im.close", "POST", ["roomId" => $this->getDirectMessageId()]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this;
    }

    /**
     * Gets counters of direct messages
     *
     * @return \ATDev\RocketChat\Ims\Counters|boolean
     */
    public function counters()
    {
        static::send(
            "im.counters",
            "GET",
            ["roomId" => $this->getDirectMessageId(), "username" => $this->getUsername()]
        );

        if (!static::getSuccess()) {
            return false;
        }

        return (new Counters())->updateOutOfResponse(static::getResponse());
    }

    /**
     * Retrieves the messages from a direct message
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Messages\Collection|bool
     */
    public function history($options = [])
    {
        $options = array_replace([
            'offset' => 0,
            'count' => 0
        ], $options);

        $options['roomId'] = $this->getDirectMessageId();

        static::send(
            'im.history',
            'GET',
            $options
        );

        if (!static::getSuccess()) {
            return false;
        }

        $response = static::getResponse();
        $messages = new \ATDev\RocketChat\Messages\Collection();

        if (isset($response->messages)) {
            foreach ($response->messages as $message) {
                $messages->add(Message::createOutOfResponse($message));
            }
        }
        if (isset($response->unreadNotLoaded)) {
            $messages->setUnreadNotLoaded($response->unreadNotLoaded);
        }

        return $messages;
    }

    /**
     * Lists all of the direct messages in the server, requires the permission view-room-administration permission.
     *
     * @param int $offset
     * @param int $count
     * @return Collection|bool
     */
    public function listEveryone($offset = 0, $count = 0)
    {
        static::send("im.list.everyone", "GET", ['offset' => $offset, 'count' => $count]);

        if (!static::getSuccess()) {
            return false;
        }

        $ims = new Collection();
        $response = static::getResponse();
        if (isset($response->ims)) {
            foreach ($response->ims as $im) {
                $ims->add(static::createOutOfResponse($im));
            }
        }
        if (isset($response->total)) {
            $ims->setTotal($response->total);
        }
        if (isset($response->count)) {
            $ims->setCount($response->count);
        }
        if (isset($response->offset)) {
            $ims->setOffset($response->offset);
        }

        return $ims;
    }

    /**
     * Lists the users of participants of a direct message
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Users\Collection|bool
     */
    public function members($offset = 0, $count = 0)
    {
        static::send(
            'im.members',
            'GET',
            [
                'offset' => $offset, 'count' => $count,
                'roomId' => $this->getDirectMessageId(), 'username' => $this->getUsername()
            ]
        );

        if (!static::getSuccess()) {
            return false;
        }

        $members = new \ATDev\RocketChat\Users\Collection();
        $response = static::getResponse();
        if (isset($response->members)) {
            foreach ($response->members as $member) {
                $members->add(User::createOutOfResponse($member));
            }
        }
        if (isset($response->total)) {
            $members->setTotal($response->total);
        }
        if (isset($response->count)) {
            $members->setCount($response->count);
        }
        if (isset($response->offset)) {
            $members->setOffset($response->offset);
        }

        return $members;
    }

    /**
     * Retrieves the messages from any direct message in the server
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Messages\Collection|bool
     */
    public function messagesOthers($offset = 0, $count = 0)
    {
        static::send(
            'im.messages.others',
            'GET',
            ['offset' => $offset, 'count' => $count, 'roomId' => $this->getDirectMessageId()]
        );

        if (!static::getSuccess()) {
            return false;
        }

        $messages = new \ATDev\RocketChat\Messages\Collection();
        $response = static::getResponse();

        if (isset($response->messages)) {
            foreach ($response->messages as $message) {
                $messages->add(Message::createOutOfResponse($message));
            }
        }
        if (isset($response->total)) {
            $messages->setTotal($response->total);
        }
        if (isset($response->count)) {
            $messages->setCount($response->count);
        }
        if (isset($response->offset)) {
            $messages->setOffset($response->offset);
        }

        return $messages;
    }

    /**
     * Lists all of the specific direct message on the server
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Messages\Collection|bool
     */
    public function messages($offset = 0, $count = 0)
    {
        static::send(
            'im.messages',
            'GET',
            [
                'offset' => $offset, 'count' => $count,
                'roomId' => $this->getDirectMessageId(), 'username' => $this->getUsername()
            ]
        );

        if (!static::getSuccess()) {
            return false;
        }

        $messages = new \ATDev\RocketChat\Messages\Collection();
        $response = static::getResponse();

        if (isset($response->messages)) {
            foreach ($response->messages as $message) {
                $messages->add(Message::createOutOfResponse($message));
            }
        }
        if (isset($response->total)) {
            $messages->setTotal($response->total);
        }
        if (isset($response->count)) {
            $messages->setCount($response->count);
        }
        if (isset($response->offset)) {
            $messages->setOffset($response->offset);
        }

        return $messages;
    }

    /**
     * Sets the topic for the direct message
     *
     * @return $this|bool
     */
    public function setTopic($message)
    {
        static::send('im.setTopic', 'POST', ['roomId' => $this->getDirectMessageId(), 'topic' => $message]);

        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse());
    }

    /**
     * @param int $offset
     * @param int $count
     */
    public function files($offset = 0, $count = 0)
    {
        // TODO implement method
    }
}
