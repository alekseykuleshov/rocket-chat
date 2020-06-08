<?php

namespace ATDev\RocketChat\Channels;

/**
 * Channel collection class
 */
class Collection extends \ATDev\RocketChat\Common\Collection
{

    /**
     * @param Channel $element
     * @return bool|true
     */
    public function add($element)
    {
        if (!($element instanceof Channel)) {
            return false;
        }

        return parent::add($element);
    }
}
