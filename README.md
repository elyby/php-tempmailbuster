# PHP Tempmail Buster

[![Software License][ico-license]](LICENSE.md)

Расширяемый класс для блокировки E-mail адресов определённых доменов или организации белого списка допустимых доменов.
Реализует лоадер для загрузки и валидации по списку из [Anti Tempmail Repo](https://github.com/elyby/anti-tempmail-repo).

## Установка

Install the latest version with

```sh
$ composer require ely/php-tempmailbuster
```

## Использование

Пример использования с применением стандартного лоадера:

```php
use Ely\TempMailBuster\Loader\AntiTempmailRepo;
use Ely\TempMailBuster\Storage;
use Ely\TempMailBuster\Validator;

// Создаём класс лоадера
$loader = new AntiTempmailRepo();
// Загружаем из него данные и передаём их в объект хранилища
$storage = new Storage($loader->load();
// или используем статичный метод для работы с лоадерами
$storage = Storage::fromLoader($loader);
// Создаём класс-валидатор
$validator = new Validator($storage);
$validator->validate('team@ely.by'); // = true
$validator->validate('hy42k@sendspamhere.com'); // = false

// Включаем режим белого списка
$validator->whitelistMode();
$validator->validate('team@ely.by'); // = false
$validator->validate('hy42k@sendspamhere.com'); // = true
```

Конструктор принимает 2 аргумента: первичное и вторичное хранилище. Первичное хранилище работает в соответствии с
выбранным режимом работы библиотеки, а вторичное (если указано) позволяет добавить исключение из правил. Смотрите
больше примеров вызова метода `validate()` в [тестах](tests/ValidatorTest.php).

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

This package was designed and developed within the [Ely.by](http://ely.by) project team. We also thank all the
[contributors](link-contributors) for their help.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

[link-author]: https://github.com/ErickSkrauch
[link-contributors]: ../../contributors
