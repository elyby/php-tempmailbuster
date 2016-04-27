<?php
namespace Ely\TempMailBuster;

class LoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPaths()
    {
        $this->assertTrue(is_array(Loader::getPaths()));
    }

    public function testLoad()
    {
        $this->assertTrue(is_array(Loader::load()));
    }

    public function testLoadExceptionWrongPaths()
    {
        $this->expectException('Exception');
        LoaderWithWrongPaths::load();
    }

    public function testLoadExceptionInvalidJson()
    {
        $this->expectException('Exception');
        LoaderWithInvalidJson::load();
    }
}

class LoaderWithWrongPaths extends Loader
{
    public static function getPaths()
    {
        return [
            __DIR__ . '/virtual_reality.json',
        ];
    }
}

class LoaderWithInvalidJson extends Loader
{
    public static function getPaths()
    {
        return [
            __DIR__ . '/LoaderTest.php',
        ];
    }
}
