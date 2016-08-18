<?php
namespace FirebaseMessaging;

/**
 * Class responsible for creating the conditions for sending the notification.
 * 
 * This class specifies a logical expression conditions that determine the message destination.
 * Available Condition: topic, formatted as "'your topic' on topics". This value is not case-sensitive.
 * Available operators: &&, ||. They are allowed a maximum of two operators by topic message.
 * 
 * @see FirebaseMessaging::setCondition()
 * @package FirebaseMessaging
 */
class FirebaseCondition
{
    /** @var Integer $countOperations Count the number of logical operators (&& and ||). The maximum is 3. */
    private $countOperations = 0;
    
    /** @var Array $conditionOpened Used to validate the conditions. */
    private $conditionOpened = [];
    
    /** @var String $operation Condition created. */
    private $operation;
    
    /**
     * Construct
     * 
     * @param string $topicName
     * 
     * @throws InvalidArgumentException When the topic name is not a string.
     * 
     * @return FirebaseMessaging\FirebaseCondition;
     */
    public function __construct($topicName)
    {
        $this->validateTopic($topicName);
        $this->operation = "'{$topicName}' in topics";
        $this->countOperations++;
        
        return $this;
    }
    
    /**
     * Add topic using logical operator &&
     *
     * @param string $topicName
     * 
     * @throws OutOfBoundsException When the total amount of the logical operator is higher than allowed.
     * @throws InvalidArgumentException When the topic name is not a string.
     *
     * @return FirebaseMessaging\FirebaseCondition;
     */
    public function andInTopics($topicName)
    {
        $this->validateTopic($topicName);
        $this->operation .= " && '{$topicName}' in topics";
        $this->countOperations++;
        
        return $this;
    }
    
    /**
     * Add topic using logical operator ||
     *
     * @param string $topicName
     * 
     * @throws OutOfBoundsException When the total amount of the logical operator is higher than allowed.
     * @throws InvalidArgumentException When the topic name is not a string.
     *
     * @return FirebaseMessaging\FirebaseCondition;
     */
    public function orInTopics($topicName)
    {
        $this->validateTopic($topicName);
        $this->operation .= " || '{$topicName}' in topics";
        $this->countOperations++;
        
        return $this;
    }
    
    /**
     * Add a sub condition using the logical operator &&
     *
     * @param string $topicName
     * 
     * @throws OutOfBoundsException When the total amount of the logical operator is higher than allowed.
     * @throws InvalidArgumentException When the topic name is not a string.
     *
     * @return FirebaseMessaging\FirebaseCondition;
     */
    public function openAnd($topicName)
    {
        $this->validateTopic($topicName);
        $this->operation .= " && ('{$topicName}' in topics";
        $this->countOperations++;
        $this->conditionOpened[] = true;
        
        return $this;
    }
    
    /**
     * Close sub condition
     * 
     * @throws OutOfBoundsException When the total amount of the logical operator is higher than allowed.
     * @throws InvalidArgumentException When the topic name is not a string.
     *
     * @return FirebaseMessaging\FirebaseCondition;
     */
    public function closeAnd()
    {
        $this->operation .= ")";
        array_shift($this->conditionOpened);
        
        return $this;
    }
    
    /**
     * Add a sub condition using the logical operator ||
     *
     * @param string $topicName
     * 
     * @throws OutOfBoundsException When the total amount of the logical operator is higher than allowed.
     * @throws InvalidArgumentException When the topic name is not a string.
     *
     * @return FirebaseMessaging\FirebaseCondition;
     */
    public function openOr($topicName)
    {
        $this->validateTopic($topicName);
        $this->operation .= " || ('{$topicName}' in topics";
        $this->countOperations++;
        $this->conditionOpened[] = true;
        
        return $this;
    }
    
    /**
     * Close sub condition
     * 
     * @throws OutOfBoundsException When the total amount of the logical operator is higher than allowed.
     * @throws InvalidArgumentException When the topic name is not a string.
     *
     * @return FirebaseMessaging\FirebaseCondition;
     */
    public function closeOr()
    {
        $this->operation .= ")";
        array_shift($this->conditionOpened);
    }
    
    /**
     * Validate the syntax created condition.
     *
     * @return Boolean;
     */
    public function isValid()
    {
        if (!empty($this->conditionOpened)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Return condition created.
     *
     * @return String
     */
    public function getData()
    {
        return $this->operation;
    }
    
    /**
     * Return condition created.
     * 
     * @return String
     */
    public function __toString()
    {
        return $this->operation;
    }
    
    /**
     * Validate the topic name
     * 
     * @param String $topicName
     * 
     * @throws OutOfBoundsException When the total amount of the logical operator is higher than allowed.
     * @throws InvalidArgumentException When the topic name is not a string.
     *
     * @return Boolean
     */
    private function validateTopic($topicName)
    {
        if ($this->countOperations > 3) {
            throw new \OutOfBoundsException("Invalid condition: Only support up to 3 conditions");
        } elseif (!is_string($topicName) || empty(trim($topicName))) {
            throw new \InvalidArgumentException("The topic name must not be null, array or empty.");
        } else {
            return true;
        }
    }
}
