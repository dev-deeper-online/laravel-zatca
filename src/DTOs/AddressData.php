<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\DTOs;

class AddressData
{
    public function __construct(
        public string $streetName,
        public string $country,
        public string $city,
        public string $postalCode,
    ) {}
}
