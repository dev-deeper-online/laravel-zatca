<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA\Templates;

use Illuminate\Filesystem\Filesystem;

abstract class Template
{
    public function __construct(
        protected Filesystem $files,
    ) {}

    /**
     *  Get the stub file for the generator.
     */
    abstract protected function getStub(): string;

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
