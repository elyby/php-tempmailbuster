<?php
namespace Ely\TempMailBuster;

class TempMailBusterTest extends \PHPUnit_Framework_TestCase
{
    public function testValidate()
    {
        $object = new TempMailBuster(new Storage());
        $this->assertTrue($object->validate('notch@mojang.com'));

        $object = new TempMailBuster(new Storage());
        $object->whitelistMode();
        $this->assertFalse($object->validate('notch@mojang.com'));

        $object = new TempMailBuster(new Storage(['mojang\.com']));
        $this->assertFalse($object->validate('notch@mojang.com'));
        $this->assertTrue($object->validate('erickskrauch@ely.by'));

        $object = new TempMailBuster(new Storage(['gmail\.com']));
        $object->whitelistMode();
        $this->assertFalse($object->validate('team@ely.by'));
        $this->assertTrue($object->validate('erickskrauch@gmail.com'));

        $object = new TempMailBuster(new Storage(['mojang\.com', 'ely\.by']), new Storage(['ely\.by']));
        $this->assertFalse($object->validate('notch@mojang.com'));
        $this->assertTrue($object->validate('team@ely.by'));

        $object = new TempMailBuster(new Storage(['gmail\.com', 'mail\.ru']), new Storage(['mail\.ru']));
        $object->whitelistMode();
        $this->assertTrue($object->validate('erickskrauch@gmail.com'));
        $this->assertFalse($object->validate('random@mail.ru'));
    }

    public function testGetPrimaryStorage()
    {
        $storage = new Storage(['test']);
        $object = new TempMailBuster($storage);
        $this->assertEquals($storage, $object->getPrimaryStorage());
    }

    public function testSetPrimaryStorage()
    {
        $storage = new Storage(['test2']);
        $object = new TempMailBuster(new Storage(['test1']));
        $this->assertEquals($object, $object->setPrimaryStorage($storage));
        $this->assertEquals($storage, $object->getPrimaryStorage());
    }

    public function testGetSecondaryStorage()
    {
        $object = new TempMailBuster(new Storage());
        $this->assertNull($object->getSecondaryStorage());

        $storage = new Storage(['test']);
        $object = new TempMailBuster(new Storage(), $storage);
        $this->assertEquals($storage, $object->getSecondaryStorage());
    }

    public function testSetSecondaryStorage()
    {
        $storage = new Storage(['test2']);
        $object = new TempMailBuster(new Storage());
        $this->assertEquals($object, $object->setSecondaryStorage($storage));
        $this->assertEquals($storage, $object->getSecondaryStorage());
        $object->setSecondaryStorage(null);
        $this->assertNull($object->getSecondaryStorage(), 'Set by null should work');
        $object->setSecondaryStorage($storage);
        $object->setSecondaryStorage();
        $this->assertNull($object->getSecondaryStorage(), 'Set by empty value should work');
    }

    public function testGetDomain()
    {
        $object = new TempMailBuster(new Storage());
        $this->assertEquals('ely.by', $this->callGetDomain($object, 'erickskrauch@ely.by'));
        $this->assertEquals('ely.by', $this->callGetDomain($object, '@ely.by'));
        $this->assertEquals('ely.by', $this->callGetDomain($object, 'ely.by'));
    }

    public function testIsIsWhitelistMode()
    {
        $object = new TempMailBuster(new Storage());
        $this->assertFalse($object->isIsWhitelistMode(), 'Default should be false');
        $object->whitelistMode();
        $this->assertTrue($object->isIsWhitelistMode());
    }

    public function testWhitelistMode()
    {
        $object = new TempMailBuster(new Storage());
        $this->assertEquals($object, $object->whitelistMode());
        $this->assertTrue($object->isIsWhitelistMode(), 'Default value should change mode to whitelist');
        $object->whitelistMode(false);
        $this->assertFalse($object->isIsWhitelistMode());
        $object->whitelistMode(true);
        $this->assertTrue($object->isIsWhitelistMode());
    }

    public function testBuildRegex()
    {
        $object = new TempMailBuster(new Storage());
        $this->assertEquals('/^(simple)$/', $this->callBuildRegex($object, ['simple']));
        $this->assertEquals('/^(simple|another)$/', $this->callBuildRegex($object, ['simple', 'another']));
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
