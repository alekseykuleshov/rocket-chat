<?php

namespace ATDev\RocketChat\Invites;

/**
 * Invite collection class
 */
class Collection extends \ATDev\RocketChat\Common\Collection
{

    /**
     * @param Invite $element
     * @return bool|true
     */
    public function add($element)
    {
        if (!($element instanceof Invite)) {
            return false;
        }

        return parent::add($element);
    }
}
