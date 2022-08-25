<?php
	namespace ATDev\RocketChat\Units;
	
	use ATDev\RocketChat\Common\Request;
	use ATDev\RocketChat\Common\Collection;
	
	/**
	 * Unit class
	 */
	class Unit extends Request
	{
		use Data;
		
		/**
		 * Gets unit listing
		 *
		 * @return Collection|boolean
		 */
		public static function listing($offset = null, $count = null)
		{
			$parameters = [];
			if (!is_null($offset)) {
				$parameters['offset'] = $offset;
			}
			if (!is_null($count)) {
				$parameters['count'] = $count;
			}
			
			static::send("livechat/units", "GET", $parameters);
			if (!static::getSuccess()) {
				return false;
			}
			
			$units = new Collection();
			$response = static::getResponse();
			if (isset($response->units)) {
				foreach ($response->units as $unit) {
					$units->add(static::createOutOfResponse($unit));
				}
			}
			if (isset($response->total)) {
				$units->setTotal($response->total);
			}
			if (isset($response->count)) {
				$units->setCount($response->count);
			}
			if (isset($response->offset)) {
				$units->setOffset($response->offset);
			}
			
			return $units;
		}
		
		/**
		 * Creates unit at api instance
		 *
		 * @return Unit|boolean
		 */
		public function create()
		{
			static::send("livechat/units", "POST", $this);
			
			if (!static::getSuccess()) {
				return false;
			}
			
			return $this->updateOutOfResponse(static::getResponse());
		}
		
		/**
		 * Gets extended unit info
		 *
		 * @return boolean|$this
		 */
		public function info()
		{
			static::send("livechat/units.getOne", "GET", ['unitId' => $user->getUnitId()]);
			
			if(!static::getSuccess())
				return false;
			
			return $this->updateOutOfResponse(static::getResponse());
		}
		
		/**
		 * Deletes unit
		 *
		 * @return boolean|$this
		 */
		public function delete()
		{
			static::send("livechat/units/".$this->getUnitId(), "DELETE");
			
			if (!static::getSuccess()) {
				return false;
			}
			
			return $this->setUnitId(null);
		}
		
		/**
		 * Lists the monitors of the unit
		 *
		 * @param int $offset
		 * @param int $count
		 * @return \ATDev\RocketChat\Users\Collection|false
		 */
		public function monitors($offset = 0, $count = 0)
		{
			$unitId = $this->getUnitId();
			if(is_null($unitId))
				return false;
			
			static::send(
				"livechat/unitMonitors.list",
				'GET',
				array_merge(self::requestParams($this), ['offset' => $offset, 'count' => $count])
			);
			if (!static::getSuccess()) {
				return false;
			}
			
			$monitors = new \ATDev\RocketChat\Users\Collection();
			$response = static::getResponse();
			if (isset($response->monitors)) {
				foreach ($response->monitors as $monitor) {
					$user = new \ATDev\RocketChat\Users\User($monitor->_id);
					$user = $user->info();
					if($user)
						$monitors->add($user);
				}
			}
			if (isset($response->total)) {
				$monitors->setTotal($response->total);
			}
			if (isset($response->count)) {
				$monitors->setCount($response->count);
			}
			if (isset($response->offset)) {
				$monitors->setOffset($response->offset);
			}
			
			return $monitors;
		}

		/**
		 * Prepares request params
		 *
		 * @param Unit|null $unit
		 * @return array
		 */
		private static function requestParams(Unit $unit = null)
		{
			$params = [];
			if (isset($unit) && !empty($unit->getUnitId())) {
				$params = ['unitId' => $unit->getUnitId()];
			}

			return $params;
		}
	}
