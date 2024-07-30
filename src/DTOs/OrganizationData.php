<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\DTOs;

class OrganizationData
{
    public function __construct(
        public string $vat_registration_number,
        public string $name,
        public string $branch,
        public string $address,
        public string $category,
    ) {}
}
