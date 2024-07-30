<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\DTOs;

class OrganizationData
{
    public function __construct(
        public string $identifier,
        public string $name,
        public string $unit,
        public string $country,
        public string $address,
        public string $category,
    ) {}
}
