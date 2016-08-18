<?php

use FirebaseMessaging\FirebaseMessaging;
use FirebaseMessaging\FirebaseNotification;
use FirebaseMessaging\FirebaseCondition;

class FirebaseMessagingTest extends \PHPUnit_Framework_TestCase
{   
    Const SERVER_KEY_VALID = "YourServerKey";
    Const SERVER_KEY_INVALID = "code";
    Const PACKAGE_NAME = "br.com.valdeirsantana.test";

    public function testConstructInvalid()
    {
        $this->expectException("InvalidArgumentException");
        new FirebaseMessaging(null);
    }
    
    public function testConstructInvalid2()
    {
        $this->expectException("InvalidArgumentException");
        new FirebaseMessaging("     ");
    }
    
    public function testConstructInvalid3()
    {
        $this->expectException("InvalidArgumentException");
        new FirebaseMessaging("     ");
    }
    
    public function testConstructInvalid4()
    {
        $this->expectException("InvalidArgumentException");
        new FirebaseMessaging([]);
    }
    
    public function testConstructValid()
    {
        $this->assertInstanceOf('FirebaseMessaging\FirebaseMessaging', new FirebaseMessaging(self::SERVER_KEY_INVALID));
    }
    
    public function testRegistrationIdsInvalid()
    {
        $this->expectException("InvalidArgumentException");
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $firebase->setRegistrationIds([]);
    }
    
    public function testRegistrationIdsInvalid2()
    {
        $arr = [];
        
        for ($i = 1; $i <= 1001; $i++) {
            $arr[$i] = $i;
        }
        
        $this->expectException("InvalidArgumentException");
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $firebase->setRegistrationIds($arr);
    }
    
    public function testRegistrationIdsValid()
    {
        $arr = [];
    
        for ($i = 1; $i <= 1000; $i++) {
            $arr[$i] = $i;
        }
    
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $firebase->setRegistrationIds($arr);
        
        $this->assertEquals($arr, $firebase->getRegistrationIds());
    }

    public function testPriorityInvalid()
    {
        $this->expectException("InvalidArgumentException");
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $firebase->setPriority("low");
    }
    
    public function testPriorityValid()
    {
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $this->assertInstanceOf("FirebaseMessaging\FirebaseMessaging", $firebase->setPriority(FirebaseMessaging::PRIORITY_HIGH));
    }
    
    public function testPriorityValid2()
    {
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $this->assertInstanceOf("FirebaseMessaging\FirebaseMessaging", $firebase->setPriority("normal"));
    }
    
