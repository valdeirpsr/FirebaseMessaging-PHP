# ValdeirPsr/FirebaseMessaging-PHP

Send messages to mobile devices with Google Firebase.

### Installation
`composer require valdeirpsr/firebasemessaging-php`

### Sending A Basic Notification
```php
require "vendor/autoload.php";

use FirebaseMessaging\FirebaseMessaging;
use FirebaseMessaging\FirebaseNotification;
use FirebaseMessaging\FirebaseCondition;

$notification = new FirebaseNotification();
$notification->setTitle("Run!! New video");
$notification->setBody("Duelo de MC's - FINAL - Thaik vs Din");

$messaging = new FirebaseMessaging("serverKey");
$messaging->setTo("/topics/RapHipHop");
$messaging->setOperacionalSystem(FirebaseMessaging::OS_ANDROID);
$messaging->setNotification($notification);
$messaging->send();
```

# Sending A Complete Notification
```php
require "vendor/autoload.php";

use FirebaseMessaging\FirebaseMessaging;
use FirebaseMessaging\FirebaseNotification;
use FirebaseMessaging\FirebaseCondition;

$notification = new FirebaseNotification();
$notification->setTitle("Run!! New video");
$notification->setBody("Duelo de MC's - FINAL - Thaik vs Din");
$notification->setIcon("custom_logo");
$notification->setTag("valdeirpsr_1");
$notification->setColor("#E91E63");
$notification->setClickAction("OPEN_ACTIVITY_VIDEO");
$notification->setSound("sound_notification");

$condition = new FirebaseCondition("RapHipHop");
$condition->openAnd("DouglasDin");
$condition->orInTopics("Thaik");
$condition->closeAnd();
// output: 'RapHipHop' in topics && ('DouglasDin' in Topics || 'Thaik' in Topics)

$messaging = new FirebaseMessaging("serverKey");
$messaging->setCondition($condition);
$messaging->setPriority(FirebaseMessaging::PRIORITY_HIGH);
$messaging->setTimeToLive(2419200);
$messaging->setOperacionalSystem(FirebaseMessaging::OS_BOTH);
$messaging->setNotification($notification);
$messaging->setRestrictedPackageName("br.com.valdeirsantana.test");
$messaging->setCollapseKey("video_new");
$messaging->setDelayWhileIdle(false);
$messaging->setDevelopmentMode(false);
$messaging->setData([
    "video_id" => "ZDz-5fQAIo4",
    "title" => "Duelo de MC's - FINAL - Thaik vs Din :: Tradicional - 23/11/12",
    "channel" => "Indie BH",
    "channel_url" => "https://www.youtube.com/channel/UCBkYx1zP0aOaMXsp9As75Tg",
    "channel_id" => "UCBkYx1zP0aOaMXsp9As75Tg",
    "thumbnail" => [
        "default" => [
            "url" => "https://i.ytimg.com/vi/ZDz-5fQAIo4/default.jpg",
            "width" => "120",
            "height" => "90"
        ],
        "high" => [
            "url" => "https://i.ytimg.com/vi/ZDz-5fQAIo4/mqdefault.jpg",
            "width" => "320",
            "height" => "180"
        ],
        "high" => [
            "url" => "https://i.ytimg.com/vi/ZDz-5fQAIo4/hqdefault.jpg",
            "width" => "480",
            "height" => "360"
        ],
        "standard" => [
            "url" => "https://i.ytimg.com/vi/ZDz-5fQAIo4/sddefault.jpg",
            "width" => "640",
            "height" => "480"
        ],
        "maxres" => [
            "url" => "https://i.ytimg.com/vi/ZDz-5fQAIo4/maxresdefault.jpg",
            "width" => "1920",
            "height" => "1080"
        ]
    ]
]);

$messaging->send();
```

### Set the device that will receive the notification
This parameter specifies the recipient of a message.

The value must be a register token, a notification key or a topic. Do not set this field to send multiple topics, see **FirebaseMessaging::setCondition** for it.
```php
$messaging->setTo("RegistrationToken");
$messaging->setTo("/topics/RapHipHop");
```

### Set the devices that will receive the notification
This method specifies a list of devices (registration tokens or IDs) that receive a multicast message. It must contain between 1 and 1,000 record tokens.
```php
$messaging->setRegistrationIds([
    "RegistrationToken#1",
    "RegistrationToken#2",
    "RegistrationToken#3",
    "RegistrationToken#4",
]);
```

### Set the priority of the notification
By default, messages are sent with normal priority. Normal priority optimizes client application battery consumption and should always be used except when immediate delivery is required. For messages with normal priority, the application can get the message late unspecified.

When a message is sent with high priority, it is sent immediately and the application can trigger a device suspended and open a network connection to your server.
```php
$messaging->setPriority(FirebaseMessaging::PRIORITY_HIGH);
```

### Set a delay for idle devices.
When this parameter is set to true, the message must not be sent to the device is inactive.

Default: false
```php
$messaging->setDelayWhileIdle(true);
```

### Sending Data to Device
The key should not be a reserved word ("of" or any word beginning with "google" or "gcm"). Do not use any of the words defined in this table (as collapse_key).

They are recommended values in string types. It is necessary to convert the values to objects or other types without string data (e.g., boolean or integer numbers) to the string.
```php
$messaging->setData([
    "ClassificacaoGinasticaOlimpica" => [
        "Sanne Wevers",
        "Laurie Hernandez",
        "Simone Biles",
        "Marine Boyer",
        "Flávia Saraiva"
    ]
]);
```

## Configuring Your Notification

### Set the title of the notification
Indicates the title of the notification. This field is not visible in mobile phones and iOS tablets, only the iWatch.

Required Android; Optional iOS
```php
$notification->setTitle("My Title");
```

### Set the message notification
Indicates the body text of the notification.

Optional for Android and iOS
```php
$notification->setBody("My Message");
```

### Set the icon in the notification
Indicates the icon in the notification.

It works only on Android (Opcional). The icon should is in res/drawable
```php
$notification->setIcon("custom_icon_notification");
```

### Set the sound notification
It indicates a sound to play when the device receives a notification. Compatible with default or file name of a sound feature bundled in the application.

Android sound files should reside in / res / raw / iOS and sound files may be in the main package client application or the Library / Sounds folder application data container. [See the developer's library iOS]((https://developer.apple.com/library/ios/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Chapters/IPhoneOSClientImp.html#//apple_ref/doc/uid/TP40008194-CH103-SW6)) for more information.

Optional for Android and iOS
```php
$notification->setSound("sound_notification");
```

### Set Tag
It indicates whether each notification results in a new entry in the Android notifications tray.
If not set, each request will create a new notification.
If set and a notification with the same tag is already displayed, the new notice will replace the existing notification in the notifications drawer.

Only for Android (Optional)
```php
$notification->setTag("notification_id_1");
```

### Set the icon color
Indicates the color of the icon expressed in #rrggbb format.

Only for Android (Optional)
```php
$notification->setColor("#FF0000");
```

### Associate an action for when the user clicks the notification
Indicates the action associated with a user click on the notification.

If set on iOS, it matches the category in the payload of APNs.

On Android, if this parameter is set, an activity with a corresponding intent filter is initiated when the user clicks the notification.

Optional for Android and iOS
```php
$notification->setClickAction("OPEN_ACTIVITY_NOTIFICATION");
```

**Soon support for XMPP**