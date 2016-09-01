<?php
namespace FirebaseMessaging;

class FirebaseNotification
{
    /** @var String Title */
    private $title;
    
    /** @var String Indicates the body text of the notification. */
    private $body;
    
    /** @var String Indicates the icon in the notification. */
    private $icon;
    
    /** @var String It indicates a sound to play when the device receives a notification. */
    private $sound;
    
    /** @var String Indicates the icon indicator of the client application homepage. */
    private $badge;
    
    /** @var String It indicates whether each notification results in a new entry in the Android notifications drawer. */
    private $tag;
    
    /** @var String Indicates the color of the icon. */
    private $color;
    
    /** @var String Indicates the action associated with a user click on the notification. */
    private $clickAction;
    
    /** @var String Indicates the body string key to location. */
    private $bodyLocKey;
    
    /** @var Array Indicates the string to replace the format specifiers in the string body for location. */
    private $bodyLocArgs;
    
    /** @var String Indicates the title string to key location. */
    private $titleLocKey;
    
    /** @var Array Indicates the string to replace the format specifiers in the string title for location. */
    private $titleLocArgs;

    /**
     * Title of the Notification
     * 
     * @return String
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Indicates the title of the notification. This field is not visible in mobile phones and iOS tablets.
     * Android Required, iOS Opcional
     * 
     * @param String $title
     * 
     * @return FirebaseMessaging\Notification
     */
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }

    /**
     * Body of the notification.
     * 
     * @return String
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Indicates the body text of the notification.
     * iOS Opcional, Android Opcional
     * 
     * @param String $body
     * 
     * @return FirebaseMessaging\Notification
     */
    public function setBody($body)
    {
        $this->body = $body;
        
        return $this;
    }

    /**
     * Icon in the notification.
     * 
     * @return String
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Indicates the icon in the notification. Sets the value to Mylicon for the resource drawable myicon.
     * The icon should is in res/drawable
     * Android Required
     * 
     * @param String $icon
     * 
     * @return FirebaseMessaging\Notification
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        
        return $this;
    }

    /**
     * Sound Notification.
     * 
     * @return String
     */
    public function getSound()
    {
        return $this->sound;
    }

    /**
     * It indicates a sound to play when the device receives a notification. Compatible with default or file name of a sound
     * feature bundled in the application.
     * Android sound files should reside in /res/raw/ iOS and sound files may be in the main package client application or 
     * the Library/Sounds folder application data container.
     * iOS Opcional, Android Opcional
     * 
     * @param String $sound
     * 
     * @return FirebaseMessaging\Notification
     */
    public function setSound($sound)
    {
        $this->sound = $sound;
        
        return $this;
    }

    /**
     * Indicator of the client application homepage.
     * 
     * @return String
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * Indicates the icon indicator of the client application homepage.
     * iOS Opcional
     * 
     * @param String $badge
     * 
     * @return FirebaseMessaging\Notification
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;
        
        return $this;
    }

    /** 
     * Tag
     * 
     * @return String
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * It indicates whether each notification results in a new entry in the Android notifications drawer.
     * If not set, each request will create a new notification.
     * If set and a notification with the same tag is already displayed, the new notice will replace the existing
     * notification in the notifications drawer.
     * Android Opcional
     * 
     * @param String $tag
     * 
     * @return FirebaseMessaging\Notification
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        
        return $this;
    }

    /**
     * Color notification.
     * 
     * @return String
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Indicates the color of the icon expressed in #rrggbb format.
     * Android Opcional
     * 
     * @param String $color
     * 
     * @return FirebaseMessaging\Notification
     */
    public function setColor($color)
    {
        if (!preg_match("/^[#][A-Fa-f0-9]{6}/", $color)) {
            throw new \InvalidArgumentException("Icon expressed in #rrggbb format.");
        }
        
        $this->color = $color;
        
        return $this;
    }

    /**
     * Return the action associated with a user click on the notification.
     * 
     * @return String
     */
    public function getClickAction()
    {
        return $this->clickAction;
    }

    /**
     * Indicates the action associated with a user click on the notification.
     * If set on iOS, it matches the category in the payload of APNs.
     * On Android, if this parameter is set, an activity with a corresponding intent filter is initiated
     * when the user clicks the notification.
     * iOS Opcional, Android Opcional
     * 
     * @param String $clickAction
     * 
     * @return FirebaseMessaging\Notification
     */
    public function setClickAction($clickAction)
    {
        $this->clickAction = $clickAction;
        
        return $this;
    }

    /**
     * Indicates the string to replace the format specifiers in the string body for location.
     * 
     * @return String
     */
    public function getBodyLocKey()
    {
        return $this->bodyLocKey;
    }

    /**
     * Indicates the body string key to location.
     * IOS, corresponds to "loc-key" in the payload of APNs.
     * On Android, use the key in the application's string resources to fill that value.
     * iOS Opcional, Android Opcional
     * 
     * @param String $bodyLocKey
     */
    public function setBodyLocKey($bodyLocKey)
    {
        $this->bodyLocKey = $bodyLocKey;
        
        return $this;
    }

    /**
     * Indicates the string to replace the format specifiers in the string body for location.
     * 
     * @return Array
     */
    public function getBodyLocArgs()
    {
        return $this->bodyLocArgs;
    }

    /**
     * Indicates the string to replace the format specifiers in the string body for location.
     * IOS, corresponds to "loc-args" in the payload of APNs.
     * On Android, these are the arguments for format string resources.
     * iOS Opcional, Android Opcional
     * 
     * @param Array $bodyLocArgs
     * 
     * @return FirebaseMessaging\Notification
     */
    public function setBodyLocArgs(array $bodyLocArgs)
    {
        $this->bodyLocArgs = $bodyLocArgs;
        
        return $this;
    }

    /**
     * Indicates the title string to key location.
     * 
     * @return String
     */
    public function getTitleLocKey()
    {
        return $this->titleLocKey;
    }

    /**
     * Indicates the title string to key location.
     * IOS, corresponding to "title-loc-key" in the payload of APNs.
     * On Android, use the key in the application's string resources to fill that value.
     * 
     * @param String $titleLocKey
     * 
     * @return FirebaseMessaging\Notification
     */
    public function setTitleLocKey($titleLocKey)
    {
        $this->titleLocKey = $titleLocKey;
        
        return $this;
    }

    /**
     * Indicates the string to replace the format specifiers in the string title for location.
     * 
     * @return Array
     */
    public function getTitleLocArgs()
    {
        return $this->titleLocArgs;
    }

    /**
     * Indicates the string to replace the format specifiers in the string title for location.
     * IOS, corresponding to "title-loc-args" in the payload of APNs.
     * On Android, these are the arguments for format string resources.
     * 
     * @param Array $titleLocArgs
     * 
     * @return FirebaseMessaging\Notification
     */
    public function setTitleLocArgs(array $titleLocArgs)
    {
        $this->titleLocArgs = $titleLocArgs;
        
        return $this;
    }
    
    /**
     * Returns a array with the value of the variables of the class.
     *
     * @return array
     */
    public function getData()
    {
        return json_decode((string)$this, true);
    }

    /**
     * Returns a json with the value of the variables of the class.
     *
     * @return json
     */
    public function __toString()
    {
        $params = get_object_vars($this);
        $result = [];
        
        foreach ($params as $key => $value) {
            $key = strtolower(preg_replace("/([A-Z])/", "_$1", $key));
            
            if (!is_null($value)) {
                $result[$key] = $value;
            }
        }
        
        return json_encode($result);
    }
    
}