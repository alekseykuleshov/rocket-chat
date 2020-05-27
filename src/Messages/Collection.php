<?php

namespace ATDev\RocketChat\Messages;

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Messages Collection
 * @package ATDev\RocketChat\Messages
 */
class Collection extends ArrayCollection {
    /**
     * @param Message $message
     * @return bool|true
     */
    public function add($message) {
        if (!($message instanceof Message)) {
            return false;
        }
        return parent::add($message);
    }
}