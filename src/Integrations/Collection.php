<?php

namespace ATDev\RocketChat\Integrations;

/**
 * Integration collection class
 */
class Collection extends \ATDev\RocketChat\Common\Collection
{

    /**
     * @param Integration $element
     * @return bool|true
     */
    public function add($element)
    {
        if (!($element instanceof Integration)) {
            return false;
        }

        return parent::add($element);
    }
}
