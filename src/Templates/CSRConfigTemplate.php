<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\Templates;

use DevDeeper\ZATCA\DTOs\CSROptions;
use DevDeeper\ZATCA\Exceptions\InvalidModeException;

class CSRConfigTemplate extends Template
{
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
            '{{SERIAL_NUMBER}}',
            '{{INVOICE_TYPE}}',
            '{{COMMON_NAME}}',
            '{{VAT_REGISTRATION_NUMBER}}',
            '{{ORGANIZATION_NAME}}',
            '{{ORGANIZATION_BRANCH_NAME}}',
            '{{REGISTERED_ADDRESS}}',
            '{{BUSINESS_CATEGORY}}',
        ], [
            $options->getMode(),
            ('1-'.$options->egs->solutionName.'|2-'.$options->egs->model.'|3-'.$options->egs->serialNumber),
            $options->invoiceType,
            $options->commonName,
            $options->organization->vat_registration_number,
            $options->organization->name,
            $options->organization->branch,
            $options->organization->address,
            $options->organization->category,
        ], $stub);
    }

    /**
     * {@inheritdoc}
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/csr_config.stub');
    }
}
