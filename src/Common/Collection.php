<?php

namespace ATDev\RocketChat\Common;

use \Doctrine\Common\Collections\ArrayCollection;

class Collection extends ArrayCollection {
    /** @var int */
    private $total;
    /** @var int */
    private $count;
    /** @var int */
    private $offset;

    /**
     * @return int
     */
    public function getTotal() {
        return $this->total;
    }

    /**
     * @param int $total
     * @return $this
     */
    public function setTotal($total) {
        if (is_int($total)) {
            $this->total = $total;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * @param int $count
     * @return $this
     */
    public function setCount($count) {
        if (is_int($count)) {
            $this->count = $count;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getOffset() {
        return $this->offset;
    }

    /**
     * @param $offset
     * @return $this
     */
    public function setOffset($offset) {
        if (is_int($offset)) {
            $this->offset = $offset;
        }
        return $this;
    }
}