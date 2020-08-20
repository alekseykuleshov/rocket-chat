You have to be [logged in](https://github.com/alekseykuleshov/rocket-chat#login) and have relevant permissions.

### USER LISTING

```php
$listing = \ATDev\RocketChat\Users\User::listing();

if (!$listing) {

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

### UPDATE OWN BASIC INFO
```php
$user = \ATDev\RocketChat\Chat::me();
$user->setEmail('test@updated.com');
$user->setUsername('[NEW-USER-NAME]');
$user->setName('[NEW-NAME]');
$user->setPassword(hash('sha256', '[CURRENT-PASSWORD]'));
$user->setNewPassword('newPassw0rd');
$user->setCustomFields("{ twitter: '@example' }");

$updatedUser = $user->updateOwnBasicInfo();
if (!$updatedUser) {
    $error = $user->getError();
}
```

### SET ACTIVE STATUS
```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$statusResult = $user->setActiveStatus(true);
if (!$statusResult) {
    $user->getError();
}
```

### SET STATUS MESSAGE
```php
$user = \ATDev\RocketChat\Chat::me();
$result = $user->setStatus("[STATUS MESSAGE]", "away");
if (!$result) {
    $error = $user->getError();
}
```

### GET STATUS
```php
// by userId
$user = (new \ATDev\RocketChat\Users\User())->setUserId("[USER ID]");
// or by username
$user = (new \ATDev\RocketChat\Users\User())->setUsername("[USERNAME]");
$result = $user->getStatus();
// or get callee's status if no userId or username provided
$result = (new \ATDev\RocketChat\Users\User())->getStatus();
if (!$result) {
    $error = $user->getError();
}
```

### UPDATE USER AVATAR FROM LOCAL FILE

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
// or by username
$user = (new \ATDev\RocketChat\Users\User())->setUsername("[USERNAME]");
$avatar = new \ATDev\RocketChat\Users\AvatarFromFile("[PATH TO LOCAL READABLE FILE]");

$result = $user->setAvatar($avatar);
if (!$result) {
	// Log the error
	$error = $user->getError();
}
```

### UPDATE USER AVATAR FROM URL

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
// or by username
$user = (new \ATDev\RocketChat\Users\User())->setUsername("[USERNAME]");
$avatar = new \ATDev\RocketChat\Users\AvatarFromDomain("[URL TO FILE AVAILABLE IN PUBLIC]");

$result = $user->setAvatar($avatar);
if (!$result) {
	// Log the error
	$error = $user->getError();
}
```

### GET USER AVATAR

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
// or by username
$user = (new \ATDev\RocketChat\Users\User())->setUsername("[USERNAME]");

$result = $user->getAvatar();
if (!$result) {
	// Log the error
	$error = $user->getError();
} else {
	// Url to new user avatar
	$user->getAvatarUrl();
}
```

### RESET USER AVATAR
```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
// or by username
$user = (new \ATDev\RocketChat\Users\User())->setUsername("[USERNAME]");
$resetResultUser = $user->resetAvatar();
if (!$resetResultUser) {
    $error = $user->getError();
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

### DELETE OWN ACCOUNT
```php
$user = \ATDev\RocketChat\Chat::me();
$user->setPassword(hash("sha256","[USER PASSWORD]"));
$result = $user->deleteOwnAccount();
if (!$result) {
    $error = \ATDev\RocketChat\Users\User::getError();
}
```

### DEACTIVATE IDLE
```php
$count = \ATDev\RocketChat\Users\User::deactivateIdle(5, "guest");
if (!$count) {
    $error = \ATDev\RocketChat\Users\User::getError();
}
```

### PRESENCE
```php
$presence = \ATDev\RocketChat\Users\User::presence();
if (!$presence) {
	$error = \ATDev\RocketChat\Users\User::getError();
}
```

### GET PRESENCE
```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
// or by username
$user = (new \ATDev\RocketChat\Users\User())->setUsername("[USERNAME]");
$userPresence = \ATDev\RocketChat\Users\User::getPresence($user);
// or callee's presence
$userPresence = \ATDev\RocketChat\Users\User::getPresence();
if (!$userPresence) {
	$error = \ATDev\RocketChat\Users\User::getError();
}
```

### FORGOT PASSWORD
```php
$result = \ATDev\RocketChat\Users\User::forgotPassword('john@example.com');
if (!$result) {
    $result->getError();
}
```

### GET USERNAME SUGGESTION
```php
$result = \ATDev\RocketChat\Users\User::getUsernameSuggestion();
if (!$result) {
    $result->getError();
}
```

### SET PREFERENCES
```php
$user = \ATDev\RocketChat\Chat::login("[USERNAME]", "[PASSWORD]");
$preferences = new \ATDev\RocketChat\Users\Preferences();
$preferences->setHighlights(['highlight phrase', 'highlightword']);
$preferences->setAutoImageLoad(false);

$user = \ATDev\RocketChat\Users\User::setPreferences($user->getUserId(), $preferences);
if (!$user) {
    \ATDev\RocketChat\Users\User::getError();
}

$preferences = $user->getPreferencesData();
$preferences->getHighlights();
```

### GET PREFERENCES
```php
$preferences = \ATDev\RocketChat\Users\User::getPreferences();
if (!$preferences) {
    $preferences->getError();
}

$preferences->getDesktopNotificationDuration();
```

