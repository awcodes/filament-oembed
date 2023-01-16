<?php

namespace Awcodes\FilamentOembed;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentOembedServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-oembed';

    protected array $resources = [
        // CustomResource::class,
    ];

    protected array $pages = [
        // CustomPage::class,
    ];

    protected array $widgets = [
        // CustomWidget::class,
    ];

    protected array $styles = [
        'plugin-filament-oembed' => __DIR__.'/../resources/dist/filament-oembed.css',
    ];

    protected array $scripts = [
        'plugin-filament-oembed' => __DIR__.'/../resources/dist/filament-oembed.js',
    ];

    // protected array $beforeCoreScripts = [
    //     'plugin-filament-oembed' => __DIR__ . '/../resources/dist/filament-oembed.js',
    // ];

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name);
    }
}
