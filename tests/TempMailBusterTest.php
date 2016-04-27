<?php
namespace Ely\TempMailBuster;

class TempMailBusterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetStorage()
    {
        $storage = new Storage(['test']);
        $object = new TempMailBuster($storage);
        $this->assertEquals($storage, $object->getStorage());
    }

    public function testGetDomain()
    {
        $object = new TempMailBuster(new Storage());
        $this->assertEquals('ely.by', $this->callGetDomain($object, 'erickskrauch@ely.by'));
        $this->assertEquals('ely.by', $this->callGetDomain($object, '@ely.by'));
        $this->assertEquals('ely.by', $this->callGetDomain($object, 'ely.by'));
    }

    public function testBuildRegex()
    {
        $object = new TempMailBuster(new Storage());
        $this->assertEquals('/^(simple)$/', $this->callBuildRegex($object, ['simple']));
        $this->assertEquals('/^(simple|another)$/', $this->callBuildRegex($object, ['simple', 'another']));
    }

    public function testValidate()
    {
        $storage = new Storage(['mojang\.com']);
        $object = new TempMailBuster($storage);
        $this->assertFalse($object->validate('notch@mojang.com'));
        $this->assertTrue($object->validate('jeb@mojang1.com'));
        $this->assertTrue($object->validate('erickskrauch@ely.by'));
    }

    private function callGetDomain($object, $email)
    {
        $class = new \ReflectionClass($object);
        $method = $class->getMethod('getDomain');
        $method->setAccessible(true);

        return $method->invokeArgs($object, [$email]);
    }

    private function callBuildRegex($object, array $list)
    {
        $class = new \ReflectionClass($object);
        $method = $class->getMethod('buildRegex');
        $method->setAccessible(true);

        return $method->invokeArgs($object, [$list]);
    }
}
