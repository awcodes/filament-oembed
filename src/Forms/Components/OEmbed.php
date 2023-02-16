<?php

namespace Awcodes\FilamentOembed\Forms\Components;

use Awcodes\FilamentOembed\Converters\VimeoConverter;
use Awcodes\FilamentOembed\Converters\YoutubeConverter;
use Closure;
use Filament\Forms;
use Illuminate\Support\Str;
use Filament\Forms\Components\Fieldset;

class OEmbed extends Fieldset
{
    protected array $converters = [
        'vimeo' => VimeoConverter::class,
        'youtube' => YoutubeConverter::class,
    ];

    protected function setUp(): void
    {
        $name = Str::snake($this->getLabel());

        $this->schema([
            Forms\Components\Group::make([
                Forms\Components\Hidden::make($name . '.embed_url'),
                Forms\Components\Hidden::make($name . '.provider')
                    ->default('youtube'),
                Forms\Components\TextInput::make($name . '.url')
                    ->label(fn (): string => __('filament-oembed::oembed.url'))
                    ->reactive()
                    ->lazy()
                    ->required()
                    ->columnSpanFull()
                    ->afterStateUpdated(function (Closure $set, Closure $get, $state) use ($name) {
                        if ($state) {
                            $provider = $this->getProvider($state);
                            $embed_url = $this->getConverters()[$provider]::make($state);

                            $set($name . '.embed_url', $embed_url);
                            $set($name . '.provider', $provider);
                        }
                    }),
                Forms\Components\Checkbox::make($name . '.responsive')
                    ->label(fn (): string => __('filament-oembed::oembed.responsive'))
                    ->default(true)
                    ->reactive()
                    ->columnSpanFull()
                    ->afterStateHydrated(function ($component, $state) {
                        if (! $state) {
                            $component->state(true);
                        }
                    })
                    ->afterStateUpdated(function (Closure $set, Closure $get, $state) use ($name) {
                        if ($state) {
                            $set($name . '.width', '16');
                            $set($name . '.height', '9');
                        } else {
                            $set($name . '.width', '640');
                            $set($name . '.height', '480');
                        }
                    }),
                Forms\Components\Group::make([
                    Forms\Components\TextInput::make($name . '.width')
                        ->label(fn (): string => __('filament-oembed::oembed.width'))
                        ->reactive()
                        ->required()
                        ->default('16')
                        ->afterStateHydrated(function ($component, $state) {
                            if (! $state) {
                                $component->state('16');
                            }
                        }),
                    Forms\Components\TextInput::make($name . '.height')
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
                Forms\Components\CheckboxList::make($name . '.options')
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
            Forms\Components\ViewField::make($name)
                ->label(fn (): string => __('filament-oembed::oembed.preview'))
                ->view('filament-oembed::forms.components.oembed-preview'),
        ])
        ->columns(['md' => 2, 'lg' => null]);
    }

    public function converters(array|null $converters): static
    {
        $this->converters = array_merge($this->converters, $converters);

        return $this;
    }

    public function getProvider(string $url): string
    {
        $domain = parse_url((! str_contains($url, '://') ? 'http://' : '') . trim($url), PHP_URL_HOST);

        if (preg_match('/[a-z0-9][a-z0-9\-]{0,63}\.[a-z]{2,6}(\.[a-z]{1,2})?$/i', $domain, $match))
        {
            return Str::before($match[0], '.');
        }

        return 'youtube';
    }

    public function getConverters(): array
    {
        return $this->evaluate($this->converters);
    }
}
