<?php

use FirebaseMessaging\FirebaseCondition;

class FirebaseConditionTest extends PHPUnit_Framework_TestCase
{
    public function testConstructInvalid()
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("The topic name must not be null, array or empty.");
        $condition = new FirebaseCondition(null);
    }
    
    public function testConstructInvalid2()
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("The topic name must not be null, array or empty.");
        $condition = new FirebaseCondition("    ");
    }

    public function testConstructInvalid3()
    {
        $this->expectException("InvalidArgumentException");
        $this->expectExceptionMessage("The topic name must not be null, array or empty.");
        $condition = new FirebaseCondition(["ArtisticGymnastics", "FlaviaSaraiva", "RebecaAndrade"]);
    }
    
    public function testConstructValid()
    {
        $this->assertInstanceOf("FirebaseMessaging\FirebaseCondition", new FirebaseCondition("ArtisticGymnastics"));
    }
    
    public function testErrorWithMoreThanThreeConditions()
    {
        $this->expectException("OutOfBoundsException");
        $this->expectExceptionMessage("Invalid condition: Only support up to 3 conditions");
        $condition = new FirebaseCondition("ArtisticGymnastics");
        $condition->openAnd("FlaviaSaraiva");
        $condition->orInTopics("RecebaAndrade");
        $condition->orInTopics("JadeBarbosa");
        $condition->orInTopics("DanieleHypolito");
        $condition->orInTopics("LorraneOliveira");
    }
    
    public function testConditionWithSyntaxError()
    {
        $condition = new FirebaseCondition("ArtisticGymnastics");
        $condition->openAnd("FlaviaSaraiva");
        $condition->openOr("RebecaAndrade");
        $condition->closeOr();
        $this->assertFalse($condition->isValid());
    }
    
    /**
     * @depends testConditionWithSyntaxError
     */
    public function testConditionValid()
    {
        $condition = new FirebaseCondition("ArtisticGymnastics");
        $condition->openAnd("FlaviaSaraiva");
        $condition->orInTopics("RebecaAndrade");
        $condition->closeAnd();
        
        $actual = (string)$condition;
        $expected = "'ArtisticGymnastics' in topics && ('FlaviaSaraiva' in topics || 'RebecaAndrade' in topics)";
        $this->assertEquals($expected, $actual);
    }
}