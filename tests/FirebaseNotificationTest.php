<?php

use FirebaseMessaging\FirebaseNotification;

class FirebaseNotificationTest extends PHPUnit_Framework_TestCase
{
    public function testColorInvalid()
    {
        $this->expectException("InvalidArgumentException");
        $nofitication = new FirebaseNotification();
        $nofitication->setColor("#FFF");
    }
    
    public function testColorInvalid2()
    {
        $this->expectException("InvalidArgumentException");
        $nofitication = new FirebaseNotification();
        $nofitication->setColor("#F1F2");
    }
    
    public function testColorValid()
    {
        $color = "#FFF000";
        $nofitication = new FirebaseNotification();
        $nofitication->setColor($color);
        
        $this->assertEquals($color, $nofitication->getColor());
    }
    
    public function testJson()
    {
        $notification = new FirebaseNotification();
        $notification->setBadge('badge');
        $notification->setBody('My Test');
        $notification->setClickAction('open_activity_video');
        $notification->setColor('#FFFFFF');
        $notification->setIcon('custom_icon');
        $notification->setSound('custom_sound');
        $notification->setTag('tag');
        $notification->setTitle('My Title');

        $expected = '{"title":"My Title","body":"My Test","icon":"custom_icon","sound":"custom_sound","badge":"badge","tag":"tag","color":"#FFFFFF","click_action":"open_activity_video"}';
        
        $this->assertJsonStringEqualsJsonString($expected, (string)$notification);
    }
}