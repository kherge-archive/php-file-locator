File Locator
============

[![Build Status](https://travis-ci.org/herrera-io/php-file-locator.png)](http://travis-ci.org/herrera-io/php-file-locator)

A simple file locator library.

Usage
-----

```php
<?php

use Herrera\FileLocator\Locator\FileSystemLocator;

$collection = new FileSystemLocator(array(
    '/dir1',
    '/dir2'
));

echo $collection->locate('file'); // echoes: /dir1/file
```