<?php

declare(strict_types=1);

namespace Kenjis\PhpUnitHelper;

use PHPUnit\Framework\TestCase;

class DebugHelperTest extends TestCase
{
    use DebugHelper;

    public function test_d(): void
    {
        $this->expectOutputRegex(
            '/string\(4\) "var1"\n.*\nint\(100\)\n/'
        );

        $var1 = 'var1';
        $var2 = 100;
        d($var1, $var2);
    }
}
