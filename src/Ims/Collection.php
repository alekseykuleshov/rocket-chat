<?php

namespace ATDev\RocketChat\Ims;

/**
 * Im collection class
 */
class Collection extends \ATDev\RocketChat\Common\Collection
{

    /**
     * @param Im $element
     * @return bool|true
     */
    public function add($element)
    {
        if (!($element instanceof Im)) {
            return false;
        }

        return parent::add($element);
    }
}
