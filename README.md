# PHP Tempmail Buster

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

A package to protect your application from users with temp emails. Uses
[Anti Tempmail Repo](https://github.com/elyby/anti-tempmail-repo) as a default blacklist source. Provides an extendable
class for E-mail validation based on black- or whitelist.

## Intallation

Install the latest version with

```sh
$ composer require ely/php-tempmailbuster
```

## Usage

Validation example using default loader:

```php
use Ely\TempMailBuster\Loader\AntiTempmailRepo;
use Ely\TempMailBuster\Storage;
use Ely\TempMailBuster\Validator;

$loader = new AntiTempmailRepo();
// A storage can be instantiated by feeding it with an array of patterns:
$storage = new Storage($loader->load());
// or created from loader instance
$storage = Storage::fromLoader($loader);

$validator = new Validator($storage);
$validator->validate('team@ely.by'); // = true
$validator->validate('hy42k@sendspamhere.com'); // = false

// Enable whitelisting mode
$validator->whitelistMode();
$validator->validate('team@ely.by'); // = false
$validator->validate('hy42k@sendspamhere.com'); // = true
```

Validator constructor accepts 2 arguments: primary and secondary storages. Primary storage is used for validation based
on current mode (whitelist/blacklist). Secondary storage (if provided) allows you to add exceptions from primary
storage rules.

For more usage examples please take a look on [tests](tests/ValidatorTest.php).

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

This package was designed and developed within the [Ely.by](http://ely.by) project team. We also thank all the
[contributors](link-contributors) for their help.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/ely/php-tempmailbuster.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ely/php-tempmailbuster.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/ely/php-tempmailbuster
[link-author]: https://github.com/ErickSkrauch
[link-contributors]: ../../contributors
[link-downloads]: https://packagist.org/packages/ely/php-tempmailbuster
