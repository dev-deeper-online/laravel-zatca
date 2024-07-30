<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\Templates;

use DevDeeper\ZATCA\DTOs\CSROptions;
use DevDeeper\ZATCA\Exceptions\InvalidModeException;
use Illuminate\Filesystem\Filesystem;

class CSRConfigTemplate
{
    public function __construct(
        protected Filesystem $files,
    ) {}

    public function build(string $path, CSROptions $options): void
    {
        $stub = $this->files->get($this->getStub());

        $this->files->put($path, $this->replaceVariables($stub, $options));
    }

    /**
     * Replace the variables for the given stub.
     *
     * @throws InvalidModeException
     */
    protected function replaceVariables(string $stub, CSROptions $options): string
    {
        return str_replace([
            '{{ENVIRONMENT_MODE}}',
            '{{SN}}',
            '{{UID}}',
            '{{TITLE}}',
            '{{REGISTERED_ADDRESS}}',
            '{{BUSINESS_CATEGORY}}',
            '{{COMMON_NAME}}',
            '{{ORGANIZATIONAL_UNIT_NAME}}',
            '{{ORGANIZATION_NAME}}',
            '{{COUNTRY_NAME}}',
        ], [
            $options->getMode(),
            ('1-'.$options->egsSolutionName.'|2-'.$options->egsModel.'|3-'.$options->egsSerialNumber),
            $options->organizationIdentifier,
            $options->invoiceType,
            $options->address,
            $options->businessCategory,
            $options->commonName,
            $options->organizationUnit,
            $options->organizationName,
            $options->country,
        ], $stub);
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/csr_config.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     */
    protected function resolveStubPath(string $stub): string
    {
        return $this->files->exists($customPath = base_path(trim($stub, '/')))
            ? $customPath
            : __DIR__.'/../..'.$stub;
    }
}
