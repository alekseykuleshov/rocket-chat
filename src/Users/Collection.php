<?php

namespace ATDev\RocketChat\Users;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * User collection class
 */
class Collection extends ArrayCollection
{
    /** @var bool */
    private $full;

    public function add($element)
    {
        if (!($element instanceof User)) {
            return false;
        }

        return parent::add($element);
    }

    /**
     * @return bool
     */
    public function isFull()
    {
        return $this->full;
    }

    /**
     * @param bool $full
     * @return $this
     */
    public function setFull($full)
    {
        if (is_bool($full)) {
            $this->full = $full;
        }
        return $this;
    }
}
