File Locator
============

[![Build Status](https://travis-ci.org/herrera-io/php-file-locator.png)](http://travis-ci.org/herrera-io/php-file-locator)

A simple file locator library.

Summary
-------

The **FileLocator** library was created to provide file locating capabilities to a larger project. It can be used in templating engines, configuration file loaders, and more.

Installation
------------

Add it to your list of Composer dependencies:

```sh
$ composer require herrera-io/file-locator=1.*
```

Usage
-----

The library includes `FileSystemLocator`, which can be used to search one or more directory paths. Either a single directory path, or an array of paths may be passed to the constructor.

```php
<?php

use Herrera\FileLocator\Locator\FileSystemLocator;

$locator = new FileSystemLocator('/path/to/dir');
$locator = new FileSystemLocator(array(
    '/path/to/dir1',
    '/path/to/dir2',
    '/path/to/dir3' // etc
));

$file = $locator->locate('file.ini'); // return the first "file.ini" found
$files = $locator->locate('file.ini', false); // find all named "file.ini"
```

You can also create your own custom file locator by implementing the interface, `LocatorInterface`. All locator classes bundled in the library also implement this interface, allowing drop-in replacement.

```php
<?php

use Herrera\FileLocator\Locator\LocatorInterface;

class MyLocator implements LocatorInterface
{
    public function locate($file, $first = true)
    {
        // do something to locate $file

        // if $first is true, return the first matching result
            // if nothing is found, return null

        // if $first is false, generate a list of found $file(s) and return it
            // if nothing is found, return an empty array
    }
}
```

You may use one or more file locator classes together by using the `Collection` class. This can be used to chain together one or more file locators, and may be used in place of an actual file locator.

```php
<?php

use Herrera\FileLocator\Collection;
use Herrera\FileLocator\Locator\FileSystemLocator;
use My\Library\CustomLocator;

$locators = new Collection();
$locators->add(new FileSystemLocator('/path/to/dir'));
$locators->add(new CustomLocator());

$file = $locator->locate('file.ini'); // return the first "file.ini" found
$files = $locator->locate('file.ini', false); // find all named "file.ini"
```