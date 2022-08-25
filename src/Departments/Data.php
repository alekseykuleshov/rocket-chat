<?php

namespace ATDev\RocketChat\Departments;

/**
 * Department data trait
 */
trait Data
{
	/** @var string Department id */
	private $departmentId;
	
	/* Required properties for creation */
	/** @var string Department name */
	private $name;
	/** @var string Email */
	private $email;
	/** @var boolean Indicates if department is enabled */
	private $enabled;
	/** @var boolean Indicates if department is shown on registration page */
	private $showOnRegistration;
	/** @var boolean Indicates if department is shown on offile form */
	private $showOnOfflineForm;
	/** @var array Agents in the department */
	private $agents;
	
	/* Optional properties for creation */
	/** @var string Department description */
	private $description;
	
	/* Readonly properties returned from api */
	/** @var string Date-time department created at api */
	private $updatedAt;
	
	/**
	 * Creates department out of api response
	 *
	 * @param \stdClass $response
	 *
	 * @return \ATDev\RocketChat\Departments\Data
	 */
	public static function createOutOfResponse($response)
	{
		$department = new static($response->_id);
		return $department->updateOutOfResponse($response);
	}
	
	/**
	 * Updates current department out of api response
	 *
	 * @param \stdClass $response
	 *
	 * @return \ATDev\RocketChat\Departments\Data
	 */
	public function updateOutOfResponse($response)
	{
		if (isset($response->_id)) {
			$this->setDepartmentId($response->_id);
		}
		
		if (isset($response->email)) {
			$this->setEmail($response->email);
		}
		
		if (isset($response->_updatedAt)) {
			$this->setUpdatedAt($response->_updatedAt);
		}
		
		if (isset($response->enabled)) {
			$this->setEnabled($response->enabled);
		}
		
		if (isset($response->name)) {
			$this->setName($response->name);
		}
		
		if (isset($response->description)) {
			$this->setDescription($response->description);
		}
		
		if (isset($response->showOnRegistration)) {
			$this->setShowOnRegistration($response->showOnRegistration);
		}
		
		if (isset($response->showOnOfflineForm)) {
			$this->setShowOnRegistration($response->showOnOfflineForm);
		}
		
		if (isset($response->agents)) {
			$this->setAgents($response->agents);
		}
		
		return $this;
	}
	
	/**
	 * Gets department data to submit to api
	 *
	 * @return array
	 */
	public function jsonSerialize()
	{
		$departmentData = ['department' => [], 'agents' => []];
		$departmentData['department'] = [
			"name" => $this->name,
			"email" => $this->email,
			"enabled" => $this->enabled,
			"showOnRegistration" => $this->showOnRegistration,
			"showOnOfflineForm" => $this->showOnOfflineForm,
		];
		
		if (!is_null($this->description)) {
			$departmentData['department']["description"] = $this->description;
		}
		
		if (!is_null($this->agents)) {
			foreach($this->agents as $agent)
				$departmentData['agents'][] = ['agentId' => $agent->getUserId()];
		}
		
		return $departmentData;
	}
	
	/**
	 * Class constructor
	 *
	 * @param string|null $departmentId
	 */
	public function __construct($departmentId = null)
	{
		if (!empty($departmentId)) {
			$this->setDepartmentId($departmentId);
		}
	}
	
	/**
	 * Sets department id
	 *
	 * @param string $departmentId
	 *
	 * @return \ATDev\RocketChat\Departments\Data
	 */
	public function setDepartmentId($departmentId)
	{
		return $this->departmentId = $departmentId;
	}
	
	/**
	 * Gets department id
	 *
	 * @return string
	 */
	public function getDepartmentId()
	{
		return $this->departmentId;
	}
	
	/**
	 * Sets email
	 *
	 * @param string $email
	 *
	 * @return \ATDev\RocketChat\Departments\Data
	 */
	public function setEmail($email)
	{
		return $this->email = $email;
	}
	
	/**
	 * Gets email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}
	
	/**
	 * Sets the date-time department updated at api
	 *
	 * @param string $updatedAt
	 *
	 * @return \ATDev\RocketChat\Departments\Data
	 */
	private function setUpdatedAt($updatedAt)
	{
		if (is_string($updatedAt)) {
			$this->updatedAt = $updatedAt;
		}
		
		return $this;
	}
	
	/**
	 * Gets the date-time department update at api
	 *
	 * @return string
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}
	
	/**
	 * Sets if department is enabled
	 *
	 * @param boolean $enabled
	 *
	 * @return \ATDev\RocketChat\Departments\Data
	 */
	public function setEnabled($enabled)
	{
		if (!(is_null($enabled) || is_bool($enabled))) {
			$this->setDataError("Invalid enabled value");
		} else {
			$this->enabled = $enabled;
		}
		
		return $this;
	}
	
	/**
	 * Gets if department is enabled
	 *
	 * @return boolean
	 */
	public function getEnabled()
	{
		return $this->enabled;
	}
	
	/**
	 * Sets department name
	 *
	 * @param string $name
	 *
	 * @return \ATDev\RocketChat\Departments\Data
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
	 * Gets department name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Sets department description
	 *
	 * @param string $name
	 *
	 * @return \ATDev\RocketChat\Departments\Data
	 */
	public function setDescription($description)
	{
		if (!(is_null($description) || is_string($description))) {
			$this->setDataError("Invalid description");
		} else {
			$this->description = $description;
		}
		
		return $this;
	}
	
	/**
	 * Gets department description
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}
	
	/**
	 * Sets if department is shown on registration page
	 *
	 * @param boolean $showOnRegistration
	 *
	 * @return \ATDev\RocketChat\Departments\Data
	 */
	public function setShowOnRegistration($showOnRegistration)
	{
		if (!(is_null($showOnRegistration) || is_bool($showOnRegistration))) {
			$this->setDataError("Invalid show on registration value");
		} else {
			$this->showOnRegistration = $showOnRegistration;
		}
		
		return $this;
	}
	
	/**
	 * Gets if department is shown on registration page
	 *
	 * @return boolean
	 */
	public function getShowOnRegistration()
	{
		return $this->showOnRegistration;
	}
	
	/**
	 * Sets if department is shown on offline form
	 *
	 * @param boolean $showOnOfflineForm
	 *
	 * @return \ATDev\RocketChat\Departments\Data
	 */
	public function setShowOnOfflineForm($showOnOfflineForm)
	{
		if (!(is_null($showOnOfflineForm) || is_bool($showOnOfflineForm))) {
			$this->setDataError("Invalid show on offline form value");
		} else {
			$this->showOnOfflineForm = $showOnOfflineForm;
		}
		
		return $this;
	}
	
	/**
	 * Gets if department is shown on offline form
	 *
	 * @return boolean
	 */
	public function getShowOnOfflineForm()
	{
		return $this->showOnOfflineForm;
	}
	
	/**
	 * Sets department agents
	 *
	 * @param array $agents
	 *
	 * @return \ATDev\RocketChat\Departments\Data
	 */
	public function setAgents($agents)
	{
		if (!(is_null($agents) || is_array($agents))) {
			$this->setDataError("Invalid agents value");
		} else {
			$this->agents = $agents;
		}
		
		return $this;
	}
	
	/**
	 * Gets department agents
	 *
	 * @return array
	 */
	public function getAgents()
	{
		return $this->agents;
	}
	
	/**
	 * Sets data error
	 *
	 * @param string $error
	 *
	 * @return \ATDev\RocketChat\Departments\Data
	 */
	private function setDataError($error)
	{
		static::setError($error);
		return $this;
	}
}
