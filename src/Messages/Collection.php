<?php

namespace ATDev\RocketChat\Messages;

/**
 * Messages Collection
 * @package ATDev\RocketChat\Messages
 */
class Collection extends \ATDev\RocketChat\Common\Collection
{

    /** @var int */
    private $unreadNotLoaded;

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

    /**
     * @return int
     */
    public function getUnreadNotLoaded()
    {
        return $this->unreadNotLoaded;
    }

    /**
     * @param $unreadNotLoaded
     * @return $this
     */
    public function setUnreadNotLoaded($unreadNotLoaded)
    {
        if (is_int($unreadNotLoaded)) {
            $this->unreadNotLoaded = $unreadNotLoaded;
        }
        return $this;
    }
}
