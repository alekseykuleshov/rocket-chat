<?php

namespace ATDev\RocketChat\Users;

/**
 * User new avatar class
 */
abstract class Avatar
{


    /** @var boolean Indicates if source is file or domain */
    const IS_FILE = null;
    /** @var string Source of new avatar, domain or file */
    private $source;
    /** @var string|null Error message, empty if no error, some text if any */
    private $error;

    /**
     * Class constructor
     *
     * @param string $source
     */
    public function __construct($source = null)
    {
        if (!empty($source)) {
            $this->setSource($source);
        }
    }

    /**
     * Sets source of new user avatar
     *
     * @param string $name
     *
     * @return \ATDev\RocketChat\Users\Avatar
     */
    public function setSource($source)
    {
        if (!(is_null($source) || is_string($source))) {
            $this->setError("Invalid avatar source");
        } else {
            $this->source = $source;
        }

        return $this;
    }

    /**
     * Gets source of new user avatar
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Gets error
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Sets error
     *
     * @param string $error
     *
     * @return \ATDev\RocketChat\Users\Avatar
     */
    private function setError($error)
    {
        $this->error = $error;
    }
}

/**
 * User new avatar from file class
 */
class AvatarFromFile extends Avatar
{

    /** @var boolean Indicates if source is file or domain */
    const IS_FILE = true;
}

/**
 * User new avatar from domain class
 */
class AvatarFromDomain extends Avatar
{

    /** @var boolean Indicates if source is file or domain */
    const IS_FILE = false;
}
