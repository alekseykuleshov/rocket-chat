You have to be [logged in](../../README.md) and have relevant permissions.

### GET MESSAGE

```php
$message = new \ATDev\RocketChat\Messages\Message();
$message->setMessageId("[MESSAGE ID]");
$result = $message->getMessage();

if (!$result) {
	// Log the error
	$error = $message->getError();
}
```

### POST MESSAGE

```php
$message = new \ATDev\RocketChat\Messages\Message();
$message->setRoomId("[ROOM ID]");
$message->setText("Message text");
$result = $message->postMessage();

if (!$result) {
	// Log the error
	$error = $message->getError();
}
```

### UPDATE MESSAGE

```php
$message = new \ATDev\RocketChat\Messages\Message();
$message->setRoomId("[ROOM ID]");
$message->setMessageId("[MESSAGE ID]");
$message->setText("Updated message text");
$result = $message->update();

if (!$result) {
	// Log the error
	$error = $message->getError();
}
```

### DELETE MESSAGE

```php
$message = new \ATDev\RocketChat\Messages\Message();
$message->setRoomId("[ROOM ID]");
$message->setMessageId("[MESSAGE ID]");
$result = $message->delete();

if (!$result) {
	// Log the error
	$error = $message->getError();
}
```