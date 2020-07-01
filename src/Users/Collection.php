<?php

namespace ATDev\RocketChat\Users;

/**
 * User collection class
 */
class Collection extends \ATDev\RocketChat\Common\Collection
{
    public function add($element)
    {
        if (!($element instanceof User)) {
            return false;
        }

        return parent::add($element);
    }
}
