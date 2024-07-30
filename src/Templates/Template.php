<?php

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

}
