<?php

namespace Herrera\FileLocator;

use Herrera\FileLocator\Locator\LocatorInterface;
use SplObjectStorage;

/**
 * Manages a collection of file locators.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Collection implements LocatorInterface
{
    /**
     * The list of file locators.
     *
     * @var SplObjectStorage
     */
    private $locators;

    /**
     * Initializes the list of file locators.
     */
    public function __construct()
    {
        $this->locators = new SplObjectStorage();
    }

    /**
     * Adds a file locator to the collection.
     *
     * @param LocatorInterface $locator A file locator.
     */
    public function add(LocatorInterface $locator)
    {
        $this->locators->attach($locator);
    }

    /**
     * Locates a file using the locators in the collection.
     *
     * @param string  $file  The file name.
     * @param boolean $first Only return first result?
     *
     * @return array|string The file path or list of file paths.
     */
    public function locate($file, $first = true)
    {
        $paths = array();

        foreach ($this->locators as $locator) {
            if (null !== ($found = $locator->locate($file, $first))) {
                if ($first) {
                    return $found;
                }

                $paths = array_merge($paths, $found);
            }
        }

        return $first ? null : array_values(array_unique($paths));
    }

    /**
     * Removes a file locator from the collection.
     *
     * @param LocatorInterface $locator A file locator.
     */
    public function remove(LocatorInterface $locator)
    {
        $this->locators->detach($locator);
    }
}
