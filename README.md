# PHPUnit Helper

Provides helper traits for PHPUnit.

## Installation

Run

```sh
$ composer require --dev kenjis/phpunit-helper
```

## Usage

- [TestDouble](#testdouble)
- [ReflectionHelper](#reflectionhelper)

### `TestDouble`

This trait provides helper methods to create mock objects and to verify invocations.

Import the `Kenjis\PhpUnitHelper\TestDouble` trait into your test class:

```php
<?php

declare(strict_types=1);

namespace Foo\Bar\Test\Unit;

use Kenjis\PhpUnitHelper\TestDouble;
use PHPUnit\Framework;

final class BazTest extends Framework\TestCase
{
    use TestDouble;
}
```

#### `$this->getDouble()`

| param               | type        | description                                            |
|---------------------|-------------|--------------------------------------------------------|
|`$classname`         | string      | class name                                             |
|`$params`            | array       | [method_name => return_value]                          |
|                     |             | [[method_name => [return_value1, return_value2 [, ...]]] |
|`$constructor_params`| false/array | false: disable constructor / array: constructor params |

`returns` (object) PHPUnit mock object.

Gets PHPUnit mock object.

```php
$email = $this->getMockBuilder(CI_Email::class)
    ->disableOriginalConstructor()
    ->setMethods(['send'])
    ->getMock();
$email->method('send')
    ->willReturn(true);
```

You could write code above like below:

```php
$email = $this->getDouble(CI_Email::class, ['send' => true]);
```

You can set Closure as the return value of a mocked method.

```php
$ret = function () {
    throw new RuntimeException('Cannot send email!');
};
$mock = $this->getDouble(CI_Email::class, ['send' => $ret]);
```

You can also set the mock itself as the return value of a mocked method with using `$this->returnSelf()`.

```php
$mock = $this->getDouble(CI_Email::class, [
    'to'      => $this->returnSelf(),
    'subject' => $this->returnSelf(),
    'send'    => true,
]);
```

You can create mocks with consecutive calls.

```php
$mock = $this->getMockBuilder(CI_Email::class)
    ->disableOriginalConstructor()
    ->setMethods(['method'])
    ->getMock();
$mock->expects($this->any())->method('method')
    ->will($this->onConsecutiveCalls('GET', 'POST' ,'DELETE'));
```

You could write code above like below:

```php
$mock = $this->getDouble(
    CI_Input::class,
    [
        ['method' => ['GET', 'POST' ,'DELETE']],
    ]
);
```

#### `$this->verifyInvoked()`

| param   | type   | description         |
|---------|--------|---------------------|
|`$mock`  | object | PHPUnit mock object |
|`$method`| string | method name         |
|`$params`| array  | arguments           |

Verifies a method was invoked at least once.

```php
$loader->expects($this->atLeastOnce())
    ->method('view')
    ->with(
        'shopConfirm', $this->anything(), true
    );
```

You could write code above like below:

```php
$this->verifyInvoked(
    $loader,
    'view',
    [
        'shopConfirm', $this->anything(), TRUE
    ]
);
```

#### `$this->verifyInvokedOnce()`

| param   | type   | description         |
|---------|--------|---------------------|
|`$mock`  | object | PHPUnit mock object |
|`$method`| string | method name         |
|`$params`| array  | arguments           |

Verifies that method was invoked only once.

```php
$loader->expects($this->once())
    ->method('view')
    ->with(
        'shopConfirm', $this->anything(), true
    );
```

You could write code above like below:

```php
$this->verifyInvokedOnce(
    $loader,
    'view',
    [
        'shopConfirm', $this->anything(), true
    ]
);
```

#### `$this->verifyInvokedMultipleTimes()`

| param   | type   | description         |
|---------|--------|---------------------|
|`$mock`  | object | PHPUnit mock object |
|`$method`| string | method name         |
|`$times` | int    | times               |
|`$params`| array  | arguments           |

Verifies that method was called exactly $times times.

```php
$loader->expects($this->exactly(2))
    ->method('view')
    ->withConsecutive(
        ['shopConfirm', $this->anything(), true],
        ['shopTmplCheckout', $this->anything()]
    );
```

You could write code above like below:

```php
$this->verifyInvokedMultipleTimes(
    $loader,
    'view',
    2,
    [
        ['shopConfirm', $this->anything(), true],
        ['shopTmplCheckout', $this->anything()]
    ]
);
```

#### `$this->verifyNeverInvoked()`

| param   | type   | description         |
|---------|--------|---------------------|
|`$mock`  | object | PHPUnit mock object |
|`$method`| string | method name         |
|`$params`| array  | arguments           |

Verifies that method was not called.

```php
$loader->expects($this->never())
    ->method('view')
    ->with(
        'shopConfirm', $this->anything(), true
    );
```

You could write code above like below:

```php
$this->verifyNeverInvoked(
    $loader,
    'view',
    [
        'shopConfirm', $this->anything(), true
    ]
);
```

### `ReflectionHelper`

This trait provides helper methods to access private or protected properties and methods.

But generally it is not recommended testing non-public properties or methods, so think twice before you use the methods in this trait.

Import the `Kenjis\PhpUnitHelper\ReflectionHelper` trait into your test class:

```php
<?php

declare(strict_types=1);

namespace Foo\Bar\Test\Unit;

use Kenjis\PhpUnitHelper\ReflectionHelper;
use PHPUnit\Framework;

final class BazTest extends Framework\TestCase
{
    use ReflectionHelper;
}
```

#### `$this->getPrivateProperty()`

| param     | type          | description         |
|-----------|---------------|---------------------|
|`$obj`     | object/string | object / class name |
|`$property`| string        | property name       |

`returns` (mixed) property value.

Gets private or protected property value.

~~~php
$obj = new SomeClass();
$private_propery = $this->getPrivateProperty(
	$obj,
	'privatePropery'
);
~~~

#### `$this->setPrivateProperty()`

| param     | type          | description         |
|-----------|---------------|---------------------|
|`$obj`     | object/string | object / class name |
|`$property`| string        | property name       |
|`$value`   | mixed         | value               |

Sets private or protected property value.

~~~php
$obj = new SomeClass();
$this->setPrivateProperty(
	$obj,
	'privatePropery',
	'new value'
);
~~~

#### `$this->getPrivateMethodInvoker()`

| param   | type          | description         |
|---------|---------------|---------------------|
|`$obj`   | object/string | object / class name |
|`$method`| string        | method name         |

`returns` (closure) method invoker.

Gets private or protected method invoker.

~~~php
$obj = new SomeClass();
$method = $this->getPrivateMethodInvoker(
	$obj, 'privateMethod'
);
$this->assertEquals(
	'return value of the privateMethod() method', $method()
);
~~~
