<?php
namespace Ely\TempMailBuster;

class StorageTest extends \PHPUnit_Framework_TestCase
{
    public function testGetBlackList()
    {
        $storage = new Storage(['item']);
        $this->assertEquals(['item'], $storage->getBlacklist());
    }

    public function testAppendToBlacklist()
    {
        $storage = new Storage(['item1']);
        $this->assertEquals($storage, $storage->appendToBlacklist(['item2']));
        $this->assertEquals(['item1', 'item2'], $storage->getBlacklist());

        $storage = new Storage(['item1']);
        $this->assertEquals($storage, $storage->appendToBlacklist('item2'));
        $this->assertEquals(['item1', 'item2'], $storage->getBlacklist());
    }

    public function testSetBlacklist()
    {
        $storage = new Storage(['item1']);
        $this->assertEquals($storage, $storage->setBlacklist(['item2']));
        $this->assertEquals(['item2'], $storage->getBlacklist());
    }
}
