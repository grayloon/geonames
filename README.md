# PHP GeoNames API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/grayloon/geonames.svg?style=flat-square)](https://packagist.org/packages/grayloon/geonames)
[![Total Downloads](https://img.shields.io/packagist/dt/grayloon/geonames.svg?style=flat-square)](https://packagist.org/packages/grayloon/geonames)

A simple Object Oriented wrapper for GeoNames API, written with PHP.

> This project is a work in progress.

## Requirements
- PHP >= 7.1
- GeoNames Account
- (optional) PHPUnit to run tests.

## Installation

You can install the package via composer:

```bash
composer require grayloon/geonames
```

## Usage
An overview of available API parameters for each endpoint is [available here](http://www.geonames.org/export/ws-overview.html).

``` php
    $geonames = new \Grayloon\Geonames('your_username');

    $result = $geonames->postalCodeSearch([
        'country' => 'US',
        'postalcode' => '47579',
    ]);  
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email webmaster@grayloon.com instead of using the issue tracker.

## Credits

- [Gray Loon Marketing Group Developers](https://github.com/grayloon)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
