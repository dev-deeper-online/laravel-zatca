# An unofficial Laravel package for generating ZATCA e-invoices.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dev-deeper-online/laravel-zatca.svg?style=flat-square)](https://packagist.org/packages/dev-deeper-online/laravel-zatca)
[![GitHub Tests Action Status](https://github.com/dev-deeper-online/laravel-zatca/actions/workflows/run-tests.yml/badge.svg)](https://github.com/dev-deeper-online/laravel-zatca/actions/workflows/run-tests.yml)
[![GitHub Code Style Action Status](https://github.com/dev-deeper-online/laravel-zatca/actions/workflows/fix-php-code-style-issues.yml/badge.svg)](https://github.com/dev-deeper-online/laravel-zatca/actions/workflows/fix-php-code-style-issues.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/dev-deeper-online/laravel-zatca.svg?style=flat-square)](https://packagist.org/packages/dev-deeper-online/laravel-zatca)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require dev-deeper-online/laravel-zatca
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-zatca-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-zatca-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-zatca-views"
```

## Usage

```php
$zATCA = new DevDeeper\ZATCA();
echo $zATCA->echoPhrase('Hello, DevDeeper!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [DevDeeper](https://github.com/dev-deeper-online)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
