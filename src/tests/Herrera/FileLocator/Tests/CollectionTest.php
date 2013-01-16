<?php

namespace Herrera\FileLocator\Tests;

use Herrera\FileLocator\Collection;
use Herrera\FileLocator\Locator\FileSystemLocator;
use PHPUnit_Framework_TestCase as TestCase;
use ReflectionProperty;

class CollectionTest extends TestCase
{
    /**
     * @var Collection
     */
    private $collection;

    public function testAdd()
    {
        $locator = new FileSystemLocator(null);

        $this->collection->add($locator);

        $p = new ReflectionProperty($this->collection, 'locators');
        $p->setAccessible(true);

        $this->assertTrue(
            $p->getValue($this->collection)
              ->contains($locator)
        );

        return array($this->collection, $locator);
    }

    public function testLocateNone()
    {
        $this->assertNull($this->collection->locate('test'));
        $this->assertSame(array(), $this->collection->locate('test', false));
    }

    public function testLocateSingle()
    {
        $locator = new FileSystemLocator(array(__DIR__));

        $this->collection->add($locator);

        $this->assertEquals(
            __FILE__,
            $this->collection->locate(basename(__FILE__))
        );
    }

    public function testLocateMultiple()
    {
        $dir1 = tempnam(sys_get_temp_dir(), 'fsl');
        $dir2 = tempnam(sys_get_temp_dir(), 'fsl');

        unlink($dir1);
        unlink($dir2);
        mkdir($dir1);
        mkdir($dir2);

        touch($file1 = "$dir1/test");
        touch($file2 = "$dir2/test");

        $locator = new FileSystemLocator(array($dir1, $dir2));

        $this->collection->add($locator);

        $this->assertEquals(
            array(realpath($file1), realpath($file2)),
            $this->collection->locate('test', false)
        );
    }

    /**
     * @depends testAdd
     */
    public function testRemove($stuff)
    {
        list($collection, $locator) = $stuff;

        $collection->remove($locator);

        $p = new ReflectionProperty($this->collection, 'locators');
        $p->setAccessible(true);

        $this->assertFalse(
            $p->getValue($this->collection)
                ->contains($locator)
        );
    }

    protected function setUp()
    {
        $this->collection = new Collection();
    }
}