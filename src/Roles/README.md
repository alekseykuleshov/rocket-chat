You have to be [logged in](https://github.com/alekseykuleshov/rocket-chat#login) and have relevant permissions.

### ROLES LISTING

```php
$listing = \ATDev\RocketChat\Roles\Role::listing();

if (!$listing) {

	// Log the error
	$error = \ATDev\RocketChat\Roles\Role::getError();
}
```