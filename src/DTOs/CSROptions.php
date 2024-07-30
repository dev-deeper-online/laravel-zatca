<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\DTOs;

use DevDeeper\ZATCA\Exceptions\InvalidModeException;
use DevDeeper\ZATCA\ZATCA;

class CSROptions
{
    public function __construct(
        public EGSData $egs,
        public OrganizationData $organization,
        public string $invoiceType,
        public string $commonName,
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
