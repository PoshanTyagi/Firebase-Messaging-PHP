# Firebase Messaging PHP

## Installation using composer

```shell
composer require code-of-brain/firebase-messaging-php
```

## Send Notification to Client

```php
use FirebaseMessagingPhp\FirebaseClient;
use FirebaseMessagingPhp\FirebaseNotification;

$client = new FirebaseClient(SERVER_KEY);

$notification = new FirebaseNotification();

$notification->setTitle('title')
    ->setBody('body');

$clientToken = ['CLIENT_ID_1' => 'CLIENT_TOKEN_1'];

$response = $client->send($notification, $clientToken);

var_dump($response);
```

## Send Notification to Multiple Clients

```php
use FirebaseMessagingPhp\FirebaseClient;
use FirebaseMessagingPhp\FirebaseNotification;

$client = new FirebaseClient(SERVER_KEY);

$notification = new FirebaseNotification();

$notification->setTitle('title');
    ->setBody('body');

$clientTokens = ['CLIENT_ID_1' => 'CLIENT_TOKEN_1', 'CLIENT_ID_2' => 'CLIENT_TOKEN_2', 'CLIENT_ID_3' => 'CLIENT_TOKEN_3'];

$response = $client->send($notification, $clientTokens);

var_dump($response);
```

## Clients Token Verification

```php
use FirebaseMessagingPhp\FirebaseClient;
use FirebaseMessagingPhp\FirebaseNotification;

$client = new FirebaseClient(SERVER_KEY);

$clientTokens = ['CLIENT_ID_1' => 'CLIENT_TOKEN_1', 'CLIENT_ID_2' => 'CLIENT_TOKEN_2', 'CLIENT_ID_3' => 'CLIENT_TOKEN_3'];

$response = $client->verifyTokens($clientTokens);

var_dump($response);
```

## Optional Parameters

```php
$notification = new FirebaseNotification();

// You can add priority to notification by using setPriority method 
// Priority can be 'high' and 'normal' 
// By default priority is 'normal'

$notification->setPriority('high');

// You can add extra data to notification by using setData method 
// Data should be a array of string key-value pair

$notification->setData(array('name' => 'user', 'id' => '1111'));

// This method is use to specifies how long (in seconds) the message should be kept in FCM storage if the device is offline
// The maximum time to live supported is 4 weeks, and the default value is 4 weeks

$notification->setTimeToLive( 60 * 60 ); // 60 * 60 = 3600 means message should be kept in FCM storage for 3600 seconds (1 hour)

```
