# Firebase Messaging PHP

### Installation using composer

```
composer require code-of-brain/firebase-messaging-php
```

### Send Notification to Client

```php
use FirebaseMessagingPhp\FirebaseClient;
use FirebaseMessagingPhp\Notification;

$client = new FirebaseClient(SERVER_KEY);

$notification = new Notification();
$notification->setPriority('high');
$notification->setTitle('title');
$notification->setBody('body');
$notification->addToken('CLIENT_TOKEN');

$response = $client->send($notification);

var_dump($response->getStatusCode());
```

### Send Notification to Multiple Clients

#### Method 1

```php
use FirebaseMessagingPhp\FirebaseClient;
use FirebaseMessagingPhp\Notification;

$client = new FirebaseClient(SERVER_KEY);

$notification = new Notification();
$notification->setPriority('high');
$notification->setTitle('title');
$notification->setBody('body');
$notification->addToken('CLIENT_TOKEN_1');
$notification->addToken('CLIENT_TOKEN_2');
$notification->addToken('CLIENT_TOKEN_3');
$notification->addToken('CLIENT_TOKEN_4');

$response = $client->send($notification);

var_dump($response->getStatusCode());
```

#### Method 2

```php
use FirebaseMessagingPhp\FirebaseClient;
use FirebaseMessagingPhp\Notification;

$client = new FirebaseClient(SERVER_KEY);

$notification = new Notification();
$notification->setPriority('high');
$notification->setTitle('title');
$notification->setBody('body');

$tokens = ['CLIENT_TOKEN_1', 'CLIENT_TOKEN_2', 'CLIENT_TOKEN_3'];

$notification->addTokens($tokens);

$response = $client->send($notification);

var_dump($response->getStatusCode());
```
