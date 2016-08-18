<?php
namespace FirebaseMessaging;

use Curl\Curl;
use FirebaseMessaging\Exception\UnauthorizedException;

/**
 * Class responsible for sending notifications.
 * 
 * @package FirebaseMessaging
 */
class FirebaseMessaging
{
    /** @var Integer ANDROID */
    Const OS_ANDROID = 1;
    
    /** @var Integer IOS */
    Const OS_IOS = 2;
    
    /** @var Integer ANDROID */
    Const OS_BOTH = 0;
    
    /** @var Integer PRIORITY_NORMAL */
    Const PRIORITY_NORMAL = "normal";
    
    /** @var Integer PRIORITY_NORMAL */
    Const PRIORITY_HIGH = "high";
    
    /** @var String $serverKey  */
    private $serverKey;
    
    /** @var String To */
    private $to;
    
    /** @var Array Registration_Ids */
    private $registrationIds;
    
    /** @var String Condition */
    private $condition;
    
    /** @var String collapse_key */
    private $collapseKey;
    
    /** @var String priority */
    private $priority;
    
    /** @var Boolean content_available  */
    private $contentAvailable;
    
    /** @var Boolean delay_while_idle */
    private $delayWhileIdle;
    
    /** @var Integer time_to_live */
    private $timeToLive;
    
    /** @var String restricted_package_name */
    private $restrictedPackageName;
    
    /** @var Boolean dry_run */
    private $dry_run;
    
    /** @var Array data */
    private $data;
    
    /** @var FirebaseMessaging\Notification notification */
    private $notification;
    
    /** @var String Used to validate the notification. */
    private $operacionalSystem;
    
    /**
     * Create a new object
     * 
     * @param String $serverKey
     * 
     * @return FirebaseMessaging;
     */
    public function __construct($serverKey)
    {
        if (!is_string($serverKey) || empty(trim($serverKey)) ) {
            throw new \InvalidArgumentException("Not null");
        }
        
        $this->serverKey = (string)$serverKey;
        
        return $this;
    }
    
    /**
     * Return the server key
     * 
     * @return String
     */
    public function getServerKey()
    {
        return $this->serverKey;
    }

    /**
     * Return the the recipient of a message
     * 
     * @return String
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Specifies the recipient of a message.
     * The value must be a register token, a notification key or a topic. Do not set this field to send multiple topics.
     * 
     * To send to multiple topics see: FirebaseMessaging\FirebaseCondition;
     * 
     * @param String $to
     * 
     * @return FirebaseMessaging;
     */
    public function setTo($to)
    {
        $this->to = $to;
        $this->condition = null;
        $this->registrationIds = null;
        return $this;
    }

    /**
     * Return the list of devices (registration tokens or IDs) that receive a multicast message.
     * 
     * @return Array
     */
    public function getRegistrationIds()
    {
        return $this->registrationIds;
    }

    /**
     * This parameter specifies a list of devices (registration tokens or IDs) that receive a multicast message.
     * It must contain between 1 and 1,000 register tokens.
     * 
     * @param array $registrationIds
     * 
     * @return FirebaseMessaging;
     */
    public function setRegistrationIds(array $registrationIds)
    {
        if (count($registrationIds) < 1 || count($registrationIds) > 1000 ) {
            throw new \InvalidArgumentException("It must contain between 1 and 1,000 register tokens.");
        }
        
        $this->registrationIds = $registrationIds;
        $this->to = null;
        return $this;
    }

    /**
     * Return the logical expression conditions that determine the message destination.
     * 
     * @return FirebaseCondition;
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * Set condition
     * 
     * @param FirebaseCondition $condition
     * 
     * @throws \UnexpectedValueException When the condition is invalid.
     * 
     * @return FirebaseMessaging;
     */
    public function setCondition(FirebaseCondition $condition)
    {
        if (!$condition->isValid()) {
            throw new \UnexpectedValueException("Invalid condition: Wrong filter expression syntax");
        }
        
        $this->condition = $condition;
        $this->to = null;
        return $this;
    }

    /**
     * Return the identifies a group of messages
     * 
     * @return String
     */
    public function getCollapseKey()
    {
        return $this->collapseKey;
    }

