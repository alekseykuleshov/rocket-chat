<?php namespace ATDev\RocketChat\Channels;

use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Channel collection class
 */
class Collection extends ArrayCollection {

	public function add($element) {

		if (!($element instanceof Channel)) {

			return false;
		}

		return parent::add($element);
	}
}