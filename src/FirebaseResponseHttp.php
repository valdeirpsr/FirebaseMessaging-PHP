<?php
namespace FirebaseMessaging;

/**
 * Class responsible for storing the response of the request.
 * 
 * @see FirebaseMessaging::send()
 * @package FirebaseMessaging
 */
class FirebaseResponseHttp
{
    /** @var String $messageId Message ID */
    private $messageId;
    
    /** @var String $multicastId Multicast ID */
    private $multicastId;
    
    /** @var String $success Success */
    private $success;
    
    /** @var String $failure Failure */
    private $failure;
    
    /** @var String $canonicalIds Canonical Ids */
    private $canonicalIds;
    
    /** @var String $results Results */
    private $results = [];
    
    /**
     * Construct
     * 
     * @param array $response
     */
    public function __construct(array $response)
    {
        if (isset($response['message_id'])) {
            $this->messageId = $response['message_id'];
        }
        
        if (isset($response['multicast_id'])) {
            $this->multicastId = $response['multicast_id'];
        }
        
        if (isset($response['success'])) {
            $this->success = (int)$response['success'];
        }
        
        if (isset($response['failure'])) {
            $this->failure = (int)$response['failure'];
        }

        if (isset($response['canonical_ids'])) {
            $this->canonicalIds = (int)$response['canonical_ids'];
        }

        if (isset($response['results'])) {
            $this->setResults($response['results']);
        }
    }
        
    /**
     * The topic message ID when the FCM correctly received the request and will attempt to deliver to all registered devices.
     * 
     * @return Integer
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * The topic message ID when the FCM correctly received the request and will attempt to deliver to all registered devices.
     * 
     * @param Integer $messageId
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * Unique ID (number) that identifies the multicast message.
     * 
     * @return Integer
     */
    public function getMulticastId()
    {
        return $this->multicastId;
    }

    /**
     * Number of messages processed without error.
     * 
     * @return Integer
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Number of unprocessed messages.
     * 
     * @return Integer
     */
    public function getFailure()
    {
        return $this->failure;
    }

    /**
     * Number of results that contain a canonical registration token.
     * 
     * @return Integer
     */
    public function getCanonicalIds()
    {
        return $this->canonicalIds;
    }

    /**
     * Array of objects representing the status of messages processed.
     * 
     * @return Array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Set unique ID (number) that identifies the multicast message.
     * 
     * @param Integer $multicastId
     */
    public function setMulticastId($multicastId)
    {
        if (is_int($multicastId)) {
            $this->multicastId = $multicastId;
        } else {
            throw new \InvalidArgumentException("The value must be an integer.");
        }
    }

    /**
     * Set number of messages processed without error.
     * 
     * @param Integer $success
     */
    public function setSuccess($success)
    {
        if (is_int($success)) {
            $this->$success = $success;
        } else {
            throw new \InvalidArgumentException("The value must be an integer.");
        }
    }

    /**
     * Set number of unprocessed messages.
     * 
     * @param Integer $failure
     */
    public function setFailure($failure)
    {
        if (is_int($failure)) {
            $this->failure = $failure;
        } else {
            throw new \InvalidArgumentException("The value must be an integer.");
        }
    }

    /**
     * Set number of results that contain a canonical registration token.
     * 
     * @param Integer $canonicalIds
     */
    public function setCanonicalIds($canonicalIds)
    {
        if (is_int($canonicalIds)) {
            $this->canonicalIds = $canonicalIds;
        } else {
            throw new \InvalidArgumentException("The value must be an integer.");
        }
    }

    /**
     * Set results
     * 
     * @param String|null $results
     */
    public function setResults($results)
    {
        if (is_array($results)) {
            foreach($results as $key => $result) {
                $this->results[$key] = new \stdClass();
                
                if (isset($result['messageId']))
                    $this->results[$key]->messageId = $result['messageId'];
                
                if (isset($result['registration_id']))
                    $this->results[$key]->registrationId = $result['registration_id'];
                
                if (isset($result['error']))
                    $this->results[$key]->error = $result['error'];
            }
        }
    }

    
    
}