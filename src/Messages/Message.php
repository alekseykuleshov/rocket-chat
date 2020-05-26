<?php namespace ATDev\RocketChat\Messages;

use ATDev\RocketChat\Channels\Channel;
use ATDev\RocketChat\Common\Request;
use ATDev\RocketChat\Groups\Group;

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
    public function getMessage() {
        static::send('chat.getMessage', 'GET', ['msgId' => $this->getMessageId()]);
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->message);
    }

    /**
     * @todo if $room should be instance of Room (abstract)
     * @param Channel|Group $room
     * @return Message|bool
     */
    public function postMessage($room) {
        if (!($room instanceof Channel) && !($room instanceof Group)) {
            static::setError('Invalid room type');
            return false;
        }
        static::send('chat.postMessage', 'POST', $this->setRoomId($room->getChannelId()));
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->message);
    }

    /**
     * Updates chat message
     * @return Message|bool
     */
    public function update() {
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
    public function delete($asUser = false) {
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
