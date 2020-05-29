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
     */
    public function setTotal($total) {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count) {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getOffset() {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset) {
        $this->offset = $offset;
    }
}