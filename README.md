# This is my package filament-oembed

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awcodes/filament-oembed.svg?style=flat-square)](https://packagist.org/packages/awcodes/filament-oembed)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/awcodes/filament-oembed/run-tests?label=tests)](https://github.com/awcodes/filament-oembed/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/awcodes/filament-oembed/Check%20&%20fix%20styling?label=code%20style)](https://github.com/awcodes/filament-oembed/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/awcodes/filament-oembed.svg?style=flat-square)](https://packagist.org/packages/awcodes/filament-oembed)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require awcodes/filament-oembed
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-oembed-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-oembed-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-oembed-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filament-oembed = new Awcodes\FilamentOembed();
echo $filament-oembed->echoPhrase('Hello, Awcodes!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [awcodes](https://github.com/awcodes)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
