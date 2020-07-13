You have to be [logged in](https://github.com/alekseykuleshov/rocket-chat#login) and have relevant permissions.

### INVITE LISTING

```php
$listing = \ATDev\RocketChat\Invites\Invite::listing();

if (!$listing) {

	// Log the error
	$error = \ATDev\RocketChat\Invites\Invite::getError();
}
```
