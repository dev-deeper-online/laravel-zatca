<?php

declare(strict_types=1);

use DevDeeper\ZATCA\DTOs\EnvironmentMode;

return [
    'version' => 'v2',

    'mode' => env('ZATCA_MODE', EnvironmentMode::PRODUCTION),

    'temp_directory' => storage_path('zatca/temp'),

    EnvironmentMode::PRODUCTION => [
        'base_url' => 'https://gw-fatoora.zatca.gov.sa/e-invoicing/core',
    ],
    EnvironmentMode::SANDBOX => [
        'base_url' => 'https://gw-apic-gov.gazt.gov.sa/e-invoicing/developer-portal',
    ],
    EnvironmentMode::SIMULATION => [
        'base_url' => 'https://gw-fatoora.zatca.gov.sa/e-invoicing/simulation',
    ],
];
