<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\DTOs;

class PartyData
{
    public function __construct(
        public string $name,
        public string $commercialRegistrationNumber,
        public string $vatNumber,
        public AddressData $address,
    ) {}
}
