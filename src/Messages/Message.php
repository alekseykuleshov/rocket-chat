<?php

namespace ATDev\RocketChat\Messages;

use ATDev\RocketChat\Common\Request;

/**
 * Class Message
 * @package ATDev\RocketChat\Messages
 */
class Message extends Request
{
    use Data;

    /**
     * Gets a single chat message
     * @return Message|bool
     */
    public function getMessage()
    {
        static::send('chat.getMessage', 'GET', ['msgId' => $this->getMessageId()]);
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->message);
    }

    /**
     * @return Message|bool
     */
    public function postMessage()
    {
        static::send('chat.postMessage', 'POST', $this);
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->message);
    }

    /**
     * Updates chat message
     * @return Message|bool
     */
    public function update()
    {
        static::send(
            'chat.update',
            'POST',
            ['roomId' => $this->getRoomId(), 'msgId' => $this->getMessageId(), 'text' => $this->getMsg()]
        );
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->message);
    }

    /**
     * Deletes chat message
     * @param bool $asUser Whether the message should be deleted as the user who sent it
     * @return Message|bool
     */
    public function delete($asUser = false)
    {
        static::send(
            'chat.delete',
            'POST',
            ['roomId' => $this->getRoomId(), 'msgId' => $this->getMessageId(), 'asUser' => $asUser]
        );
        if (!static::getSuccess()) {
            return false;
        }

        return $this->setMessageId(null);
    }
}
