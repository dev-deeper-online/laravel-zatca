<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\DTOs;

class CSIDOptions
{
    public function __construct(
        public CSROptions $csrOptions,
        public string $otp,
    ) {}
}