    /**
     * This parameter identifies a group of messages (for example, collapse_key "Updates Available") that can be taken
     * for only the last message is sent when it is possible to resume delivery. This aims to avoid sending an excessive
     * number of identical messages when the device is online or active again
     * 
     * @param String $collapseKey
     * 
     * @return FirebaseMessaging;
     */
    public function setCollapseKey($collapseKey)
    {
        $this->collapseKey = $collapseKey;
        return $this;
    }

    /**
     * Return the message priority
     * 
     * @return String
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set the message priority. Valid values are "normal" and "high". IOS, correspond to the priorities of 5 and 10 APNs.
     * 
     * @param String $priority
     * 
     * @throws \InvalidArgumentException If the parameter is different from normal and high.
     * 
     * @return FirebaseMessaging;
     */
    public function setPriority($priority)
    {
        if ($priority != self::PRIORITY_NORMAL && $priority != self::PRIORITY_HIGH) {
            throw new \InvalidArgumentException("The priority value should be Normal or High.");
        } else {
            $this->priority = $priority;
            return $this;
        }
    }

    /**
     * Return the content available
     * 
     * @return Boolean
     */
    public function getContentAvailable()
    {
        return $this->contentAvailable;
    }

    /**
     * IOS, use this field to represent content-available payload of APNs.
     * When a notification or message is sent and this parameter is set to true, an application inactive client is triggered.
     * In Android, by default, data messages trigger the application. No compatibility with Chrome.
     * 
     * @param Boolean $contentAvailable
     * 
     * @return FirebaseMessaging;
     */
    public function setContentAvailable($contentAvailable)
    {
        $this->contentAvailable = (bool)$contentAvailable;
        return $this;
    }

    /**
     * Returns true if it is determined that the device should only get the message when you are awake.
     * 
     * @return Boolean
     */
    public function getDelayWhileIdle()
    {
        return $this->delayWhileIdle;
    }

    /**
     * When this parameter is set to true, the message must not be sent to the device is active.
     * 
     * @param Boolean $delayWhileIdle
     * 
     * @return FirebaseMessaging;
     */
    public function setDelayWhileIdle($delayWhileIdle)
    {
        $this->delayWhileIdle = (bool)$delayWhileIdle;
        return $this;
    }

    /**
     * Return the message lifetime.
     * 
     * @return Integer
     */
    public function getTimeToLive()
    {
        return $this->timeToLive;
    }

    /**
     * This parameter specifies how long (in seconds) the message should be kept in the FCM storage if the device goes offline.
     * The maximum service life allowed is 4 weeks.
     * 
     * @param Integer $timeToLive
     * 
     * @return FirebaseMessaging;
     */
    public function setTimeToLive($timeToLive)
    {
        if (!is_int($timeToLive)) {
            throw new \InvalidArgumentException("The value must be an integer.");
        } elseif ($timeToLive > 2419200) {
            throw new \OutOfBoundsException("The maximum service life allowed is 4 weeks.");
        }
        
        $this->timeToLive = $timeToLive;
        return $this;
    }

    /**
     * Return the package name
     * 
     * @return String
     */
    public function getRestrictedPackageName()
    {
        return $this->restrictedPackageName;
    }

    /**
     * This parameter specifies the application package name whose registration tokens must match to get the message.
     * 
     * @param field_type $restrictedPackageName
     * 
     * @return FirebaseMessaging;
     */
    public function setRestrictedPackageName($restrictedPackageName)
    {
        $this->restrictedPackageName = $restrictedPackageName;
        return $this;
    }

    /**
     * Return true if set to development mode.
     * 
     * @return Boolean
     */
    public function getDevelopmentMode()
    {
        return $this->dry_run;
    }

    /**
     * When set to true, this parameter enables developers to test an application without actually sending a message.
     * 
     * @param Boolean $developmentMode
     * 
     * @return FirebaseMessaging;
     */
    public function setDevelopmentMode($developmentMode)
    {
        $this->dry_run = (bool)$developmentMode;
        return $this;
    }

