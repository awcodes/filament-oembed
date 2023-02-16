<?php

namespace Awcodes\FilamentOembed\Converters;

use Awcodes\FilamentOembed\Interfaces\Converter;
use Illuminate\Support\Str;

class YoutubeConverter implements Converter
{
    public static function make(string $url): string
    {
        if (Str::of($url)->contains('/embed/')) {
            return $url;
        }

        preg_match('/v=([-\w]+)/', $url, $matches);

        if (! $matches || ! $matches[1]) {
            return '';
        }

        return "https://www.youtube.com/embed/$matches[1]";
    }
}
