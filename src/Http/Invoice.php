<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\Http;

use DevDeeper\ZATCA\DTOs\HttpOptions;
use DevDeeper\ZATCA\DTOs\InvoiceData;
use DevDeeper\ZATCA\Exceptions\InvalidBaseURLException;
use DevDeeper\ZATCA\Exceptions\InvalidModeException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class Invoice extends Client
{
    /**
     * @throws InvalidModeException
     * @throws InvalidBaseURLException
     * @throws ConnectionException
     * @throws RequestException
     */
    public function issue(InvoiceData $invoice): void
    {
        $this->request(new HttpOptions(
            method: 'post',
            path: 'invoices/reporting/single',
            body: [
                'uuid' => $invoice->uuid,
                'invoiceHash' => $invoice->invoiceHash,
                'invoice' => $invoice->base64,
            ],
            headers: [
                'Clearance-Status' => $invoice->cleared,
            ],
        ));
    }
}
