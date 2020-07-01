You have to be [logged in](../..) and have relevant permissions.

### DIRECT MESSAGE LISTING

```php
$listing = \ATDev\RocketChat\Ims\Im::listing();

if (!$listing) {

	// Log the error
	$error = \ATDev\RocketChat\Ims\Im::getError();
}
```

### CREATE DIRECT MESSAGE SESSION

```php
$im = new \ATDev\RocketChat\Ims\Im();
$im->setUsername("[USERNAME]");
$im->setUsernames("username_first, username_second, username_third");

$result = $im->create();

if (!$result) {

	// Log the error
	$error = $im->getError();
}
```

### OPEN DIRECT MESSAGE

```php
$im = new \ATDev\RocketChat\Ims\Im("[DIRECT MESSAGE ID]");

$result = $im->open();

if (!$result) {

	// Log the error
	$error = $im->getError();
}
```

### CLOSE DIRECT MESSAGE

```php
$im = new \ATDev\RocketChat\Ims\Im("[DIRECT MESSAGE ID]");

$result = $im->close();

if (!$result) {

	// Log the error
	$error = $im->getError();
}
```

### GET COUNTERS OF DIRECT MESSAGES

```php
$im = new \ATDev\RocketChat\Ims\Im("[DIRECT MESSAGE ID]");
$im->setUsername("[USERNAME]");

$result = $im->counters();

if (!$result) {

	// Log the error
	$error = $im->getError();
}
```

### GET MESSAGES FROM A DIRECT MESSAGE

```php
$im = new \ATDev\RocketChat\Ims\Im("[DIRECT MESSAGE ID]");
$im->setLatest("2016-09-30T13:42:25.304Z");
$im->setOldest("2016-05-30T13:42:25.304Z");
$im->setInclusive(true);
$im->setUnreads(true);

$result = $im->history();

if (!$result) {

	// Log the error
	$error = $im->getError();
}
```

### LISTS ALL THE DIRECT MESSAGES ON THE SERVER

```php
$im = new \ATDev\RocketChat\Ims\Im();

$result = $im->listEveryone();

if (!$result) {

	// Log the error
	$error = $im->getError();
}
```

### LISTS THE USERS OF PARTICIPANTS OF A DIRECT MESSAGE

```php
$im = new \ATDev\RocketChat\Ims\Im();
$im->setDirectMessageId("[DIRECT MESSAGE ID");
$im->setUsername("[USERNAME]");

$result = $im->members();

if (!$result) {

	// Log the error
	$error = $im->getError();
}
```
