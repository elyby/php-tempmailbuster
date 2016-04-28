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
}

class AntiTempmailRepoWithWrongPaths extends AntiTempmailRepo
{
    protected function getPaths()
    {
        return [
            __DIR__ . '/virtual_reality.json',
        ];
    }
}

class AntiTempmailRepoWithInvalidJson extends AntiTempmailRepo
{
    protected function getPaths()
    {
        return [
            __DIR__ . '/AntiTempmailRepoTest.php',
        ];
    }
}
