You have to be [logged in](https://github.com/alekseykuleshov/rocket-chat#login) and have relevant permissions.

### INVITE LISTING

```php
$listing = \ATDev\RocketChat\Invites\Invite::listing();

if (!$listing) {

	// Log the error
	$error = \ATDev\RocketChat\Invites\Invite::getError();
}
```

### FIND OR CREATE INVITE

```php
$invite = new \ATDev\RocketChat\Invites\Invite();
$invite->setRoomId("[ROOM ID]");
$invite->setDays(0);
$invite->setMaxUses(1);
$result = $invite->findOrCreateInvite();

if (!$result) {
	// Log the error
	$error = $invite->getError();
}
```

### REMOVE INVITE

```php
$invite = new \ATDev\RocketChat\Invites\Invite("[INVITE ID]");

$result = $invite->removeInvite();

if (!$result) {

    // Log the error
    $error = $invite->getError();
}
```

### USE INVITE TOKEN

```php
$invite = new \ATDev\RocketChat\Invites\Invite("[INVITE ID]");
$result = $invite->useInviteToken();

if (!$result) {
	// Log the error
	$error = $invite->getError();
}
```