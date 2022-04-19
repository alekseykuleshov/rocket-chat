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
$role->setScope("[ROLE SCOPE]"); // optional
$role->setDescription("[ROLE DESCRIPTION]"); // optional

$result = $role->create();

if (!$result) {
	// Log the error
	$error = $role->getError();
}
```

### DELETE ROLE
```php
$role = (new \ATDev\RocketChat\Roles\Role())->setRoleId("[ROLE ID]");

$result = $role->delete();

if (!$result) {
	// Log the error
	$error = $role->getError();
}
```

### UPDATE ROLE
```php
$role = new \ATDev\RocketChat\Roles\Role()->setRoleId("[ROLE ID]");
$role->setName("[ROLE NEW NAME]");
$role->setScope("[ROLE NEW SCOPE]"); // optional
$role->setDescription("[ROLE NEW DESCRIPTION]"); // optional
$role->setMandatory2fa("[ROLE NEW MANDATORY 2 FA]"); // optional

$result = $role->update();

if (!$result) {
	// Log the error
	$error = $role->getError();
}
```

### ADD A USER TO A ROLE
```php
$role = (new \ATDev\RocketChat\Roles\Role())->setName("[ROLE NAME]");

$result = $role->addUserToRole("[USERNAME]", "[ROOM ID]"); // "[ROOM ID]" is optional

if (!$result) {
	// Log the error
	$error = $role->getError();
}
```

### REMOVE A USER FROM A ROLE
```php
$role = (new \ATDev\RocketChat\Roles\Role())->setName("[ROLE NAME]");

$result = $role->removeUserFromRole("[USERNAME]", "[ROOM ID]"); // "[ROOM ID]" is optional

if (!$result) {
	// Log the error
	$error = $role->getError();
}
```

### GETS THE USERS THAT BELONGS TO A ROLE
```php
$role = (new \ATDev\RocketChat\Roles\Role())->setName("[ROLE NAME]");

$result = $role->getUsersInRole(5, 10, "[ROOM ID]"); // "[ROOM ID]" is optional

if (!$result) {
	// Log the error
	$error = $role->getError();
}
```