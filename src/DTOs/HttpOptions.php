<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\DTOs;

class HttpOptions
{
    public function __construct(
        public string $method,
        public string $path,
        public array $body = [],
        public array $headers = [],
        public array|bool $authenticated = true,
    ) {}
}
