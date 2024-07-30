<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\DTOs;

use DevDeeper\ZATCA\Exceptions\InvalidModeException;
use DevDeeper\ZATCA\ZATCA;

class CSROptions
{
    public function __construct(
        public string $egsSolutionName,
        public string $egsModel,
        public string $egsSerialNumber,
        public string $invoiceType,
        public string $commonName,
        public string $organizationIdentifier,
        public string $organizationName,
        public string $organizationUnit,
        public string $businessCategory,
        public string $address,
        public string $country = 'SA',
    ) {}

    /**
     * @throws InvalidModeException
     */
    public function getMode(): string
    {
        return match (ZATCA::getMode()) {
            EnvironmentMode::PRODUCTION => 'ZATCA-Code-Signing',
            EnvironmentMode::SIMULATION => 'PREZATCA-Code-Signing',
            EnvironmentMode::SANDBOX => 'TSTZATCA-Code-Signing',
        };
    }
}
