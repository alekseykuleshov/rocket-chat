<?php

namespace ATDev\RocketChat\Units;

/**
 * Unit data trait
 */
trait Data
{
	/** @var string Unit id */
	private $unitId;
	
	/* Required properties for creation */
	/** @var string Unit name */
	private $name;
	/** @var string Indicates unit visibility */
	private $visibility;
	/** @var array Departments in the unit */
	private $departments;
	/** @var array Monitors in the unit */
	private $monitors;
	
	/* Readonly properties returned from api */
	/** @var string Date-time unit created at api */
	private $updatedAt;
	
	/**
	 * Creates Unit out of api response
	 *
	 * @param \stdClass $response
	 *
	 * @return \ATDev\RocketChat\Units\Data
	 */
	public static function createOutOfResponse($response)
	{
		$unit = new static($response->_id);
		return $unit->updateOutOfResponse($response);
	}
	
	/**
	 * Updates current unit out of api response
	 *
	 * @param \stdClass $response
	 *
	 * @return \ATDev\RocketChat\Units\Data
	 */
	public function updateOutOfResponse($response)
	{
		if (isset($response->_id)) {
			$this->setUnitId($response->_id);
		}
		
		if (isset($response->name)) {
			$this->setName($response->name);
		}
		
		if (isset($response->visibility)) {
			$this->setVisibility($response->visibility);
		}
		
		if (isset($response->departments)) {
			$this->setDepartments($response->departments);
		}
		
		if (isset($response->monitors)) {
			$this->setMonitors($response->monitors);
		}
		
		if (isset($response->_updatedAt)) {
			$this->setUpdatedAt($response->_updatedAt);
		}
		
		return $this;
	}
	
	/**
	 * Gets unit data to submit to api
	 *
	 * @return array
	 */
	public function jsonSerialize()
	{
		$data = ['unitData' => [], 'unitDepartments' => [], 'unitMonitors' => []];
		$data['unitData'] = [
			"name" => $this->getName(),
			"visibility" => $this->getVisibility(),
		];
		
		if(!is_null($this->departments))
			foreach($this->departments as $department)
			$data['unitDepartments'][] = ['departmentId' => $department->getDepartmentId()];
		
		if(!is_null($this->monitors))
			foreach($this->monitors as $monitor)
			$data['unitMonitors'][] = ['monitorId' => $monitor->getUserId(), 'username' => $monitor->getUsername()];
		
		return $data;
	}
	
	/**
	 * Class constructor
	 *
	 * @param string|null $unitId
	 */
	public function __construct($unitId = null)
	{
		if (!empty($unitId)) {
			$this->setUnitId($unitId);
		}
	}
	
	/**
	 * Sets unit id
	 *
	 * @param string $unitId
	 *
	 * @return $unitId
	 */
	public function setUnitId($unitId)
	{
		return $this->unitId = $unitId;
	}
	
	/**
	 * Gets unit id
	 *
	 * @return string
	 */
	public function getUnitId()
	{
		return $this->unitId;
	}
	
	/**
	 * Sets unit name
	 *
	 * @param string $name
	 *
	 * @return \ATDev\RocketChat\Units\Data
	 */
	public function setName($name)
	{
		if (!(is_null($name) || is_string($name))) {
			$this->setDataError("Invalid name");
		} else {
			$this->name = $name;
		}
		
		return $this;
	}
	
	/**
	 * Gets unit name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Sets unit visibility
	 *
	 * @param string $visibility
	 *
	 * @return \ATDev\RocketChat\Units\Data
	 */
	public function setVisibility($visibility)
	{
		if (!(is_null($visibility) || is_string($visibility))) {
			$this->setDataError("Invalid visibility value");
		} else {
			$this->visibility = $visibility;
		}
		
		return $this;
	}
	
	/**
	 * Gets unit visibility
	 *
	 * @return string
	 */
	public function getVisibility()
	{
		return $this->visibility;
	}
	
	/**
	 * Sets unit departments
	 *
	 * @param array $departments
	 *
	 * @return \ATDev\RocketChat\Units\Data
	 */
	public function setDepartments($departments)
	{
		if (!(is_null($departments) || is_array($departments))) {
			$this->setDataError("Invalid departments value");
		} else {
			$this->departments = $departments;
		}
		
		return $this;
	}
	
	/**
	 * Gets unit departments
	 *
	 * @return array
	 */
	public function getDepartments()
	{
		return $this->departments;
	}
	
	/**
	 * Sets unit monitors
	 *
	 * @param array $monitors
	 *
	 * @return \ATDev\RocketChat\Units\Data
	 */
	public function setMonitors($monitors)
	{
		if (!(is_null($monitors) || is_array($monitors))) {
			$this->setDataError("Invalid monitors value");
		} else {
			$this->monitors = $monitors;
		}
		
		return $this;
	}
	
	/**
	 * Gets unit monitors
	 *
	 * @return array
	 */
	public function getMonitors()
	{
		return $this->monitors;
	}
	
	/**
	 * Sets the date-time unit updated at api
	 *
	 * @param string $updatedAt
	 *
	 * @return \ATDev\RocketChat\Units\Data
	 */
	private function setUpdatedAt($updatedAt)
	{
		if (is_string($updatedAt)) {
			$this->updatedAt = $updatedAt;
		}
		
		return $this;
	}
	
	/**
	 * Gets the date-time unit update at api
	 *
	 * @return string
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * Sets data error
	 *
	 * @param string $error
	 *
	 * @return \ATDev\RocketChat\Units\Data
	 */
	private function setDataError($error)
	{
		static::setError($error);
		return $this;
	}
}
