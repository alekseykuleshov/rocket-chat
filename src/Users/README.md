You have to be [logged in](../../README.md) and have relevant permissions.

### USER LISTING

```php
$listing = \ATDev\RocketChat\Users\User::listing();

if (!$result) {

	// Log the error
	$error = \ATDev\RocketChat\Users\User::getError();
}
```

### CREATE USER

```php
$user = new \ATDev\RocketChat\Users\User();
$user->setName("John Doe");
$user->setEmail("john@example.com");
$user->setUsername("jDoe");
$user->setPassword("123456");

$result = $user->create();

if (!$result) {

	// Log the error
	$error = $user->getError();
}
```

### GET USER INFO

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");

$result = $user->info();

if (!$result) {

	// Log the error
	$error = $user->getError();
}
```

### UPDATE USER

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$result = $user->info(); // Get info so that all existing info is preserved

$user->setName("New Doe");

$result = $user->update();

if (!$result) {

	// Log the error
	$error = $user->getError();
}
```

### UPDATE USER AVATAR FROM LOCAL FILE

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$avatar = new \ATDev\RocketChat\Users\AvatarFromFile("[PATH TO LOCAL READABLE FILE]");

$result = $updateUser->setAvatar($avatar);

if (!$result) {

	// Log the error
	$error = $user->getError();
}
```

### UPDATE USER AVATAR FROM URL

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$avatar = new \ATDev\RocketChat\Users\AvatarFromDomain("[URL TO FILE AVAILABLE IN PUBLIC]");

$result = $updateUser->setAvatar($avatar);

if (!$result) {

	// Log the error
	$error = $user->getError();
}
```

### GET USER AVATAR

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");

$result = $user->getAvatar();

if (!$result) {

	// Log the error
	$error = $user->getError();
} else {

	// Url to new user avatar
	$user->getAvatarUrl();
}
```

### DELETE USER

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");

$result = $user->delete();

if (!$result) {

	// Log the error
	$error = $user->getError();
}
```




