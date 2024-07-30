<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\DTOs;

class EGSData
{
    public function __construct(
        public string $solutionName,
        public string $model,
        public string $serialNumber,
    ) {}
}
