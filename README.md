[![Latest Version on Packagist](https://img.shields.io/packagist/v/denand/tvdb-v4-client.svg?style=flat-square)](https://packagist.org/packages/denand/tvdb-v4-client)
[![Total Downloads](https://img.shields.io/packagist/dt/denand/tvdb-v4-client.svg?style=flat-square)](https://packagist.org/packages/denand/tvdb-v4-client)
![GitHub Actions](https://github.com/denand/tvdb-v4-client/actions/workflows/main.yml/badge.svg)

This package is the client for The TVDB V4 API. All docs [are here](https://thetvdb.github.io/v4-api/).

## Installation

You can install the package via composer. Add it to _"repositories"_ of **composer.json**:

        `{
            "type": "git",
            "url": "https://github.com/denand-team/tvdb-v4-client"
        },`

Then run:

```bash
composer require denand/tvdb-v4-client
```

Configure it with your auth data. Publish config:
```bash
php artisan vendor:publish
```

And edit inside _config/tvdb-v4-client.php_


## Usage

```php
$tvdb = new TvdbV4Client();
$series = $tvdb->getSeries('269586'); // Get Extended data for TV Series
$series = $tvdb->getSeriesTranslations('269586', 'eng'); //  Get Series Translations records.
$series = $tvdb->getSeriesFull('269586', 'eng'); //  Get Series Translations and extended at once.
$search = $tvdb->search('Brooklyn Nine-Nine'); // Search data on TheTVDB
$search = $tvdb->getSeriesByName('Brooklyn Nine-Nine'); // Search and get Extended Data from TheTVDB
```



### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email denandteam@gmail.com instead of using the issue tracker.

## Credits

-   [DenAnd](https://github.com/denand)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
