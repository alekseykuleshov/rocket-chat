<?php

namespace ATDev\RocketChat\Roles;

/**
 * Role data trait
 */
trait Data
{
    /* Optional properties for creation */
    /** @var string The name of the new role */
    private $name;
    /** @var string The scope of the new role */
    private $scope;
    /** @var string A description for the new role */
    private $description;

    /* Readonly properties returned from api */
    /** @var string Role id */
    private $roleId;
    /** @var string Date-time */
    private $updatedAt;
    /** @var boolean Indicates if user is using two factor authentication */
    private $mandatory2fa;
    /** @var boolean */
    private $protected;

    /**
     * Gets role id
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param string $value
     * @return $this
     */
    private function setRoleId($value)
    {
        if (is_string($value)) {
            $this->roleId = $value;
        }

        return $this;
    }

    /**
     * Gets updatedAt
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $value
     * @return $this
     */
    private function setUpdatedAt($value)
    {
        if (is_string($value)) {
            $this->updatedAt = $value;
        }

        return $this;
    }

    /**
     * Gets description id
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        if (!is_string($description)) {
            $this->setDataError("Invalid description");
        } else {
            $this->description = $description;
        }

        return $this;
    }

    /**
     * Gets mandatory2fa
     *
     * @return bool
     */
    public function getMandatory2fa()
    {
        return $this->mandatory2fa;
    }

    /**
     * @param bool $value
     * @return $this
     */
    private function setMandatory2fa($value)
    {
        if (is_bool($value)) {
            $this->mandatory2fa = $value;
        }

        return $this;
    }

    /**
     * Gets protected
     *
     * @return bool
     */
    public function getProtected()
    {
        return $this->protected;
    }

    /**
     * @param bool $value
     * @return $this
     */
    private function setProtected($value)
    {
        if (is_bool($value)) {
            $this->protected = $value;
        }

        return $this;
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        if (!is_string($name)) {
            $this->setDataError("Invalid name");
        } else {
            $this->name = $name;
        }

        return $this;
    }

    /**
     * Gets scope
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     * @return $this
     */
    public function setScope($scope)
    {
        if (!is_string($scope)) {
            $this->setDataError("Invalid scope");
        } else {
            $this->scope = $scope;
        }

        return $this;
    }

    /**
     * Gets full role data to submit to api
     *
     * @return array
     */
    public function jsonSerialize()
    {
        if (!is_null($this->name)) {
            $roleData = ['name' => $this->name];
        }
        if (!is_null($this->scope)) {
            $roleData['scope'] = $this->scope;
        }
        if (!is_null($this->description)) {
            $roleData['description'] = $this->description;
        }

        return $roleData;
    }

    /**
     * Creates role out of api response
     *
     * @param \stdClass $response
     *
     * @return \ATDev\RocketChat\Roles\Data
     */
    public static function createOutOfResponse($response)
    {
        $role = new static($response->_id);

        return $role->updateOutOfResponse($response);
    }

    /**
     * Updates current role out of api response
     *
     * @param \stdClass $response
     * @return \ATDev\RocketChat\Roles\Data
     */
    public function updateOutOfResponse($response)
    {
        if (isset($response->_id)) {
            $this->setRoleId($response->_id);
        }
        if (isset($response->_updatedAt)) {
            $this->setUpdatedAt($response->_updatedAt);
        }
        if (isset($response->description)) {
            $this->setDescription($response->description);
        }
        if (isset($response->mandatory2fa)) {
            $this->setMandatory2fa($response->mandatory2fa);
        }
        if (isset($response->protected)) {
            $this->setProtected($response->protected);
        }
        if (isset($response->name)) {
            $this->setName($response->name);
        }
        if (isset($response->scope)) {
            $this->setScope($response->scope);
        }

        return $this;
    }

    /**
     * Sets data error
     *
     * @param string $error
     *
     * @return \ATDev\RocketChat\Roles\Data
     */
    private function setDataError($error)
    {
        static::setError($error);

        return $this;
    }
}
