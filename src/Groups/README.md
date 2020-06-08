You have to be [logged in](../../README.md) and have relevant permissions.

### GROUP LISTING

```php
$listing = \ATDev\RocketChat\Groups\Group::listing();

if (!$listing) {

	// Log the error
	$error = \ATDev\RocketChat\Groups\Group::getError();
}
```

### CREATE GROUP

```php
$group = new \ATDev\RocketChat\Groups\Group();
$group->setName("[GROUP-NAME-NO-SPACES]");
$group->setReadOnly(true);

$result = $group->create();

if (!$result) {

	// Log the error
	$error = $group->getError();
}
```

### GET GROUP INFO

```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->info();

if (!$result) {

	// Log the error
	$error = $group->getError();
}
```

### DELETE GROUP

```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->delete();

if (!$result) {

	// Log the error
	$error = $group->getError();
}
```

### OPEN GROUP

```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->open();

if (!$result) {

	// Log the error
	$error = $group->getError();
}
```

### CLOSE GROUP

```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->close();

if (!$result) {

	// Log the error
	$error = $group->getError();
}
```

### INVITE USER TO GROUP

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->invite($user);

if (!$result) {

	// Log the error
	$error = $group->getError();
}
```

### KICK USER OUT OF GROUP

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->kick($user);

if (!$result) {

	// Log the error
	$error = $group->getError();
}
```

### ADD OWNER TO GROUP

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->addOwner($user);

if (!$result) {

	// Log the error
	$error = $group->getError();
}
```

### REMOVE USER OUT OF GROUP

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->removeOwner($user);

if (!$result) {

	// Log the error
	$error = $group->getError();
}
```

### LISTS ALL THE GROUP MESSAGES ON THE SERVER

```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");
$result = $group->messages();

if (!$result) {
    // Log the error
    $error = $group->getError();
}
```