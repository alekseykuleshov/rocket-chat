<?php

namespace ATDev\RocketChat\Files;

class File
{
    /** @var string File id */
    private $fileId;


    public function __construct($fileId = null)
    {
        if (!empty($fileId)) {
            $this->setFileId($fileId);
        }
    }

    public static function createOutOfResponse($response)
    {
        $file = new static($response->_id);
        return $file->updateOutOfResponse($response);
    }

    public function updateOutOfResponse($response)
    {
        if (isset($response->_id)) {
            $this->setFileId($response->_id);
        }

        return $this;
    }

    private function setFileId($fileId)
    {
        if (is_string($fileId)) {
            $this->fileId = $fileId;
        }

        return $this;
    }
}
