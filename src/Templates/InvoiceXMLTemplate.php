<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\Templates;

use DevDeeper\ZATCA\DTOs\InvoiceData;

class InvoiceXMLTemplate extends Template
{
    public function build(InvoiceData $invoice): string
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceVariables($stub, $invoice);
    }

    /**
     * Replace the variables for the given stub.
     */
    protected function replaceVariables(string $stub, InvoiceData $invoice): string
    {
        return str_replace([
            '{{UBL_EXTENSIONS_STRING}}',
            '{{INVOICE_SERIAL_NUMBER}}',
            '{{TERMINAL_UUID}}',
            '{{ISSUE_DATE}}',
            '{{ISSUE_TIME}}',
            '{{INVOICE_TYPE}}',
            '{{BILLING_REFERENCE}}',
            '{{INVOICE_COUNTER_NUMBER}}',
            '{{PREVIOUS_INVOICE_HASH}}',
            '{{QR_CODE_DATA}}',
            '{{COMMERCIAL_REGISTRATION_NUMBER}}',
            '{{STREET_NAME}}',
            '{{BUILDING_NUMBER}}',
            '{{PLOT_IDENTIFICATION}}',
            '{{CITY_SUBDIVISION}}',
            '{{CITY}}',
            '{{POSTAL_NUMBER}}',
            '{{VAT_NUMBER}}',
            '{{VAT_NAME}}',
        ], [
            '',
            $invoice->serialNumber,
            $invoice->uuid,
            $invoice->issueDate->format('Y-m-d'),
            $invoice->issueDate->format('H:i:s'),
            $invoice->invoiceType,
            '',
            $invoice->counterNumber,
            $invoice->previousHash,
            base64_encode($invoice->qrCode),
            $invoice->party->commercialRegistrationNumber,
            $invoice->party->address->streetName,
            $invoice->party->address->streetName,
            $invoice->party->address->streetName,
            $invoice->party->address->city,
            $invoice->party->address->city,
            $invoice->party->address->postalCode,
            $invoice->party->vatNumber,
            $invoice->party->vatNumber,
        ], $stub);
    }

    /**
     * {@inheritdoc}
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/invoice_xml.stub');
    }
}
