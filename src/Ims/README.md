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

$result = $im->create();

if (!$result) {

	// Log the error
	$error = $im->getError();
}
```

### CREATE MULTIPLE DIRECT MESSAGE SESSION

```php
$im = new \ATDev\RocketChat\Ims\Im();
$im->setUsernames("username_first, username_second, username_third");

$result = $im->create();

if (!$result) {

	// Log the error
	$error = $im->getError();
}
```