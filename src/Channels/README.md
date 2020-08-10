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
$channel->setReadOnlyValue(true);

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

### CHANNEL REMOVE LEADER
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$result = $channel->removeLeader($user);

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

### CHANNEL REMOVE MODERATOR
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$result = $channel->removeModerator($user);

if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL MODERATORS LIST
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->moderators();
if (!$result) {
	$error = $channel->getError();
}
```

### CHANNEL JOIN
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->join("[JOIN CODE]");
if (!$result) {
	$error = $channel->getError();
}
```

### CHANNEL LEAVE
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->leave();
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

### CHANNEL MEMBERS LIST
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->members();
if (!$result) {
	$error = $channel->getError();
}
```

### CHANNEL COUNTERS
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->counters();
if (!$result) {
	$error = $channel->getError();
}
```

### CHANNEL ONLINE
```php
$result = \ATDev\RocketChat\Channels\Channel::online(['_id' => 'channelId123']);
if (!$result) {
	$error = \ATDev\RocketChat\Channels\Channel::getError();
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

### CHANNEL RENAME
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->rename("[NEW-CHANNEL-NAME]");
if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL SET DEFAULT
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
$result = $channel->setDefault(true);
if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL SET JOIN CODE
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
$result = $channel->setJoinCode("[JOIN-CODE]");
if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL SET DESCRIPTION
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
$result = $channel->setDescription("[CHANNEL DESCRIPTION]");
if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL SET ANNOUNCEMENT
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
$result = $channel->setAnnouncement("[CHANNEL ANNOUNCEMENT]");
if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL SET CUSTOM FIELDS
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
$result = $channel->setCustomFields(["CUSTOM-FIELD" => "VALUE"]);
if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL SET READ ONLY
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
$result = $channel->setReadOnly(true);
if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL SET TOPIC
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");
$result = $channel->setTopic("[NEW CHANNEL TOPIC]");
if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL SET TYPE
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->setType("c");
if (!$result) {
    $error = $channel->getError();
}
```

### GET ALL THE MENTIONS OF A CHANNEL
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->getAllUserMentionsByChannel(5, 10);
if (!$result) {
    $error = $channel->getError();
}
```

### CHANNEL ROLES
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$roles = $channel->roles();
if (!$roles) {
	$error = $channel->getError();
} else {
    $roles->first()->getRoles();
}
```

### CHANNEL HISTORY
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->history([
    "latest" => "2016-09-30T13:42:25.304Z",
    "oldest" => "2016-05-30T13:42:25.304Z",
    "inclusive" => true,
    "unreads" => true
]);
if (!$result) {
	$error = $channel->getError();
}
```

### CHANNEL FILES
```php
$channel = new \ATDev\RocketChat\Channels\Channel("[CHANNEL ID]");

$result = $channel->files(10, 20);
if (!$result) {
	$error = $channel->getError();
}
```