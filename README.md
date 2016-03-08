# support

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This package is the support for every jlourenco package. It does not depend on any other jlourenco package and it adds a few helper functions.

## Install

Via Composer

``` bash
$ composer require jlourenco/support
$ php artisan jlourenco:setup
```

## Usage

``` php
Schema::create('TestingTable', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name', 25);
    $table->string('description', 150)->nullable();
    $table->timestamps();
    $table->creation();
});

Schema::table('TestingTable', function (Blueprint $table) {
    $table->creationRelation();
});
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email jglourenco.pt@gmail.com instead of using the issue tracker.

## Credits

- [Joao Lourenco][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/jlourenco/support.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jlourenco/support/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/jlourenco/support.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/jlourenco/support.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/jlourenco/support.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/jlourenco/support
[link-travis]: https://travis-ci.org/joaogl/support
[link-scrutinizer]: https://scrutinizer-ci.com/g/joaogl/support/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/joaogl/support
[link-downloads]: https://packagist.org/packages/jlourenco/support
[link-author]: https://github.com/joaogl
[link-contributors]: ../../contributors
