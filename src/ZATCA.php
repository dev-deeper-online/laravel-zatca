<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA;

use DevDeeper\ZATCA\Concerns\InteractWithCSID;
use DevDeeper\ZATCA\Concerns\InteractWithInvoice;
use DevDeeper\ZATCA\DTOs\EnvironmentMode;
use DevDeeper\ZATCA\Exceptions\InvalidBaseURLException;
use DevDeeper\ZATCA\Exceptions\InvalidModeException;

class ZATCA
{
    use InteractWithCSID;
    use InteractWithInvoice;

    /**
     * Get base url for ZATCA services.
     *
     * @throws InvalidBaseURLException
     * @throws InvalidModeException
     */
    public static function getBaseURL(): string
    {
        $mode = self::getMode();
        $baseUrl = config("zatca.$mode.base_url");

        if (is_null($baseUrl)) {
            throw new InvalidBaseURLException('Invalid base url for zatca services.');
        }

        return $baseUrl;
    }

    /**
     * Get temp directory.
     */
    public static function getTempDirectory(string $path = ''): string
    {
        $path = trim($path, '/');
        $dir = config('zatca.temp_directory', storage_path('zatca/temp'));

        return "$dir/$path";
    }

    /**
     * Get ZATCA api mode.
     *
     * @throws InvalidModeException
     */
    public static function getMode(): mixed
    {
        $mode = config('zatca.mode', EnvironmentMode::SANDBOX);

        if (! EnvironmentMode::validate($mode)) {
            throw new InvalidModeException('Invalid mode for zatca services.');
        }

        return $mode;
    }

    /**
     * Get ZATCA api version.
     */
    public static function getVersion(): string
    {
        return config('zatca.version', 'v2');
    }
}
