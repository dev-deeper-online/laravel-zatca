<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\DTOs;

use DateTime;
use DevDeeper\ZATCA\Templates\InvoiceXMLTemplate;

class InvoiceData
{
    public function __construct(
        public string $uuid,
        public string $serialNumber,
        public DateTime $issueDate,
        public int $invoiceType,
        public int $counterNumber,
        public string $previousHash,
        public string $qrCode,
        public PartyData $party,
        public bool $cleared = true,
    ) {}

    public function toBase64(): string
    {
        return base64_encode(app(InvoiceXMLTemplate::class)->build($this));
    }
}
