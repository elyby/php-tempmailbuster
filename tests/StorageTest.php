<?php
namespace Ely\TempMailBuster;

class StorageTest extends \PHPUnit_Framework_TestCase
{
    public function testGetItems()
    {
        $storage = new Storage(['item']);
        $this->assertEquals(['item'], $storage->getItems());
    }

    public function testAppend()
    {
        $storage = new Storage(['item1']);
        $this->assertEquals($storage, $storage->append(['item2']));
        $this->assertEquals(['item1', 'item2'], $storage->getItems());

        $storage = new Storage(['item1']);
        $this->assertEquals($storage, $storage->append('item2'));
        $this->assertEquals(['item1', 'item2'], $storage->getItems());
    }

    public function testSetItems()
    {
        $storage = new Storage(['item1']);
        $this->assertEquals($storage, $storage->setItems(['item2']));
        $this->assertEquals(['item2'], $storage->getItems());
    }
}
