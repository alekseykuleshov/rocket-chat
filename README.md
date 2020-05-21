# Rocket Chat Rest API PHP Wrapper Library

This is a wrapper for Rest API of Rocket Chat: https://rocket.chat/docs/developer-guides/rest-api/

## Installation

This library is installed via [Composer](http://getcomposer.org/). You will need to require `atdev/rocket-chat`:

```
composer require atdev/rocket-chat:~1.0
```

## How to use

### LOGIN

```php
// Firstly, init
\ATDev\RocketChat\Chat::setUrl("http://chat.me"); // No trailing /

// Now, login
$result = \ATDev\RocketChat\Chat::login("[USER LOGIN]", "[USER PASSWORD]");

if (!$result) {

	// Log the error
	$error = \ATDev\RocketChat\Chat::getError();
}
```

### GET CURRENTLY LOGGED IN USER

```php
$who = \ATDev\RocketChat\Chat::me();

if (!$who) {

	// Log the error
	$error = \ATDev\RocketChat\Chat::getError();
}
```

### LOGOUT

```php
\ATDev\RocketChat\Chat::logout();
```

Now, when you are logged in, you can:

[Manage Users](src/Users/README.md)

[Manage Channels](src/Channels/README.md)

[Manage Groups](src/Groups/README.md)

## Unit tests

Tests are run by `./vendor/bin/phpunit tests`. Although the library code is designed to be compatible with `php 5.6`, testing
requires `php 7.3` as minimum because of `phpunit` version `9`.

