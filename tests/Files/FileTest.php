<?php

namespace ATDev\RocketChat\Tests\Files;

use ATDev\RocketChat\Files\File;
use ATDev\RocketChat\Users\User;
use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

class FileTest extends TestCase
{
    public function testConstructorNoFileId()
    {
        $mock = $this->getMockBuilder(File::class)->enableProxyingToOriginalMethods()->getMock();
        $stub = test::double(get_class($mock), ['setFileId' => $mock]);
        $stub->construct();
        $stub->verifyNeverInvoked('setFileId');
    }

    public function testConstructorWithFileId()
    {
        $mock = $this->getMockBuilder(File::class)->enableProxyingToOriginalMethods()->getMock();
        $stub = test::double(get_class($mock), ['setFileId' => $mock]);
        $stub->construct('fileId123');
        $stub->verifyInvokedOnce('setFileId', ['fileId123']);
    }

    public function testUpdateOutOfResponse1()
    {
        $file1 = new ResponseFixture1();
        $mock = $this->getMockBuilder(File::class)->enableProxyingToOriginalMethods()->getMock();
        $mock->updateOutOfResponse($file1);

        $this->assertSame('fileId123', $mock->getFileId());
        $this->assertSame('images.jpeg', $mock->getName());
        $this->assertSame(9778, $mock->getSize());
        $this->assertSame('image/jpeg', $mock->getType());
        $this->assertSame('roomId123', $mock->getRoomId());
        $this->assertSame('', $mock->getDescription());
        $this->assertSame('GridFS:Uploads', $mock->getStore());
        $this->assertSame(true, $mock->isComplete());
        $this->assertSame(false, $mock->isUploading());
        $this->assertSame('jpeg', $mock->getExtension());
        $this->assertSame('image', $mock->getTypeGroup());

        $this->assertNull($mock->getProgress());
        $this->assertNull($mock->getUser());
        $this->assertNull($mock->getUpdatedAt());
        $this->assertNull($mock->getInstanceId());
        $this->assertNull($mock->getEtag());
        $this->assertNull($mock->getPath());
        $this->assertNull($mock->getToken());
        $this->assertNull($mock->getUploadedAt());
        $this->assertNull($mock->getUrl());
    }

    public function testUpdateOutOfResponse2()
    {
        $file1 = new ResponseFixture2();
        $mock = $this->getMockBuilder(File::class)->enableProxyingToOriginalMethods()->getMock();
        $mock->updateOutOfResponse($file1);

        $this->assertSame('fileId321', $mock->getFileId());
        $this->assertNull($mock->getName());
        $this->assertNull($mock->getSize());
        $this->assertNull($mock->getType());
        $this->assertNull($mock->getRoomId());
        $this->assertNull($mock->getDescription());
        $this->assertNull($mock->getStore());
        $this->assertNull($mock->isComplete());
        $this->assertNull($mock->isUploading());
        $this->assertNull($mock->getExtension());
        $this->assertNull($mock->getTypeGroup());

        $this->assertSame(1, $mock->getProgress());
        $this->assertInstanceOf(User::class, $mock->getUser());
        $this->assertSame('userId123', $mock->getUser()->getUserId());
        $this->assertSame('2018-03-08T14:47:37.003Z', $mock->getUpdatedAt());
        $this->assertSame('instanceId123', $mock->getInstanceId());
        $this->assertSame('etagVal', $mock->getEtag());
        $this->assertSame('/ufs/GridFS:Uploads/path/images.jpeg', $mock->getPath());
        $this->assertSame('28cAb868d9', $mock->getToken());
        $this->assertSame('2018-03-08T14:47:37.295Z', $mock->getUploadedAt());
        $this->assertSame('/ufs/GridFS:Uploads/path/images.jpeg', $mock->getUrl());
    }

    public function testCreateOutOfResponse()
    {
        $stub = test::double(File::class, ['updateOutOfResponse' => 'result']);

        $roomRole = new ResponseFixtureFull();
        $result = File::createOutOfResponse($roomRole);
        $this->assertSame('result', $result);
        $stub->verifyInvokedOnce('updateOutOfResponse', [$roomRole]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
