<?php
	namespace ATDev\RocketChat\Departments;
	
	use ATDev\RocketChat\Common\Request;
	use ATDev\RocketChat\Common\Collection;
	
	/**
	 * Department class
	 */
	class Department extends Request
	{
		use Data;
		
		/**
		 * Gets department listing
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
			
			static::send("livechat/department", "GET", $parameters);
			if (!static::getSuccess()) {
				return false;
			}
			
			$departments = new Collection();
			$response = static::getResponse();
			if (isset($response->departments)) {
				foreach ($response->departments as $department) {
					$departments->add(static::createOutOfResponse($department));
				}
			}
			if (isset($response->total)) {
				$departments->setTotal($response->total);
			}
			if (isset($response->count)) {
				$departments->setCount($response->count);
			}
			if (isset($response->offset)) {
				$departments->setOffset($response->offset);
			}
			
			return $departments;
		}
		
		/**
		 * Creates department at api instance
		 *
		 * @return Department|boolean
		 */
		public function create()
		{
			static::send("livechat/department", "POST", $this);
			
			if (!static::getSuccess()) {
				return false;
			}
			
			return $this->updateOutOfResponse(static::getResponse()->department);
		}
		
		/**
		 * Gets extended department info
		 *
		 * @return boolean|$this
		 */
		public function info()
		{
			if(is_null($this->getDepartmentId()))
				static::send("livechat/department?text=".rawurlencode($this->getName()), "GET");
			else
				static::send("livechat/department/".$this->getDepartmentId(), "GET");
			
			if(!static::getSuccess())
				return false;
			
			$response = static::getResponse();
			
			$department = null;
			if(is_null($this->getDepartmentId()))
			{
				foreach($response->departments as $d)
					if($d->name == $this->getName())
					{
						$department = $d;
						break;
					}
				if(is_null($department))
					return false;
			}
			else
				$department = $response->department;
			
			return $this->updateOutOfResponse($department);
		}
		
		/**
		 * Deletes department
		 *
		 * @return boolean|$this
		 */
		public function delete()
		{
			static::send("livechat/department/".$this->getDepartmentId(), "DELETE");
			
			if (!static::getSuccess()) {
				return false;
			}
			
			return $this->setDepartmentId(null);
		}
		
		/**
		 * Lists the agents of the department
		 *
		 * @param int $offset
		 * @param int $count
		 * @return \ATDev\RocketChat\Users\Collection|false
		 */
		public function agents($offset = 0, $count = 0)
		{
			$departmentId = $this->getDepartmentId();
			if(is_null($departmentId))
				return false;
			
			static::send(
				"livechat/department/$departmentId/agents",
				'GET',
				['offset' => $offset, 'count' => $count]
			);
			if (!static::getSuccess()) {
				return false;
			}
			
			$agents = new \ATDev\RocketChat\Users\Collection();
			$response = static::getResponse();
			if (isset($response->agents)) {
				foreach ($response->agents as $agent) {
					$user = new \ATDev\RocketChat\Users\User($agent->agentId);
					$user = $user->info();
					if($user)
						$agents->add($user);
				}
			}
			if (isset($response->total)) {
				$agents->setTotal($response->total);
			}
			if (isset($response->count)) {
				$agents->setCount($response->count);
			}
			if (isset($response->offset)) {
				$agents->setOffset($response->offset);
			}
			
			return $agents;
		}
		
		/**
		 * Lists agent departments
		 *
		 * @param User $user
		 * @param int $offset
		 * @param int $count
		 * @return \ATDev\RocketChat\Departments\Collection|false
		 */
		public static function getAgentDepartments($user)
		{
			$agentId = $user->getUserId();
			if(is_null($agentId))
				return false;
			
			static::send(
				"livechat/agents/$agentId/departments",
				'GET'
			);
			if (!static::getSuccess()) {
				return false;
			}
			
			$departments = new \ATDev\RocketChat\Departments\Collection();
			$response = static::getResponse();
			if (isset($response->departments)) {
				foreach ($response->departments as $d) {
					$department = new \ATDev\RocketChat\Departments\Department($d->departmentId);
					$department = $department->info();
					if($department)
						$departments->add($department);
				}
			}
			if (isset($response->total)) {
				$departments->setTotal($response->total);
			}
			if (isset($response->count)) {
				$departments->setCount($response->count);
			}
			if (isset($response->offset)) {
				$departments->setOffset($response->offset);
			}
			
			return $departments;
		}
		
		/**
		 * Adds user to a department
		 *
		 * @param User $user
		 * @return $this|false
		 */
		public function addAgent($user)
		{
			$departmentId = $this->getDepartmentId();
			if(is_null($departmentId))
				return false;
			
			static::send(
				"livechat/department/$departmentId/agents",
				'POST',
				[
					'upsert' => [['agentId' => $user->getUserId(), 'username' => $user->getUsername()]],
					'remove' => [],
				]
			);
			
			if (!static::getSuccess()) {
				return false;
			}
			
			return $this;
		}
		
		/**
		 * Removes user from a department
		 *
		 * @param User $user
		 * @return $this|false
		 */
		public function removeAgent($user)
		{
			$departmentId = $this->getDepartmentId();
			if(is_null($departmentId))
				return false;
			
			static::send(
				"livechat/department/$departmentId/agents",
				'POST',
				[
					'upsert' => [],
					'remove' => [['agentId' => $user->getUserId(), 'username' => $user->getUsername()]],
				]
			);
			
			if (!static::getSuccess()) {
				return false;
			}
			
			return $this;
		}
	}
