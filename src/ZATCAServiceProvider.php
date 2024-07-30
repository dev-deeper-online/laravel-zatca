<?php

declare(strict_types=1);

namespace DevDeeper\ZATCA;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ZATCAServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-zatca')
            ->hasConfigFile('zatca');
    }

    public function registeringPackage(): void
    {
        $this->app->singleton(ZATCA::class);
    }
}
