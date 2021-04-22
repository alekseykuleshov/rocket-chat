You have to be [logged in](https://github.com/alekseykuleshov/rocket-chat#login) and have relevant permissions.

### ROLES LISTING

```php
$listing = \ATDev\RocketChat\Roles\Role::listing();

if (!$listing) {

	// Log the error
	$error = \ATDev\RocketChat\Roles\Role::getError();
}
```

### ROLE SYNC
```php
$result = \ATDev\RocketChat\Roles\Role::sync("2021-04-19T15:08:17.248Z");

if (!$result) {
	// Log the error
	$error = \ATDev\RocketChat\Roles\Role::getError();
}
```

### CREATE ROLE
```php
$role = new \ATDev\RocketChat\Roles\Role();
$role->setName("[ROLE NAME]");
$role->setScope("[ROLE SCOPE]");
$role->setDescription("[ROLE DESCRIPTION]");

$result = $role->create();

if (!$result) {
	// Log the error
	$error = $role->getError();
}
```

### ASSIGN A ROLE TO AN USER
```php
$role = (new \ATDev\RocketChat\Roles\Role())->setName("[ROLE NAME]");
$user = (new \ATDev\RocketChat\Users\User())->setUsername("[USERNAME]");

$result = $role->addUserToRole($user, "[ROOM ID]");

if (!$result) {
	// Log the error
	$error = $role->getError();
}
```

### GETS THE USERS THAT BELONGS TO A ROLE
```php
$role = new \ATDev\RocketChat\Roles\Role();
$role->setRole("[ROLE NAME]");
$role->setRoomId("[ROOM ID]");

$result = $role->getUsersInRole();

if (!$result) {
	// Log the error
	$error = $role->getError();
}
```