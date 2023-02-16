<?php

namespace Awcodes\FilamentOembed\Interfaces;

interface Converter
{
    public static function make(string $url): string;
}
