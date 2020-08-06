<?php

namespace ATDev\RocketChat\Files;

class Collection extends \ATDev\RocketChat\Common\Collection
{
    /**
     * @param File $element
     * @return bool|true
     */
    public function add($element)
    {
        if (!($element instanceof File)) {
            return false;
        }

        return parent::add($element);
    }
}
