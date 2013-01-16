<?php

namespace Herrera\FileLocator\Locator;

/**
 * Defines how a file locator must be implemented.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
interface LocatorInterface
{
    /**
     * Returns the file path(s) for the file name.
     *
     * @param string $file   The file name.
     * @param boolean $first Only return the first result?
     *
     * @return string The absolute file path, or NULL if not found.
     */
    public function locate($file, $first = true);
}