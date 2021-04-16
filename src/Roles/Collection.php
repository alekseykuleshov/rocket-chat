<?php

namespace ATDev\RocketChat\Roles;

/**
 * Role collection class
 */
class Collection extends \ATDev\RocketChat\Common\Collection
{

    /**
     * @param Role $element
     * @return bool|true
     */
    public function add($element)
    {
        if (!($element instanceof Role)) {
            return false;
        }

        return parent::add($element);
    }
}
