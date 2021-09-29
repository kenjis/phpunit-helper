<?php

declare(strict_types=1);

namespace Kenjis\PhpUnitHelper;

class ForReflectionHelper
{
    /** @var string */
    private $private = 'secret';

    /** @var string */
    private static $staticPrivate = 'xyz';

    public function getPrivate(): string
    {
        return $this->private;
    }

    public static function getStaticPrivate(): string
    {
        return self::$staticPrivate;
    }

    private function privateMethod(string $param1, string $param2): string
    {
        return 'private ' . $param1 . $param2;
    }

    private static function privateStaticMethod(string $param1, string $param2): string
    {
        return 'private_static ' . $param1 . $param2;
    }
}
