You have to be [logged in](../..) and have relevant permissions.

### IM LISTING

```php
$listing = \ATDev\RocketChat\Ims\Im::listing();

if (!$listing) {

	// Log the error
	$error = \ATDev\RocketChat\Ims\Im::getError();
}
```
