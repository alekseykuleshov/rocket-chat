<?php

namespace ATDev\RocketChat\Common;

use Doctrine\Common\Collections\ArrayCollection;

class Collection extends ArrayCollection
{
    /** @var int */
    private $total;
    /** @var int */
    private $count;
    /** @var int */
    private $offset;
    /** @var int */
    private $unreadNotLoaded;

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     * @return $this
     */
    public function setTotal($total)
    {
        if (is_int($total)) {
            $this->total = $total;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return $this
     */
    public function setCount($count)
    {
        if (is_int($count)) {
            $this->count = $count;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param $offset
     * @return $this
     */
    public function setOffset($offset)
    {
        if (is_int($offset)) {
            $this->offset = $offset;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getUnreadNotLoaded()
    {
        return $this->unreadNotLoaded;
    }

    /**
     * @param $unreadNotLoaded
     * @return $this
     */
    public function setUnreadNotLoaded($unreadNotLoaded)
    {
        if (is_int($unreadNotLoaded)) {
            $this->unreadNotLoaded = $unreadNotLoaded;
        }
        return $this;
    }
}
