<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\Signing;

use DevDeeper\ZATCA\DTOs\CSROptions;
use DevDeeper\ZATCA\Shell\Process;
use DevDeeper\ZATCA\Templates\CSRConfigTemplate;
use DevDeeper\ZATCA\Templates\OpenSSLPemTemplate;
use DevDeeper\ZATCA\ZATCA;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\CircularDependencyException;
use Illuminate\Support\Facades\File;

class CSR
{
    /**
     * Generate Base64 hash of the OpenSSl key.
     *
     * @throws BindingResolutionException
     * @throws CircularDependencyException
     */
    public function toBase64(CSROptions $options): string
    {
        return base64_encode($this->generate($options));
    }

    /**
     * Generate OpenSSL `sha256` key with the given CSR options.
     *
     * @throws BindingResolutionException
     * @throws CircularDependencyException
     */
    protected function generate(CSROptions $options): string
    {
        File::ensureDirectoryExists(ZATCA::getTempDirectory());

        $privateKeyPath = ZATCA::getTempDirectory(uniqid().'.pem');
        $csrConfigPath = ZATCA::getTempDirectory(uniqid().'.conf');

        app(OpenSSLPemTemplate::class)->build(path: $privateKeyPath);
        app(CSRConfigTemplate::class)->build(path: $csrConfigPath, options: $options);

        $output = Process::run(
            "openssl req -new -sha256 -key $privateKeyPath -config $csrConfigPath"
        );

        File::delete([
            $privateKeyPath,
            $csrConfigPath,
        ]);

        return $output;
    }
}
