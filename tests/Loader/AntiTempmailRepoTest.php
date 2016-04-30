<?php
namespace Ely\TempMailBuster\Loader;

class AntiTempmailRepoTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $loader = new AntiTempmailRepo();
        $this->assertTrue(is_array($loader->load()));
    }

    public function testLoadExceptionWrongPaths()
    {
        $this->expectException('Exception');
        $loader = new AntiTempmailRepoWithWrongPaths();
        $loader->load();
    }

    public function testLoadExceptionInvalidJson()
    {
        $this->expectException('Exception');
        $loader = new AntiTempmailRepoWithInvalidJson();
        $loader->load();
    }

    public function testGetSearchPaths()
    {
        $loader = new AntiTempmailRepo();
        $this->assertTrue(is_array($loader->getSearchPaths()));
    }

    public function testSetSearchPaths()
    {
        $path = __DIR__ . '/test.json';

        $loader = new AntiTempmailRepo();
        $loader->setSearchPaths([$path]);
        $this->assertTrue(is_array($loader->getSearchPaths()));
        $this->assertEquals([$path], $loader->getSearchPaths());

        $loader = new AntiTempmailRepo();
        $loader->setSearchPaths($path);
        $this->assertTrue(is_array($loader->getSearchPaths()));
        $this->assertEquals([$path], $loader->getSearchPaths());
    }
}

class AntiTempmailRepoWithWrongPaths extends AntiTempmailRepo
{
    public function getSearchPaths()
    {
        return [
            __DIR__ . '/virtual_reality.json',
        ];
    }
}

class AntiTempmailRepoWithInvalidJson extends AntiTempmailRepo
{
    public function getSearchPaths()
    {
        return [
            __DIR__ . '/AntiTempmailRepoTest.php',
        ];
    }
}
