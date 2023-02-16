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
                    Forms\Components\Hidden::make($field.'.provider')
                        ->default('youtube'),
                    Forms\Components\TextInput::make($field.'.url')
                        ->label(fn (): string => __('filament-oembed::oembed.url'))
                        ->reactive()
                        ->lazy()
                        ->required()
                        ->columnSpanFull()
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) use ($field) {
                            if ($state) {
                                $provider = Str::of($state)->contains('vimeo') ? 'vimeo' : 'youtube';

                                $embed_url = match ($provider) {
                                    'vimeo' => static::getVimeoUrl($state),
                                    default => static::getYoutubeUrl($state),
                                };

                                $set($field.'.embed_url', $embed_url);
                                $set($field.'.provider', $provider);
                            }
                        }),
                    Forms\Components\Checkbox::make($field.'.responsive')
                        ->label(fn (): string => __('filament-oembed::oembed.responsive'))
                        ->default(true)
                        ->reactive()
                        ->columnSpanFull()
                        ->afterStateHydrated(function ($component, $state) {
                            if (! $state) {
                                $component->state(true);
                            }
                        })
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) use ($field) {
                            if ($state) {
                                $set($field.'.width', '16');
                                $set($field.'.height', '9');
                            } else {
                                $set($field.'.width', '640');
                                $set($field.'.height', '480');
                            }
                        }),
                    Forms\Components\Group::make([
                        Forms\Components\TextInput::make($field.'.width')
                            ->label(fn (): string => __('filament-oembed::oembed.width'))
                            ->reactive()
                            ->required()
                            ->default('16')
                            ->afterStateHydrated(function ($component, $state) {
                                if (! $state) {
                                    $component->state('16');
                                }
                            }),
                        Forms\Components\TextInput::make($field.'.height')
                            ->label(fn (): string => __('filament-oembed::oembed.height'))
                            ->reactive()
                            ->required()
                            ->default('9')
                            ->afterStateHydrated(function ($component, $state) {
                                if (! $state) {
                                    $component->state('9');
                                }
                            }),
                    ])->columns(['md' => 2]),
                    Forms\Components\CheckboxList::make($field.'.options')
                        ->bulkToggleable()
                        ->columns(3)
                        ->reactive()
                        ->options([
                            'autoplay' => __('filament-oembed::oembed.autoplay'),
                            'loop' => __('filament-oembed::oembed.loop'),
                            'title' => __('filament-oembed::oembed.title'),
                            'byline' => __('filament-oembed::oembed.byline'),
                            'portrait' => __('filament-oembed::oembed.portrait'),
                        ]),
                ]),
                Forms\Components\ViewField::make($field)
                    ->label(fn (): string => __('filament-oembed::oembed.preview'))
                    ->view('filament-oembed::forms.components.oembed-preview'),
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

        return "https://player.vimeo.com/video/{$matches[1]}";
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

        return "https://www.youtube.com/embed/{$matches[1]}";
    }
}
