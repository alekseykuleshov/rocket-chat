<?php

namespace ATDev\RocketChat\Messages;

/**
 * Messages Collection
 * @package ATDev\RocketChat\Messages
 */
class Collection extends \ATDev\RocketChat\Common\Collection
{
    /**
     * @param Message $element
     * @return bool|true
     */
    public function add($element)
    {
        if (!($element instanceof Message)) {
            return false;
        }
        return parent::add($element);
    }
}