    public function testTimeToLiveInvalid()
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("The value must be an integer.");
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $firebase->setTimeToLive("10000");
    }
    
    public function testTimeToLiveInvalid2()
    {
        $this->expectException("OutOfBoundsException");
        $this->expectExceptionMessage("The maximum service life allowed is 4 weeks.");
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $firebase->setTimeToLive(2419201);
    }
    
    public function testTimeToLiveValid()
    {
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $firebase->setTimeToLive(2419200);
        
        $this->assertEquals(2419200, $firebase->getTimeToLive());
    }
    
    public function testDataInvalid()
    {
        $this->expectException("InvalidArgumentException");
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $firebase->setData([
            "valdeir" => "santana",
            "psr" => "valdeir",
            "val" => "deir",
            "google_gcm" => "psr_fail",
            "psr_gcm" => "val",
            "gcm_psr" => "deir",
            "_psr" => "gcm_google",
            "_psr2" => "google",
            "googl" => "valdeir",
            "gogle",
        ]);
    }
    
    public function testDataValid()
    {
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $this->assertInstanceOf("FirebaseMessaging\FirebaseMessaging", $firebase->setData([
            "valid1" => "santana",
            "valid2" => "valdeir",
            "valid3" => "deir",
            "valid4" => "google_gcm",
            "valid5" => "val",
            "valid6" => "deir",
            "valid7" => "gcm_google",
            "valid8" => "google",
            "valid9" => "valdeir",
        ]));
    }
    
    public function testOperacionalSystemInvalid()
    {
        $this->expectException("InvalidArgumentException");
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $firebase->setOperacionalSystem(3);
    }
    
    public function testOperacionalSystemInvalid2()
    {
        $this->expectException("InvalidArgumentException");
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $firebase->setOperacionalSystem("3");
    }
    
    public function testOperacionalSystemValid()
    {
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $this->assertInstanceOf("FirebaseMessaging\FirebaseMessaging", $firebase->setOperacionalSystem(0));
    }
    
    public function testOperacionalSystemValid2()
    {
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $this->assertInstanceOf("FirebaseMessaging\FirebaseMessaging",
            $firebase->setOperacionalSystem(FirebaseMessaging::OS_ANDROID));
    }
    
    public function testOperacionalSystemValid3()
    {
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $this->assertInstanceOf("FirebaseMessaging\FirebaseMessaging", $firebase->setOperacionalSystem("2"));
    }
    
    public function testNotificationForAndroidUntitled()
    {
        $this->expectException("FirebaseMessaging\Exception\NotificationException");
        $this->expectExceptionMessage("Title is required");
        
        $notification = new FirebaseNotification();
        $notification->setBody("My Message");
        $notification->setIcon("myicon");
        $notification->setTag("valdeirpsr_1");
        
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $firebase->setOperacionalSystem(FirebaseMessaging::OS_ANDROID);
        $firebase->setNotification($notification);
    }
    
    public function testNotificationValid()
    {
        $notification = new FirebaseNotification();
        $notification->setTitle("My Title");
        $notification->setBody("My Message");
        $notification->setIcon("myicon");
        $notification->setTag("valdeirpsr_1");
    
        $firebase = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $firebase->setOperacionalSystem(FirebaseMessaging::OS_ANDROID);
        $firebase->setNotification($notification);
        
        $this->assertEquals($notification, $firebase->getNotification());
    }
    
    public function testSendMessageWithoutAuthorization()
    {
        $this->expectException("FirebaseMessaging\Exception\UnauthorizedException");
        $this->expectExceptionMessage("Unauthorized");
    
        $notification = new FirebaseNotification();
        $notification->setTitle("My Title");
        $notification->setBody("My Message");
        $notification->setIcon("myicon");
        $notification->setTag("valdeirpsr_1");
    
        $condition = new FirebaseCondition("ArtisticGymnastics");
        $condition->openAnd("FlaviaSaraiva");
        $condition->orInTopics("RebecaAndrade");
        $condition->closeAnd();
    
        $messaging = new FirebaseMessaging(self::SERVER_KEY_INVALID);
        $messaging->setTo("topics/ArtisticGymnastics");
        $messaging->setRestrictedPackageName(self::PACKAGE_NAME);
        $messaging->setPriority(FirebaseMessaging::PRIORITY_HIGH);
        $messaging->setTimeToLive(2419200);
        $messaging->setOperacionalSystem(FirebaseMessaging::OS_ANDROID);
        $messaging->setNotification($notification);
        $messaging->setDevelopmentMode(true);
        $messaging->send();
    }
    
    public function testSendMessageWithInvalidCondition()
    {
        $this->expectException("UnexpectedValueException");
        $this->expectExceptionMessage("Invalid condition: Wrong filter expression syntax");
    
        $notification = new FirebaseNotification();
        $notification->setTitle("My Title");
        $notification->setBody("My Message");
        $notification->setIcon("myicon");
        $notification->setTag("valdeirpsr_1");
    
        $condition = new FirebaseCondition("ArtisticGymnastics");
        $condition->openAnd("FlaviaSaraiva");
        $condition->orInTopics("RebecaAndrade");
    
        $messaging = new FirebaseMessaging(self::SERVER_KEY_VALID);
        $messaging->setCondition($condition);
    }
    
    public function testSendMessageWithResponseInvalid()
    {
        $this->expectException("Exception");
    
        $notification = new FirebaseNotification();
        $notification->setTitle("My Title");
        $notification->setBody("My Message");
        $notification->setIcon("myicon");
        $notification->setTag("valdeirpsr_1");
    
        $messaging = new FirebaseMessaging(self::SERVER_KEY_VALID);
        $messaging->setPriority(FirebaseMessaging::PRIORITY_HIGH);
        $messaging->setTimeToLive(2419200);
        $messaging->setOperacionalSystem(FirebaseMessaging::OS_ANDROID);
        $messaging->setNotification($notification);
        $messaging->setDevelopmentMode(true);
        $messaging->send();
    }
    
    public function testSendMessageModeDevelopmentValid()
    {
        $notification = new FirebaseNotification();
        $notification->setTitle("My Title");
        $notification->setBody("My Message");
        $notification->setIcon("myicon");
        $notification->setTag("valdeirpsr_1");
        
        $condition = new FirebaseCondition("ArtisticGymnastics");
        $condition->openAnd("FlaviaSaraiva");
        $condition->orInTopics("RebecaAndrade");
        $condition->closeAnd();
    
        $messaging = new FirebaseMessaging(self::SERVER_KEY_VALID);
        $messaging->setCondition($condition);
        $messaging->setPriority(FirebaseMessaging::PRIORITY_HIGH);
        $messaging->setTimeToLive(2419200);
        $messaging->setOperacionalSystem(FirebaseMessaging::OS_ANDROID);
        $messaging->setNotification($notification);
        $messaging->setDevelopmentMode(true);
        $response = $messaging->send();
        
        $this->assertTrue($response->getMessageId() == -1);
    }
    
    public function testSendMessageModeProduction()
    {
        $notification = new FirebaseNotification();
        $notification->setTitle("My Title");
        $notification->setBody("My Message");
        $notification->setIcon("myicon");
        $notification->setTag("valdeirpsr_1");
    
        $condition = new FirebaseCondition("ArtisticGymnastics");
        $condition->openAnd("FlaviaSaraiva");
        $condition->orInTopics("RebecaAndrade");
        $condition->closeAnd();
    
        $messaging = new FirebaseMessaging(self::SERVER_KEY_VALID);
        $messaging->setCondition($condition);
        $messaging->setPriority(FirebaseMessaging::PRIORITY_HIGH);
        $messaging->setTimeToLive(2419200);
        $messaging->setOperacionalSystem(FirebaseMessaging::OS_ANDROID);
        $messaging->setNotification($notification);
        $response = $messaging->send();
        
        $this->assertTrue($response->getMessageId() != -1);
    }
}
