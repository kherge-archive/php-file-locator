<?php

namespace Herrera\FileLocator\Tests\Locator;

use Herrera\FileLocator\Locator\FileSystemLocator;
use PHPUnit_Framework_TestCase as TestCase;

class FileSystemLocatorTest extends TestCase
{
    /**
     * @var FileSystemLocator
     */
    private $locator;

    private $paths = array();

    public function testInvalidPath()
    {
        $this->setExpectedException(
            'Herrera\\FileLocator\\Exception\\InvalidArgumentException',
            'The path "test" is not a valid directory path.'
        );

        new FileSystemLocator(array('test'));
    }

    public function testLocateNone()
    {
        $this->assertNull($this->locator->locate('test'));
        $this->assertSame(array(), $this->locator->locate('test', false));
    }

    public function testLocateSingle()
    {
        $this->assertEquals(
            realpath($this->paths[2]),
            $this->locator->locate('single')
        );
    }

    public function testLocateMultiple()
    {
        $this->assertEquals(
            array(
                realpath($this->paths[0]),
                realpath($this->paths[1])
            ),
            $this->locator->locate('multiple', false)
        );
    }

    protected function setUp()
    {
        $dir1 = tempnam(sys_get_temp_dir(), 'fsl');
        $dir2 = tempnam(sys_get_temp_dir(), 'fsl');

        unlink($dir1);
        unlink($dir2);
        mkdir($dir1);
        mkdir($dir2);

        touch($this->paths[] = "$dir1/multiple");
        touch($this->paths[] = "$dir2/multiple");
        touch($this->paths[] = "$dir2/single");

        $this->locator = new FileSystemLocator(array($dir1, $dir2));
    }
}