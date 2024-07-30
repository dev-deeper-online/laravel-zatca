<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\DTOs;

class InvoiceData
{
    public function __construct(
        public string $uuid = '1',
        public string $invoiceHash = '1',
        public string $base64 = '1',
        public bool $cleared = true,
    ) {}
}
