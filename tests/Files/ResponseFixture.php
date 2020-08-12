<?php

namespace ATDev\RocketChat\Tests\Files;

class ResponseFixture1 extends \stdClass
{
    public function __construct()
    {
        $this->_id =  'fileId123';
        $this->name =  'images.jpeg';
        $this->size =  9778;
        $this->type =  'image/jpeg';
        $this->typeGroup = 'image';
        $this->rid =  'roomId123';
        $this->description =  '';
        $this->store =  'GridFS:Uploads';
        $this->complete =  true;
        $this->uploading =  false;
        $this->extension =  'jpeg';
    }
}

class ResponseFixture2 extends \stdClass
{
    public function __construct()
    {
        $this->_id =  'fileId321';
        $this->progress =  1;
        $this->user =  (object) [
            '_id' =>  'userId123',
            'username' =>  'rocket.cat',
            'name' =>  'Rocket Cat',
        ];
        $this->_updatedAt =  '2018-03-08T14:47:37.003Z';
        $this->instanceId =  'instanceId123';
        $this->etag =  'etagVal';
        $this->path =  '/ufs/GridFS:Uploads/path/images.jpeg';
        $this->token =  '28cAb868d9';
        $this->uploadedAt =  '2018-03-08T14:47:37.295Z';
        $this->url =  '/ufs/GridFS:Uploads/path/images.jpeg';
    }
}

class ResponseFixtureFull extends \stdClass
{
    public function __construct()
    {
        foreach ([new ResponseFixture1(), new ResponseFixture2()] as $fixture) {
            foreach ($fixture as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }
}
