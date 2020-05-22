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
     * @param Channel|Group $room
     * @return Message|bool
     */
    public function postMessage($room) {
        if (!($room instanceof Channel) && !($room instanceof Group)) {
            static::setError('Invalid room type');
            return false;
        }
        static::send("chat.postMessage", "POST", $this->setRoomId($room->getChannelId()));
        if (!static::getSuccess()) {
            return false;
        }

        return $this->updateOutOfResponse(static::getResponse()->message);
    }
}
