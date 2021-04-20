<?php

namespace ATDev\RocketChat\Roles;

/**
 * Role data trait
 */
trait Data
{
    private $roleId;
    private $updatedAt;
    private $description;
    private $mandatory2fa;
    private $protected;
    private $name;
    private $scope;

    private $updatedSince;

    private $update;
    private $remove;

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
        if (!(is_null($description) || is_string($description))) {
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
        if (!(is_null($name) || is_string($name))) {
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
        if (!(is_null($scope) || is_string($scope))) {
            $this->setDataError("Invalid scope");
        } else {
            $this->scope = $scope;
        }

        return $this;
    }

    /**
     * Gets updatedSince
     *
     * @return string
     */
    public function getUpdatedSince()
    {
        return $this->updatedSince;
    }

    /**
     * Sets updatedSince
     *
     * @param string $updatedSince
     *
     * @return \ATDev\RocketChat\Roles\Data
     */
    public function setUpdatedSince($updatedSince)
    {
        if (!(is_null($updatedSince) || is_string($updatedSince))) {
            $this->setDataError("Invalid updatedSince");
        } else {
            $this->updatedSince = $updatedSince;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getUpdatedRoles()
    {
        return $this->update;
    }

    /**
     * @return array
     */
    public function getRemovedRoles()
    {
        return $this->remove;
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