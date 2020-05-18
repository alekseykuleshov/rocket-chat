<?php namespace ATDev\RocketChat\Groups;

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Group collection class
 */
class Collection extends ArrayCollection {

	public function add($element) {

		if (!($element instanceof Group)) {

			return false;
		}

		return parent::add($element);
	}
}