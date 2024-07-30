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
            '{{TITLE}}',
            '{{COMMON_NAME}}',
            '{{UID}}',
            '{{ORGANIZATION_NAME}}',
            '{{ORGANIZATIONAL_UNIT_NAME}}',
            '{{COUNTRY_NAME}}',
            '{{REGISTERED_ADDRESS}}',
            '{{BUSINESS_CATEGORY}}',
        ], [
            $options->getMode(),
            ('1-'.$options->egs->solutionName.'|2-'.$options->egs->model.'|3-'.$options->egs->serialNumber),
            $options->invoiceType,
            $options->commonName,
            $options->organization->identifier,
            $options->organization->name,
            $options->organization->unit,
            $options->organization->country,
            $options->organization->address,
            $options->organization->category,
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
