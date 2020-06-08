<?php

namespace ATDev\RocketChat\Users;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * User collection class
 */
class Collection extends ArrayCollection
{
    public function add($element)
    {
        if (!($element instanceof User)) {
            return false;
        }

        return parent::add($element);
    }
}
