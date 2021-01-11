<?php

namespace ATDev\RocketChat\RoomRoles;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Collection of users and its roles per room
 * @package ATDev\RocketChat\RoomRoles
 */
class Collection extends ArrayCollection
{
    /**
     * @param RoomRole $element
     * @return bool|true
     */
    public function add($element)
    {
        if (!($element instanceof RoomRole)) {
            return false;
        }

        return parent::add($element);
    }
}
