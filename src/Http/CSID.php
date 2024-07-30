<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\Http;

use DevDeeper\ZATCA\DTOs\CSIDOptions;
use DevDeeper\ZATCA\DTOs\HttpOptions;
use DevDeeper\ZATCA\Exceptions\InvalidBaseURLException;
use DevDeeper\ZATCA\Exceptions\InvalidModeException;
use DevDeeper\ZATCA\Signing\CSR;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\CircularDependencyException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class CSID extends Client
{
    /**
     * Issue a new Cryptographic Stamp Identifier.
     *
     * @throws BindingResolutionException
     * @throws CircularDependencyException
     * @throws ConnectionException
     * @throws InvalidBaseURLException
     * @throws InvalidModeException
     * @throws RequestException
     */
    public function issue(CSIDOptions $options): void
    {
        if (filled($this->zatca->getBinarySecurityToken()) && filled($this->zatca->getSecret())) {
            return;
        }

        $csrBase64 = app(CSR::class)->toBase64($options->csrOptions);

        $data = $this->request(new HttpOptions(
            method: 'post',
            path: 'compliance',
            body: ['csr' => $csrBase64],
            headers: ['OTP' => $options->otp],
            authenticated: false,
        ));

        if (isset($data['dispositionMessage']) && $data['dispositionMessage'] === 'ISSUED') {
            $this->zatca->setComplianceRequestId($data['requestID']);
            $this->zatca->setBinarySecurityToken($data['binarySecurityToken']);
            $this->zatca->setSecret($data['secret']);
        }
    }

    /**
     * Production Cryptographic Stamp Identifier (Onboarding) API.
     *
     * @throws InvalidModeException
     * @throws InvalidBaseURLException
     * @throws ConnectionException
     * @throws RequestException
     */
    public function issueProduction(): void
    {
        $this->request(new HttpOptions(
            method: 'post',
            path: 'production/csids',
            body: ['compliance_request_id' => $this->zatca->getComplianceRequestId()],
        ));
    }

    /**
     * Renew Production Cryptographic Stamp Identifier API.
     *
     * @throws InvalidModeException
     * @throws CircularDependencyException
     * @throws InvalidBaseURLException
     * @throws ConnectionException
     * @throws RequestException
     * @throws BindingResolutionException
     */
    public function renewProduction(CSIDOptions $options): void
    {
        $csrBase64 = app(CSR::class)->toBase64($options->csrOptions);

        $this->request(new HttpOptions(
            method: 'patch',
            path: 'production/csids',
            body: ['csr' => $csrBase64],
            headers: ['OTP' => $options->otp]
        ));
    }
}
