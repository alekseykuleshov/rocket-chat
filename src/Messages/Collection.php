<?php

namespace ATDev\RocketChat\Messages;

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Messages Collection
 * @package ATDev\RocketChat\Messages
 */
class Collection extends ArrayCollection {
    /**
     * @param Message $element
     * @return bool|true
     */
    public function add($element) {
        if (!($element instanceof Message)) {
            return false;
        }
        return parent::add($element);
    }
}