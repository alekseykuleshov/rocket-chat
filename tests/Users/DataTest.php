<?php

namespace ATDev\RocketChat\Tests\Users;

use ATDev\RocketChat\Users\Preferences;
use PHPUnit\Framework\TestCase;
use AspectMock\Test as test;

use ATDev\RocketChat\Users\Data;

class DataTest extends TestCase
{
    public function testConstructorNoUserId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double(get_class($mock), ["setUserId" => $mock]);

        $stub->construct();

        $stub->verifyNeverInvoked("setUserId");
    }

    public function testConstructorWithUserId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double(get_class($mock), ["setUserId" => $mock]);

        $stub->construct("asd123asd");

        $stub->verifyInvokedOnce("setUserId", ["asd123asd"]);
    }

    public function testInvalidUserId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setUserId(123);
        $this->assertNull($mock->getUserId());

        $stub->verifyInvokedOnce("setDataError", ["Invalid user Id"]);
    }

    public function testValidUserId()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setUserId("123");
        $this->assertSame("123", $mock->getUserId());

        // And null value...
        $mock->setUserId(null);
        $this->assertSame(null, $mock->getUserId());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidEmail()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setEmail(123);
        $this->assertNull($mock->getEmail());

        $stub->verifyInvokedOnce("setDataError", ["Invalid email"]);
    }

    public function testInvalidEmailFormat()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $validator = test::double("\Egulias\EmailValidator\EmailValidator", ["isValid" => false]);
        $validation = test::double("\Egulias\EmailValidator\Validation\RFCValidation");

        $mock->setEmail("ajsfsdfasdf");
        $this->assertNull($mock->getEmail());

        $stub->verifyInvokedOnce("setDataError", ["Invalid email value"]);
    }

    public function testValidEmail()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $validator = test::double("\Egulias\EmailValidator\EmailValidator", ["isValid" => true]);
        $validation = test::double("\Egulias\EmailValidator\Validation\RFCValidation");

        $mock->setEmail("test@example.com");
        $this->assertSame("test@example.com", $mock->getEmail());

        // And null value...
        $mock->setEmail(null);
        $this->assertSame(null, $mock->getEmail());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidName()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setName(123);
        $this->assertNull($mock->getName());

        $stub->verifyInvokedOnce("setDataError", ["Invalid name"]);
    }

    public function testValidName()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setName("User Name");
        $this->assertSame("User Name", $mock->getName());

        // And null value...
        $mock->setName(null);
        $this->assertSame(null, $mock->getName());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidPassword()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setPassword(123);
        $this->assertNull($mock->getPassword());

        $stub->verifyInvokedOnce("setDataError", ["Invalid password"]);
    }

    public function testValidPassword()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setPassword("sjdfb235$$");
        $this->assertSame("sjdfb235$$", $mock->getPassword());

        // And null value...
        $mock->setPassword(null);
        $this->assertSame(null, $mock->getPassword());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidUsername()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setUsername(123);
        $this->assertNull($mock->getUsername());

        $stub->verifyInvokedOnce("setDataError", ["Invalid user name"]);
    }

    public function testValidUsername()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setUsername("userName");
        $this->assertSame("userName", $mock->getUsername());

        // And null value...
        $mock->setUsername(null);
        $this->assertSame(null, $mock->getUsername());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidActive()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setActive(new \stdClass());
        $this->assertNull($mock->getActive());

        $stub->verifyInvokedOnce("setDataError", ["Invalid active value"]);
    }

    public function testValidActive()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setActive(false);
        $this->assertSame(false, $mock->getActive());

        // And null value...
        $mock->setActive(null);
        $this->assertSame(null, $mock->getActive());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidRoles()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setRoles(123);
        $this->assertNull($mock->getRoles());

        $stub->verifyInvokedOnce("setDataError", ["Invalid roles value"]);
    }

    public function testValidRoles()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setRoles(["admin"]);
        $this->assertSame(["admin"], $mock->getRoles());

        // And null value...
        $mock->setRoles(null);
        $this->assertSame(null, $mock->getRoles());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidJoinDefaultChannels()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setJoinDefaultChannels(123);
        $this->assertNull($mock->getJoinDefaultChannels());

        $stub->verifyInvokedOnce("setDataError", ["Invalid join default channels value"]);
    }

    public function testValidJoinDefaultChannels()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setJoinDefaultChannels(false);
        $this->assertSame(false, $mock->getJoinDefaultChannels());

        // And null value...
        $mock->setJoinDefaultChannels(null);
        $this->assertSame(null, $mock->getJoinDefaultChannels());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidRequirePasswordChange()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setRequirePasswordChange(123);
        $this->assertNull($mock->getRequirePasswordChange());

        $stub->verifyInvokedOnce("setDataError", ["Invalid require password change value"]);
    }

    public function testValidRequirePasswordChange()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setRequirePasswordChange(false);
        $this->assertSame(false, $mock->getRequirePasswordChange());

        // And null value...
        $mock->setRequirePasswordChange(null);
        $this->assertSame(null, $mock->getRequirePasswordChange());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidSendWelcomeEmail()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setSendWelcomeEmail(123);
        $this->assertNull($mock->getSendWelcomeEmail());

        $stub->verifyInvokedOnce("setDataError", ["Invalid send welcome email value"]);
    }

    public function testValidSendWelcomeEmail()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setSendWelcomeEmail(false);
        $this->assertSame(false, $mock->getSendWelcomeEmail());

        // And null value...
        $mock->setSendWelcomeEmail(null);
        $this->assertSame(null, $mock->getSendWelcomeEmail());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidVerified()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setVerified(123);
        $this->assertNull($mock->getVerified());

        $stub->verifyInvokedOnce("setDataError", ["Invalid verified value"]);
    }

    public function testValidVerified()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setVerified(false);
        $this->assertSame(false, $mock->getVerified());

        // And null value...
        $mock->setVerified(null);
        $this->assertSame(null, $mock->getVerified());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testInvalidCustomFields()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setCustomFields(123);
        $this->assertNull($mock->getCustomFields());

        $stub->verifyInvokedOnce("setDataError", ["Invalid custom fields name"]);
    }

    public function testValidCustomFields()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double($mock, ["setDataError" => $mock]);

        $mock->setCustomFields("asdfasdf");
        $this->assertSame("asdfasdf", $mock->getCustomFields());

        // And null value...
        $mock->setCustomFields(null);
        $this->assertSame(null, $mock->getCustomFields());

        $stub->verifyNeverInvoked("setDataError");
    }

    public function testJsonSerialize()
    {
        $mock = $this->getMockForTrait(Data::class);
        $mock->setEmail("test@example.com");
        $mock->setName("John Doe");
        $mock->setUsername("jDoe");
        $mock->setPassword("#@$%");
        $mock->setRoles(["somebody", "other"]);
        $mock->setRequirePasswordChange(false);
        $mock->setVerified(true);

        $this->assertSame([
            "email" => "test@example.com",
            "name" => "John Doe",
            "username" => "jDoe",
            "password" => "#@$%",
            "roles" => ["somebody", "other"],
            "requirePasswordChange" => false,
            "verified" => true
        ], $mock->jsonSerialize());

        $mock = $this->getMockForTrait(Data::class);
        $mock->setActive(false);
        $mock->setJoinDefaultChannels(false);
        $mock->setSendWelcomeEmail(true);
        $mock->setCustomFields("custom fields");

        $this->assertSame([
            "email" => null,
            "name" => null,
            "username" => null,
            "active" => false,
            "joinDefaultChannels" => false,
            "sendWelcomeEmail" => true,
            "customFields" => "custom fields"
        ], $mock->jsonSerialize());
    }

    public function testUpdateOutOfResponse()
    {
        $userFull = new ResponseFixtureFull();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($userFull);

        $this->assertSame("asd123asd", $mock->getUserId());
        $this->assertSame("2018-01-12T00:12:22.167Z", $mock->getCreatedAt());
        $this->assertSame("test@example.com", $mock->getEmail());
        $this->assertSame(true, $mock->getVerified());
        $this->assertSame("user", $mock->getType());
        $this->assertSame("some", $mock->getStatusValue());
        $this->assertSame(true, $mock->getActive());
        $this->assertSame(["admin", "guest"], $mock->getRoles());
        $this->assertSame("John Doe", $mock->getName());
        $this->assertSame("2016-12-08T00:22:15.167Z", $mock->getLastLogin());
        $this->assertSame("offline", $mock->getStatusConnection());
        $this->assertSame(-3.5, $mock->getUtcOffset());
        $this->assertSame("jDoe", $mock->getUserName());
        $this->assertSame("https://localhost/avatar.png", $mock->getAvatarUrl());
        $this->assertInstanceOf(Preferences::class, $mock->getPreferencesData());
        $this->assertClassHasAttribute("newRoomNotification", Preferences::class);
        $this->assertSame("notification", $mock->getPreferencesData()->getNewRoomNotification());
        $this->assertClassHasAttribute("useEmojis", Preferences::class);
        $this->assertSame(true, $mock->getPreferencesData()->isUseEmojis());

        $user1 = new ResponseFixture1();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($user1);

        $this->assertSame("asd123asd", $mock->getUserId());
        $this->assertNull($mock->getCreatedAt());
        $this->assertSame("test@example.com", $mock->getEmail());
        $this->assertNull($mock->getVerified());
        $this->assertNull($mock->getType());
        $this->assertSame("some", $mock->getStatusValue());
        $this->assertNull($mock->getActive());
        $this->assertSame(["admin", "guest"], $mock->getRoles());
        $this->assertNull($mock->getName());
        $this->assertSame("2016-12-08T00:22:15.167Z", $mock->getLastLogin());
        $this->assertNull($mock->getStatusConnection());
        $this->assertSame(-3.5, $mock->getUtcOffset());
        $this->assertNull($mock->getUserName());
        $this->assertSame("https://localhost/avatar.png", $mock->getAvatarUrl());
        $this->assertNull($mock->getPreferencesData());

        $user2 = new ResponseFixture2();
        $mock = $this->getMockForTrait(Data::class);
        $mock->updateOutOfResponse($user2);

        $this->assertNull($mock->getUserId());
        $this->assertSame("2018-01-12T00:12:22.167Z", $mock->getCreatedAt());
        $this->assertNull($mock->getEmail());
        $this->assertNull($mock->getVerified());
        $this->assertSame("user", $mock->getType());
        $this->assertNull($mock->getStatusValue());
        $this->assertSame(true, $mock->getActive());
        $this->assertNull($mock->getRoles());
        $this->assertSame("John Doe", $mock->getName());
        $this->assertNull($mock->getLastLogin());
        $this->assertSame("offline", $mock->getStatusConnection());
        $this->assertNull($mock->getUtcOffset());
        $this->assertSame("jDoe", $mock->getUserName());
        $this->assertNull($mock->getAvatarUrl());
        $this->assertInstanceOf(Preferences::class, $mock->getPreferencesData());
        $this->assertClassHasAttribute("newRoomNotification", Preferences::class);
        $this->assertSame("notification", $mock->getPreferencesData()->getNewRoomNotification());
        $this->assertClassHasAttribute("useEmojis", Preferences::class);
        $this->assertSame(true, $mock->getPreferencesData()->isUseEmojis());
    }

    public function testCreateOutOfResponse()
    {
        $mock = $this->getMockForTrait(Data::class);

        $stub = test::double(get_class($mock), ["updateOutOfResponse" => $mock]);

        $userFull = new ResponseFixtureFull();
        $mock->createOutOfResponse($userFull);

        $stub->verifyInvokedOnce("updateOutOfResponse", [$userFull]);
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
