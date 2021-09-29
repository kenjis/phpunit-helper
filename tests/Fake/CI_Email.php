<?php

declare(strict_types=1);

namespace Kenjis\PhpUnitHelper;

class CI_Email
{
    public function to(string $to): CI_Email
    {
        return $this;
    }
}
