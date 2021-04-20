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
$role = new \ATDev\RocketChat\Roles\Role();
$role->setUpdatedSince("2021-04-19T15:08:17.248Z");
$result = $role->sync();

if (!$result) {
	// Log the error
	$error = $role->getError();
}

// You can get updated roles
print_r($result->getUpdatedRoles());
// or removed ones
print_r($result->getRemovedRoles());
```

### CREATE ROLE
```php
$role = new \ATDev\RocketChat\Roles\Role();
$role->setName("[ROLE-NAME]");
$role->setScope("Subscriptions");
$role->setDescription("Role description");

$result = $role->create();

if (!$result) {
	// Log the error
	$error = $role->getError();
}
```