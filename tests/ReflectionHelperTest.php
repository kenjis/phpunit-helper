<?php

declare(strict_types=1);

namespace Kenjis\PhpUnitHelper;

use PHPUnit\Framework\TestCase;

class ReflectionHelperTest extends TestCase
{
    use ReflectionHelper;

    public function test_getPrivateProperty_object(): void
    {
        $obj = new ForReflectionHelper();
        $actual = $this->getPrivateProperty($obj, 'private');
        $this->assertEquals('secret', $actual);
    }

    public function test_getPrivateProperty_static(): void
    {
        $actual = $this->getPrivateProperty(
            ForReflectionHelper::class,
            'staticPrivate'
        );
        $this->assertEquals('xyz', $actual);
    }

    public function test_setPrivateProperty_object(): void
    {
        $obj = new ForReflectionHelper();
        $this->setPrivateProperty(
            $obj,
            'private',
            'open'
        );
        $this->assertEquals('open', $obj->getPrivate());
    }

    public function test_setPrivateProperty_static(): void
    {
        $this->setPrivateProperty(
            ForReflectionHelper::class,
            'staticPrivate',
            'abc'
        );
        $this->assertEquals(
            'abc',
            ForReflectionHelper::getStaticPrivate()
        );
    }

    public function test_getPrivateMethodInvoker_object(): void
    {
        $obj = new ForReflectionHelper();
        $method = $this->getPrivateMethodInvoker(
            $obj,
            'privateMethod'
        );
        $this->assertEquals(
            'private param1param2',
            $method('param1', 'param2')
        );
    }

    public function test_getPrivateMethodInvoker_static(): void
    {
        $method = $this->getPrivateMethodInvoker(
            ForReflectionHelper::class,
            'privateStaticMethod'
        );
        $this->assertEquals(
            'private_static param1param2',
            $method('param1', 'param2')
        );
    }
}
