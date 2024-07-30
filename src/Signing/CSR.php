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
use Illuminate\Filesystem\Filesystem;

class CSR
{
    public function __construct(
        public ZATCA $zatca,
        public Filesystem $files,
        public OpenSSLPemTemplate $pemTemplate,
        public CSRConfigTemplate $csrTemplate,
    ) {}

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
        $this->files->ensureDirectoryExists($this->zatca->getTempDirectory());

        $privateKeyPath = $this->zatca->getTempDirectory(uniqid().'.pem');
        $csrConfigPath = $this->zatca->getTempDirectory(uniqid().'.conf');

        $this->pemTemplate->build(path: $privateKeyPath);
        $this->csrTemplate->build(path: $csrConfigPath, options: $options);

        $output = Process::run(
            "openssl req -new -sha256 -key $privateKeyPath -config $csrConfigPath"
        );

        $this->files->delete([
            $privateKeyPath,
            $csrConfigPath,
        ]);

        return $output;
    }
}
