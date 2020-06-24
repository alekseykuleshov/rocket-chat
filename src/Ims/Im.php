<?php

namespace ATDev\RocketChat\Ims;

use ATDev\RocketChat\Common\Request;

/**
 * Im class
 */
class Im extends Request
{
    use \ATDev\RocketChat\Ims\Data;

    /**
     * Gets im listing
     *
     * @param int $offset
     * @param int $count
     * @return Collection|bool
     */
    public static function listing($offset = 0, $count = 0)
    {
        static::send("im.list", "GET", ['offset' => $offset, 'count' => $count]);

        if (!static::getSuccess()) {
            return false;
        }

        $ims = new Collection();
        $response = static::getResponse();

        foreach ($response->ims as $im) {
            $ims->add(static::createOutOfResponse($im));
        }
        if (isset($response->total)) {
            $ims->setTotal($response->total);
        }
        if (isset($response->count)) {
            $ims->setCount($response->count);
        }
        if (isset($response->offset)) {
            $ims->setOffset($response->offset);
        }

        return $ims;
    }
}