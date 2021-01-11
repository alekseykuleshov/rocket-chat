You have to be [logged in](https://github.com/alekseykuleshov/rocket-chat#login) and have relevant permissions.

### GROUP LISTING

```php
$listing = \ATDev\RocketChat\Groups\Group::listing();

if (!$listing) {
	// Log the error
	$error = \ATDev\RocketChat\Groups\Group::getError();
}
```

### GROUP LIST ALL
```php
$listAll = \ATDev\RocketChat\Groups\Group::listAll();

if (!$listAll) {
    $error = \ATDev\RocketChat\Groups\Group::getError();
}
```

### CREATE GROUP

```php
$group = new \ATDev\RocketChat\Groups\Group();
$group->setName("[GROUP-NAME-NO-SPACES]");
$group->setReadOnlyValue(true);

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

### GROUP REMOVE OWNER

```php
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->removeOwner($user);

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

### GROUP ADD LEADER
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$result = $group->addLeader($user);

if (!$result) {
    $error = $group->getError();
}
```

### GROUP REMOVE LEADER
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$result = $group->removeLeader($user);

if (!$result) {
    $error = $group->getError();
}
```

### GROUP ADD MODERATOR
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$result = $group->addModerator($user);

if (!$result) {
    $error = $group->getError();
}
```

### GROUP REMOVE MODERATOR
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");
$user = new \ATDev\RocketChat\Users\User("[USER ID]");
$result = $group->removeModerator($user);

if (!$result) {
    $error = $group->getError();
}
```

### GROUP MODERATORS LIST
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->moderators();
if (!$result) {
	$error = $group->getError();
}
```

### GROUP LEAVE
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->leave();
if (!$result) {
	$error = $group->getError();
}
```

### GROUP MEMBERS LIST
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->members();
if (!$result) {
	$error = $group->getError();
}
```

### GROUP COUNTERS
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->counters();
if (!$result) {
	$error = $group->getError();
}
```

### GROUP ARCHIVE
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->archive();
if (!$result) {
    $error = $group->getError();
}
```

### GROUP UNARCHIVE
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->unarchive();
if (!$result) {
    $error = $group->getError();
}
```

### GROUP RENAME
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->rename("[NEW-GROUP-NAME]");
if (!$result) {
    $error = $group->getError();
}
```

### GROUP SET DESCRIPTION
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");
$result = $group->setDescription("[GROUP DESCRIPTION]");
if (!$result) {
    $error = $group->getError();
}
```

### GROUP SET ANNOUNCEMENT
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");
$result = $group->setAnnouncement("[GROUP ANNOUNCEMENT]");
if (!$result) {
    $error = $group->getError();
}
```

### GROUP SET CUSTOM FIELDS
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");
$result = $group->setCustomFields(["CUSTOM-FIELD" => "VALUE"]);
if (!$result) {
    $error = $group->getError();
}
```

### GROUP SET READ ONLY
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");
$result = $group->setReadOnly(true);
if (!$result) {
    $error = $group->getError();
}
```

### GROUP SET TOPIC
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");
$result = $group->setTopic("[NEW GROUP TOPIC]");
if (!$result) {
    $error = $group->getError();
}
```

### GROUP SET TYPE
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->setType("c");
if (!$result) {
    $error = $group->getError();
}
```

### GROUP ROLES
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$roles = $group->roles();
if (!$roles) {
	$error = $group->getError();
} else {
    $roles->first()->getRoles();
}
```

### GROUP HISTORY
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->history([
    "latest" => "2016-09-30T13:42:25.304Z",
    "oldest" => "2016-05-30T13:42:25.304Z",
    "inclusive" => true,
    "unreads" => true
]);
if (!$result) {
	$error = $group->getError();
}
```

### GROUP FILES
```php
$group = new \ATDev\RocketChat\Groups\Group("[GROUP ID]");

$result = $group->files(10, 20);
if (!$result) {
	$error = $group->getError();
}
```