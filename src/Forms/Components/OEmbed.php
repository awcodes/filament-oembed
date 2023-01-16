<?php

namespace Awcodes\FilamentOembed\Forms\Components;

use Closure;
use Filament\Forms;
use Illuminate\Support\Str;

class OEmbed
{
    public static function make(string $field = 'oembed'): Forms\Components\Fieldset
    {
        return Forms\Components\Fieldset::make($field)
            ->label(fn (): string => Str::of($field)->title())
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Hidden::make($field.'.embed_url'),
                    Forms\Components\Hidden::make($field.'.embed_type')
                        ->default('youtube'),
                    Forms\Components\TextInput::make($field.'.url')
                        ->label(fn (): string => __('filament-oembed::oembed.url'))
                        ->reactive()
                        ->lazy()
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) use ($field) {
                            if ($state) {
                                $embed_type = Str::of($state)->contains('vimeo') ? 'vimeo' : 'youtube';
                                if ($embed_type == 'vimeo') {
                                    $embed_url = static::getVimeoUrl($state);
                                } else {
                                    $embed_url = static::getYoutubeUrl($state);
                                }
                                $set($field.'.embed_url', $embed_url);
                                $set($field.'.embed_type', $embed_type);
                            }
                        })
                        ->required()
                        ->columnSpan('full'),
                    Forms\Components\Checkbox::make($field.'.responsive')
                        ->default(true)
                        ->reactive()
                        ->label(fn (): string => __('filament-oembed::oembed.responsive'))
                        ->afterStateHydrated(function ($component, $state) {
                            if (! $state) {
                                $component->state(true);
                            };
                        })
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) use ($field) {
                            if ($state) {
                                $set($field.'.width', '16');
                                $set($field.'.height', '9');
                            } else {
                                $set($field.'.width', '640');
                                $set($field.'.height', '480');
                            }
                        })
                        ->columnSpan('full'),
                    Forms\Components\Group::make([
                        Forms\Components\TextInput::make($field.'.width')
                            ->reactive()
                            ->required()
                            ->label(fn (): string => __('filament-oembed::oembed.width'))
                            ->default('16')
                            ->afterStateHydrated(function ($component, $state) {
                                if (! $state) {
                                    $component->state('16');
                                };
                            }),
                        Forms\Components\TextInput::make($field.'.height')
                            ->reactive()
                            ->required()
                            ->label(fn (): string => __('filament-oembed::oembed.height'))
                            ->default('9')
                            ->afterStateHydrated(function ($component, $state) {
                                if (! $state) {
                                    $component->state('9');
                                };
                            }),
                    ])->columns(['md' => 2]),
                    Forms\Components\Grid::make(['md' => 3])
                        ->schema([
                            Forms\Components\Group::make([
                                Forms\Components\Checkbox::make($field.'.autoplay')
                                    ->default(false)
                                    ->label(fn (): string => __('filament-oembed::oembed.autoplay'))
                                    ->reactive(),
                                Forms\Components\Checkbox::make($field.'.loop')
                                    ->default(false)
                                    ->label(fn (): string => __('filament-oembed::oembed.loop'))
                                    ->reactive(),
                            ]),
                            Forms\Components\Group::make([
                                Forms\Components\Checkbox::make($field.'.show_title')
                                    ->default(false)
                                    ->label(fn (): string => __('filament-oembed::oembed.title'))
                                    ->reactive(),
                                Forms\Components\Checkbox::make($field.'.byline')
                                    ->default(false)
                                    ->label(fn (): string => __('filament-oembed::oembed.byline'))
                                    ->reactive(),
                            ]),
                            Forms\Components\Group::make([
                                Forms\Components\Checkbox::make($field.'.portrait')
                                    ->default(false)
                                    ->label(fn (): string => __('filament-oembed::oembed.portrait'))
                                    ->reactive(),
                            ]),
                        ]),
                ]),
                Forms\Components\ViewField::make($field)
                    ->view('filament-oembed::forms.components.oembed')
                    ->label(fn (): string => __('filament-oembed::oembed.preview')),
            ]);
    }

    public static function getVimeoUrl(string $url): string
    {
        if (Str::of($url)->contains('/video/')) {
            return $url;
        }

        preg_match('/\.com\/([0-9]+)/', $url, $matches);

        if (! $matches || ! $matches[1]) {
            return '';
        }

        $outputUrl = "https://player.vimeo.com/video/{$matches[1]}";

        return $outputUrl;
    }

    public static function getYoutubeUrl(string $url): string
    {
        if (Str::of($url)->contains('/embed/')) {
            return $url;
        }

        preg_match('/v=([-\w]+)/', $url, $matches);

        if (! $matches || ! $matches[1]) {
            return '';
        }

        $outputUrl = "https://www.youtube.com/embed/{$matches[1]}";

        return $outputUrl;
    }
}