    /**
     * Return the variables that will be sent to the device.
     * 
     * @return String
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * This parameter specifies the custom key-value pairs of message payload.
     * On iOS, if the message is sent through the APNs, it is custom data fields. If it is sent by FCM connection server,
     * it is represented as a key-value dictionary AppDelegate application:didReceiveRemoteNotification:.
     * 
     * On Android, this would result in an additional call intention score with the string value of 3x1.
     * 
     * The key should not be a reserved word ("of" or any word beginning with "google" or "gcm").
     * 
     * @param Array $data
     * 
     * @return FirebaseMessaging;
     */
    public function setData(array $data)
    {
        foreach($data as $key => $value) {
            if (preg_match("/^(google|gcm)/", $key) || strpos($key, " of ")) {
                throw new \InvalidArgumentException("The key should not be a reserved word (\"of\" or any word beginning with \"google\" or \"gcm\").");
            }
        }
        
        $this->data = $data;
        return $this;
    }

    /**
     * Return the notification settings.
     * 
     * @return FirebaseNotification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Sets specifies the default key-value pairs Payload visible notification to the user....
     * 
     * @param FirebaseMessaging\Notification $notification
     * 
     * @return FirebaseMessaging;
     */
    public function setNotification(FirebaseNotification $notification)
    {
        $androidRequired = ($this->operacionalSystem === self::OS_ANDROID || $this->operacionalSystem === self::OS_BOTH);
        
        if ($androidRequired) {
            if (is_null($notification->getTitle())) {
                throw new Exception\NotificationException("Title is required");
            }
        }
        
        
        $this->notification = $notification;
        return $this;
    }

    /**
     * Return the operacional system
     * 
     * @return String
     */
    public function getOperacionalSystem()
    {
        return $this->operacionalSystem;
    }

    /**
     * Sets the operating system where the application is running.
     * 
     * @param Integer $operacionalSystem
     * 
     * @return FirebaseMessaging;
     */
    public function setOperacionalSystem($operacionalSystem)
    {
        switch ($operacionalSystem) {
            case self::OS_ANDROID:
                $this->operacionalSystem = (int)$operacionalSystem;
                break;
            case self::OS_IOS:
                $this->operacionalSystem = (int)$operacionalSystem;
                break;
            case self::OS_BOTH:
                $this->operacionalSystem = (int)$operacionalSystem;
                break;
            default:
                throw new \InvalidArgumentException("The value must be Messaging::ANDROID or Messaging::IOS or Messaging::ANY.");
        }
        return $this;
    }
    
    /**
     * Send the message to the Firebase
     * 
     * @see FirebaseMessaging::setTo
     * @see FirebaseMessaging::setRegistrationIds
     * @see FirebaseMessaging::setCondition
     * 
     * @throws \Exception                      If an error occurs in the request
     * @throws Exception\UnauthorizedException If you have informed an invalid key.
     * @throws \UnexpectedValueException
     * 
     * @return FirebaseResponseHttp
     */
    public function send()
    {
        $curl = new Curl();
        $curl->setHeader("Content-Type", "application/json");
        $curl->setHeader("Authorization", "key={$this->serverKey}");
        $curl->setUserAgent("ValdeirPsr/FirebaseMessaging-PHP");
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $curl->post("https://fcm.googleapis.com/fcm/send", $this->getJson());
        
        if ($curl->error === true && $curl->http_status_code != 401) {
            throw new \Exception($curl->error_message, $curl->error_code);
        }
        
        if ($curl->http_status_code == 401) {
            throw new Exception\UnauthorizedException("Unauthorized");
        }
        
        if (preg_match("/^[5]/", $curl->http_status_code)) {
            throw new \UnexpectedValueException("Internal Server Error");
        }
        
        $response = json_decode($curl->response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \UnexpectedValueException("Response invalid");
        }
        
        return new FirebaseResponseHttp($response);
    }
    
    /**
     * Returns a json with the value of the variables of the class.
     * 
     * @return String
     */
    public function getJson()
    {
        $block = ["operacional_system", "server_key"];
        $params = get_object_vars($this);
        $result = [];
    
        foreach ($params as $key => $value) {
            $key = strtolower(preg_replace("/([A-Z])/", "_$1", $key));
            
            if (!is_null($value) && !in_array($key, $block)) {
                if (is_object($value)) {
                    $result[$key] = $value->getData();
                } else {
                    $result[$key] = $value;
                }
            }
        }
    
        return json_encode($result, JSON_PRETTY_PRINT);
    }
}