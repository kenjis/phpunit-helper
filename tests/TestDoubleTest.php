<?php

declare(strict_types=1);

namespace Kenjis\PhpUnitHelper;

use Kenjis\PhpUnitHelper\Exception\RuntimeException;
use PHPUnit\Framework\TestCase;

class TestDoubleTest extends TestCase
{
    use TestDouble;

    public function test_getDouble_method_named_method(): void
    {
        $expected = 'DELETE';
        $mock = $this->getDouble(CI_Input::class, ['method' => $expected]);

        $actual = $mock->method();

        $this->assertEquals($expected, $actual);
    }

    public function test_getDouble_method_returns_consecutive(): void
    {
        $returns = ['GET', 'PUT', 'DELETE'];
        $mock = $this->getDouble(
            CI_Input::class,
            [
                ['method' => $returns],
            ]
        );

        $actual = $mock->method();
        $this->assertEquals($returns[0], $actual);

        $actual = $mock->method();
        $this->assertEquals($returns[1], $actual);

        $actual = $mock->method();
        $this->assertEquals($returns[2], $actual);
    }

    public function test_getDouble_returns_consecutive_and_other(): void
    {
        $returns = ['GET', 'PUT', 'DELETE'];
        $mock = $this->getDouble(
            CI_Input::class,
            [
                'get' => [],
                ['method' => $returns],
            ]
        );

        $actual = $mock->method();
        $this->assertEquals($returns[0], $actual);

        $actual = $mock->method();
        $this->assertEquals($returns[1], $actual);

        $actual = $mock->method();
        $this->assertEquals($returns[2], $actual);

        $actual = $mock->get();
        $this->assertEquals([], $actual);

        $actual = $mock->get();
        $this->assertEquals([], $actual);
    }

    public function test_getDouble_method_returns_execption(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('I can throw an exception and can use params: abcdef');

        $ret = static function ($param1, $param2): void {
            throw new RuntimeException('I can throw an exception and can use params: ' . $param1 . $param2);
        };
        $mock = $this->getDouble(CI_Input::class, ['method' => $ret]);

        $mock->method('abc', 'def');
    }

    public function test_getDouble_constructor_param(): void
    {
        $mock = $this->getDouble(
            'SplFileObject',
            [
                'current' => ['foo', 'bar'],
                'next'    => null,
            ],
            ['php://memory']
        );

        $this->assertEquals(null, $mock->next());
    }

    public function test_getDobule_method_returns_phpunit_stub(): void
    {
        $mock = $this->getDouble(CI_Email::class, ['to' => $this->returnSelf()]);
        $test = $mock->to('test@example.com');

        $this->assertEquals($mock, $test);
    }

    public function test_verifyInvokedOnce_with_params(): void
    {
        $expected = 'DELETE';
        $mock = $this->getDouble(CI_Input::class, ['method' => $expected]);

        $this->verifyInvokedOnce($mock, 'method', [true]);

        $mock->method(true);
    }

    public function test_verifyInvokedOnce_without_params(): void
    {
        $expected = 'DELETE';
        $mock = $this->getDouble(CI_Input::class, ['method' => $expected]);

        $this->verifyInvokedOnce($mock, 'method');

        $mock->method();
    }

    public function test_verifyInvoked_once(): void
    {
        $expected = 'DELETE';
        $mock = $this->getDouble(CI_Input::class, ['method' => $expected]);

        $this->verifyInvoked($mock, 'method');

        $mock->method();
    }

    public function test_verifyInvoked_twice(): void
    {
        $expected = 'DELETE';
        $mock = $this->getDouble(CI_Input::class, ['method' => $expected]);

        $this->verifyInvoked($mock, 'method');

        $mock->method();
        $mock->method();
    }

    public function test_verifyInvokedMultipleTimes(): void
    {
        $expected = 'DELETE';
        $mock = $this->getDouble(CI_Input::class, ['method' => $expected]);

        $this->verifyInvokedMultipleTimes($mock, 'method', 3);

        $mock->method();
        $mock->method();
        $mock->method();
    }

    public function test_verifyNeverInvoked(): void
    {
        $expected = 'DELETE';
        $mock = $this->getDouble(CI_Input::class, ['method' => $expected]);

        $this->verifyNeverInvoked($mock, 'method');
    }
}
