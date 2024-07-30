<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\Concerns;

use DevDeeper\ZATCA\DTOs\CSIDOptions;
use DevDeeper\ZATCA\DTOs\CSROptions;
use DevDeeper\ZATCA\DTOs\EnvironmentMode;
use DevDeeper\ZATCA\Exceptions\InvalidBaseURLException;
use DevDeeper\ZATCA\Exceptions\InvalidModeException;
use DevDeeper\ZATCA\Http\CSID;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\CircularDependencyException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

trait InteractWithCSID
{
    protected ?int $complianceRequestId = null;

    protected ?string $binarySecurityToken = null;

    protected ?string $secret = null;

    protected CSROptions $csrOptions;

    protected string $otp;

    public function csrOptions(CSROptions $options): self
    {
        $this->csrOptions = $options;

        return $this;
    }

    public function otp(string $otp): self
    {
        $this->otp = $otp;

        return $this;
    }

    public function setComplianceRequestId(?int $complianceRequestId): self
    {
        $this->complianceRequestId = $complianceRequestId;

        return $this;
    }

    public function setBinarySecurityToken(?string $binarySecurityToken): self
    {
        $this->binarySecurityToken = $binarySecurityToken;

        return $this;
    }

    public function setSecret(?string $secret): self
    {
        $this->secret = $secret;

        return $this;
    }

    public function getComplianceRequestId(): ?int
    {
        return $this->complianceRequestId;
    }

    public function getBinarySecurityToken(): ?string
    {
        return $this->binarySecurityToken;
    }

    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * Issue a new Cryptographic Stamp Identifier.
     *
     * @throws InvalidModeException
     * @throws InvalidBaseURLException
     * @throws BindingResolutionException
     * @throws CircularDependencyException
     * @throws ConnectionException
     * @throws RequestException
     */
    protected function issueCSID(): void
    {
        $csid = app(CSID::class);

        $csid->issue(new CSIDOptions(
            csrOptions: $this->csrOptions,
            otp: $this->otp,
        ));

        if ($this->getMode() !== EnvironmentMode::SANDBOX) {
            $csid->issueProduction();
        }
    }
}
