# php-mimetyper

PHP mime type and extension mapping library: built with [jshttp/mime-db](http://github.com/jshttp/mime-db), compatible with Symfony and Laravel.

Where most of libraries out there uses Apache mime types list, this library uses [jshttp/mime-db](http://github.com/jshttp/mime-db) as its mapping of mime types and extensions. Aggregating data from multiple sources (IANA, Apache, Nginx) and creating a single `db.json` makes it the most complete two way mapping, from mime to extension and extension to mime types too.

```php
use MimeTyper\Repository\MimeDbRepository;

$mimeRepostory = new MimeDbRepository();

$mimeRepository->findExtensions("image/jpeg"); // ["jpeg","jpg","jpe"]
$mimeRepository->findExtension("image/jpeg"); // "jpeg"

$mimeRepository->findType("html"); // "html"
$mimeRepository->findType("js"); // 'application/javascript'

```

Some custom types (aliases) are maintained too.

```php

use MimeTyper\Repository\ExtendedRepository;

$mimeRepostory = new ExtendedRepository();

$mimeRepository->findExtensions("text/x-php"); // ["php", "php2", "php3", "php4", "php5"]

$mimeRepository->findTypes("php"); // ["text/x-php", "application/x-php", "text/php", "application/php", "application/x-httpd-php"]
$mimeRepository->findType("php"); // "text/x-php"

```

Tools detecting mime types don't always return standard mime type or the standard mime type does not exist. That's the case with php which is absent in IANA, Apache or Nginx. Meanwhile, Debian will detect a PHP file as `text/x-php` while browsers will send `application/x-httpd-php`.

It goes the same with files such as Javascript (`application/javascript` vs `text/javascript`) or Microsoft Office / Libre Office files.

Maintaining aliases help with overall compatibility between mime type guessing methods. Don't hesitate to make a pull request to discuss this.

## Symfony / Laravel compatibility

You can safely use this library to enjoy the completeness of the mime-db mapping.

```php

use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;

use MimeTyper\Repository\ExtendedRepository;
use MimeTyper\Symfony\ExtraMimeTypeExtensionGuesser;

$symfonyGuesser = ExtensionGuesser::getInstance();
$extraGuesser = new ExtraMimeTypeExtensionGuesser(
    new ExtendedRepository()
);
$symfonyGuesser->register($extraGuesser);

```

## FAQ

### Where does the data comes from?

@TODO

### How to detect mime types of files?

@TODO
