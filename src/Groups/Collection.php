<?php

namespace ATDev\RocketChat\Groups;

/**
 * Group collection class
 */
class Collection extends \ATDev\RocketChat\Common\Collection
{

    /**
     * @param Group $element
     * @return bool|true
     */
    public function add($element)
    {
        if (!($element instanceof Group)) {
            return false;
        }

        return parent::add($element);
    }
}
