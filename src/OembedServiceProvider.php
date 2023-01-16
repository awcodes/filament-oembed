<?php

namespace Awcodes\FilamentOembed;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class OembedServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-oembed';

    protected array $styles = [
        'plugin-filament-oembed' => __DIR__.'/../resources/dist/filament-oembed.css',
    ];

    protected array $scripts = [
        'plugin-filament-oembed' => __DIR__.'/../resources/dist/filament-oembed.js',
    ];

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasAssets()
            ->hasTranslations();
    }
}
