<?php

declare(strict_types=1);

namespace Kenjis\PhpUnitHelper;

use PHPUnit\Framework\TestCase;

class PhpUnitHelperTest extends TestCase
{
    /** @var PhpUnitHelper */
    protected $phpUnitHelper;

    protected function setUp(): void
    {
        $this->phpUnitHelper = new PhpUnitHelper();
    }

    public function testIsInstanceOfPhpUnitHelper(): void
    {
        $actual = $this->phpUnitHelper;
        $this->assertInstanceOf(PhpUnitHelper::class, $actual);
    }
}
