You have to be [logged in](https://github.com/alekseykuleshov/rocket-chat#login) and have relevant permissions.

### CHANNEL LISTING

```php
$listing = \ATDev\RocketChat\Channels\Channel::listing();

if (!$listing) {

	// Log the error
	$error = \ATDev\RocketChat\Channels\Channel::getError();
}
```

### CREATE CHANNEL

```php
$channel = new \ATDev\RocketChat\Channels\Channel();
$channel->setName("[CHANNEL-NAME-NO-SPACES]");
$channel->setReadOnly(true);

$result = $channel->create();

if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```

### GET CHANNEL INFO

```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->info();

if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```

### DELETE CHANNEL

```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->delete();

if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```

### OPEN CHANNEL

```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->open();

if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```

### CLOSE CHANNEL

```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->close();

if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```

### INVITE USER TO CHANNEL

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->invite($user);

if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```

### KICK USER OUT OF CHANNEL

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->kick($user);

if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```

### ADD OWNER TO CHANNEL

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->addOwner($user);

if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```

### REMOVE USER OUT OF CHANNEL

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->removeOwner($user);

if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```

### LISTS ALL THE CHANNEL MESSAGES ON THE SERVER

```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
$result = $channel->messages();

if (!$result) {
    // Log the error
    $error = $channel->getError();
}
```

### CHANNEL ADD ALL
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
$result = $channel->addAll(true);

if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL ADD LEADER
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$result = $channel->addLeader($user);

if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL ADD MODERATOR
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$result = $channel->addModerator($user);

if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL ANONYMOUS READ
```php
// Identify channel by id
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
// or by name
$channel = new \ATDev\RocketChat\Channels\Channel();
$channel->setName("[CHANNEL-NAME]");
$result = $channel->anonymousRead();

if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL ARCHIVE
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->archive();
if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL UNARCHIVE
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->unarchive();
if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL LIST JOINED
```php
$list = \ATDev\RocketChat\Channels\Channel::listJoined();

if (!$list) {
    $error = \ATDev\RocketChat\Channels\Channel::getError();
}
```

### CHANNEL COUNTERS
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->counters();
if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```

### CHANNEL JOIN
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->join("[JOIN CODE]");
if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```

### CHANNEL LEAVE
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->leave();
if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```

### CHANNEL MEMBERS LIST
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->members();
if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```

### CHANNEL MODERATORS LIST
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->moderators();
if (!$result) {
	// Log the error
	$error = $channel->getError();
}
```