<?php

namespace ATDev\RocketChat\Files;

use ATDev\RocketChat\Users\User;

class File
{
    /** @var string File id */
    private $fileId;
    /** @var string */
    private $name;
    /** @var int */
    private $size;
    /** @var string */
    private $type;
    /** @var string */
    private $typeGroup;
    /** @var string */
    private $roomId;
    /** @var string */
    private $description;
    /** @var string */
    private $store;
    /** @var bool */
    private $complete;
    /** @var bool */
    private $uploading;
    /** @var string */
    private $extension;
    /** @var int */
    private $progress;
    /** @var User */
    private $user;
    /** @var string */
    private $updatedAt;
    /** @var string */
    private $instanceId;
    /** @var string */
    private $etag;
    /** @var string */
    private $path;
    /** @var string */
    private $token;
    /** @var string */
    private $uploadedAt;
    /** @var string */
    private $url;

    /**
     * File constructor.
     * @param string|null $fileId
     */
    public function __construct($fileId = null)
    {
        if (!empty($fileId)) {
            $this->setFileId($fileId);
        }
    }

    /**
     * @param \stdClass $response
     * @return File
     */
    public static function createOutOfResponse($response)
    {
        $file = new static($response->_id);
        return $file->updateOutOfResponse($response);
    }

    /**
     * @param \stdClass $response
     * @return $this
     */
    public function updateOutOfResponse($response)
    {
        if (isset($response->_id)) {
            $this->setFileId($response->_id);
        }
        if (isset($response->name)) {
            $this->setName($response->name);
        }
        if (isset($response->size)) {
            $this->setSize($response->size);
        }
        if (isset($response->type)) {
            $this->setType($response->type);
        }
        if (isset($response->typeGroup)) {
            $this->setTypeGroup($response->typeGroup);
        }
        if (isset($response->rid)) {
            $this->setRoomId($response->rid);
        }
        if (isset($response->description)) {
            $this->setDescription($response->description);
        }
        if (isset($response->store)) {
            $this->setStore($response->store);
        }
        if (isset($response->complete)) {
            $this->setComplete($response->complete);
        }
        if (isset($response->uploading)) {
            $this->setUploading($response->uploading);
        }
        if (isset($response->extension)) {
            $this->setExtension($response->extension);
        }
        if (isset($response->progress)) {
            $this->setProgress($response->progress);
        }
        if (isset($response->user)) {
            $this->setUser($response->user);
        }
        if (isset($response->_updatedAt)) {
            $this->setUpdatedAt($response->_updatedAt);
        }
        if (isset($response->instanceId)) {
            $this->setInstanceId($response->instanceId);
        }
        if (isset($response->etag)) {
            $this->setEtag($response->etag);
        }
        if (isset($response->path)) {
            $this->setPath($response->path);
        }
        if (isset($response->token)) {
            $this->setToken($response->token);
        }
        if (isset($response->uploadedAt)) {
            $this->setUploadedAt($response->uploadedAt);
        }
        if (isset($response->url)) {
            $this->setUrl($response->url);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getFileId()
    {
        return $this->fileId;
    }

    /**
     * @param string $fileId
     * @return $this
     */
    private function setFileId($fileId)
    {
        if (is_string($fileId)) {
            $this->fileId = $fileId;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return File
     */
    private function setName($name)
    {
        if (is_string($name)) {
            $this->name = $name;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return File
     */
    private function setSize($size)
    {
        if (is_int($size)) {
            $this->size = $size;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return File
     */
    private function setType($type)
    {
        if (is_string($type)) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getTypeGroup()
    {
        return $this->typeGroup;
    }

    /**
     * @param string $typeGroup
     * @return File
     */
    private function setTypeGroup($typeGroup)
    {
        if (is_string($typeGroup)) {
            $this->typeGroup = $typeGroup;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * @param string $roomId
     * @return File
     */
    private function setRoomId($roomId)
    {
        if (is_string($roomId)) {
            $this->roomId = $roomId;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return File
     */
    private function setDescription($description)
    {
        if (is_string($description)) {
            $this->description = $description;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param string $store
     * @return File
     */
    private function setStore($store)
    {
        if (is_string($store)) {
            $this->store = $store;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isComplete()
    {
        return $this->complete;
    }

    /**
     * @param bool $complete
     * @return File
     */
    private function setComplete($complete)
    {
        if (is_bool($complete)) {
            $this->complete = $complete;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isUploading()
    {
        return $this->uploading;
    }

    /**
     * @param bool $uploading
     * @return File
     */
    private function setUploading($uploading)
    {
        if (is_bool($uploading)) {
            $this->uploading = $uploading;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return File
     */
    private function setExtension($extension)
    {
        if (is_string($extension)) {
            $this->extension = $extension;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * @param int $progress
     * @return File
     */
    private function setProgress($progress)
    {
        if (is_int($progress)) {
            $this->progress = $progress;
        }

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \stdClass $user
     * @return File
     */
    private function setUser($user)
    {
        if (is_object($user) && isset($user->_id)) {
            $this->user = User::createOutOfResponse($user);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     * @return File
     */
    private function setUpdatedAt($updatedAt)
    {
        if (is_string($updatedAt)) {
            $this->updatedAt = $updatedAt;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getInstanceId()
    {
        return $this->instanceId;
    }

    /**
     * @param string $instanceId
     * @return File
     */
    private function setInstanceId($instanceId)
    {
        if (is_string($instanceId)) {
            $this->instanceId = $instanceId;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * @param string $etag
     * @return File
     */
    private function setEtag($etag)
    {
        if (is_string($etag)) {
            $this->etag = $etag;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return File
     */
    private function setPath($path)
    {
        if (is_string($path)) {
            $this->path = $path;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return File
     */
    private function setToken($token)
    {
        if (is_string($token)) {
            $this->token = $token;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getUploadedAt()
    {
        return $this->uploadedAt;
    }

    /**
     * @param string $uploadedAt
     * @return File
     */
    private function setUploadedAt($uploadedAt)
    {
        if (is_string($uploadedAt)) {
            $this->uploadedAt = $uploadedAt;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return File
     */
    private function setUrl($url)
    {
        if (is_string($url)) {
            $this->url = $url;
        }

        return $this;
    }
}
