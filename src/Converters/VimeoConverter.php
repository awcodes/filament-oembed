<?php

namespace Awcodes\FilamentOembed\Converters;

use Awcodes\FilamentOembed\Interfaces\Converter;
use Illuminate\Support\Str;

class VimeoConverter implements Converter
{
    public static function make(string $url): string
    {
        if (Str::of($url)->contains('/video/')) {
            return $url;
        }

        preg_match('/\.com\/([0-9]+)/', $url, $matches);

        if (! $matches || ! $matches[1]) {
            return '';
        }

        return "https://player.vimeo.com/video/$matches[1]";
    }
}
