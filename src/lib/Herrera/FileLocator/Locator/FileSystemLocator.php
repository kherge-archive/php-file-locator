<?php

namespace Herrera\FileLocator\Locator;

use Herrera\FileLocator\Exception\InvalidArgumentException;

/**
 * Locates files in one or more directory paths.
 *
 * @author Kevin Herrera <kevin@herrera.io.
 */
class FileSystemLocator implements LocatorInterface
{
    /**
     * The list of directory paths.
     *
     * @var array
     */
    private $directories = array();

    /**
     * Sets the list of directory paths, if provided.
     *
     * @param array $directories The directory paths.
     *
     * @throws InvalidArgumentException If a directory path does not exist.
     */
    public function __construct($directories)
    {
        $directories = (array) $directories;

        foreach ($directories as $path) {
            if (false === is_dir($path)) {
                throw new InvalidArgumentException(sprintf(
                    'The path "%s" is not a valid directory path.',
                    $path
                ));
            }
        }

        $this->directories = $directories;
    }

    /**
     * @override
     */
    public function locate($file, $first = true)
    {
        $paths = array();

        foreach ($this->directories as $directory) {
            $path = $directory . DIRECTORY_SEPARATOR . $file;

            if (file_exists($path)) {
                if ($first) {
                    return $path;
                }

                $paths[] = $path;
            }
        }

        return $first ? null : $paths;
    }
}