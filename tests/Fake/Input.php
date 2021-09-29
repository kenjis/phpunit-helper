<?php

declare(strict_types=1);

namespace Kenjis\PhpUnitHelper;

class Input
{
    public function method(bool $upper = false): string
    {
        return 'GET';
    }

    /**
     * @param mixed $index
     *
     * @return mixed
     */
    public function get($index = null, bool $xssClean = false)
    {
        return 'GET value';
    }
}
