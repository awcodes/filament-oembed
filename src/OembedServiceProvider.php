<?php

namespace Awcodes\FilamentOembed;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class OembedServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-oembed';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasAssets()
            ->hasTranslations();
    }
}
