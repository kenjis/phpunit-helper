<?php

declare(strict_types=1);

namespace Kenjis\PhpUnitHelper;

class Email
{
    public function to(string $to): Email
    {
        return $this;
    }

    public function batch_bcc_send(): void
    {
    }
}
