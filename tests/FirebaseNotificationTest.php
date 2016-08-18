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
}