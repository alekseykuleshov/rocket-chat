<?php
	
	namespace ATDev\RocketChat\Units;
	
	/**
	 * Unit collection class
	 */
	class Collection extends \ATDev\RocketChat\Common\Collection
	{
		/** @var bool indicates it's a partial result */
		private $full;
		
		public function add($element)
		{
			if (!($element instanceof Unit)) {
				return false;
			}
			
			return parent::add($element);
		}
		
		/**
		 * @return bool
		 */
		public function isFull()
		{
			return $this->full;
		}
		
		/**
		 * @param bool $full
		 * @return $this
		 */
		public function setFull($full)
		{
			if (is_bool($full)) {
				$this->full = $full;
			}
			return $this;
		}
	}
