<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\DTOs;

class EnvironmentMode
{
    public const PRODUCTION = 'production';

    public const SANDBOX = 'sandbox';

    public const SIMULATION = 'simulation';

    /**
     * Determine the given mode exists in the mode list.
     */
    public static function validate(string $mode): bool
    {
        return in_array($mode, [self::PRODUCTION, self::SANDBOX, self::SIMULATION]);
    }
}
