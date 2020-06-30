<?php

namespace ATDev\RocketChat\Ims;

use ATDev\RocketChat\Common\Request;
use ATDev\RocketChat\Ims\ImCounters;
use ATDev\RocketChat\Messages\Message;

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

        foreach ($response->ims as $im) {
            $ims->add(static::createOutOfResponse($im));
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
     * @return \ATDev\RocketChat\Ims\ImCounters|boolean
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

        return (new ImCounters)->updateOutOfResponse(static::getResponse());
    }

    /**
     * Retrieves the messages from a direct message
     *
     * @param int $offset
     * @param int $count
     * @return \ATDev\RocketChat\Messages\Collection|bool
     */
    public function history($offset = 0, $count = 0)
    {
        static::send(
            "im.history",
            "GET",
            [
                "roomId" => $this->getDirectMessageId(), "offset" => $offset, "count" => $count,
                "latest" => $this->getLatest(), "oldest" => $this->getOldest(), "inclusive" => $this->getInclusive(),
                "unreads" => $this->getUnreads()
            ]
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

    public function listEveryone($offset = 0, $count = 0)
    {
        static::send("im.list.everyone", "GET", ['offset' => $offset, 'count' => $count]);

        if (!static::getSuccess()) {
            return false;
        }

        $ims = new Collection();
        $response = static::getResponse();

        foreach ($response->ims as $im) {
            $ims->add(static::createOutOfResponse($im));
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
}