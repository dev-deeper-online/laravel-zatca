<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\Concerns;

use DevDeeper\ZATCA\DTOs\InvoiceData;
use DevDeeper\ZATCA\Exceptions\InvalidBaseURLException;
use DevDeeper\ZATCA\Exceptions\InvalidModeException;
use DevDeeper\ZATCA\Http\Invoice;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\CircularDependencyException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

trait InteractWithInvoice
{
    /**
     * @throws CircularDependencyException
     * @throws InvalidModeException
     * @throws InvalidBaseURLException
     * @throws ConnectionException
     * @throws RequestException
     * @throws BindingResolutionException
     */
    public function issueInvoice(InvoiceData $invoice)
    {
        $this->issueCSID();

        app(Invoice::class)->check($invoice);
    }
}
