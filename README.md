[![Latest Version on Packagist](https://img.shields.io/packagist/v/denand/tvdb-v4-client.svg?style=flat-square)](https://packagist.org/packages/denand/tvdb-v4-client)
[![Total Downloads](https://img.shields.io/packagist/dt/denand/tvdb-v4-client.svg?style=flat-square)](https://packagist.org/packages/denand/tvdb-v4-client)
[![License](https://img.shields.io/packagist/l/denand/tvdb-v4-client.svg?style=flat-square)](https://packagist.org/packages/denand/tvdb-v4-client)

# TVDB V4 Client for PHP/Laravel

A comprehensive PHP client for The TVDB V4 API, designed to work seamlessly with Laravel applications. This package provides easy access to The TVDB's extensive database of TV series, movies, and related metadata.

## 📚 Official Documentation

- **[The TVDB V4 API Documentation](https://thetvdb.github.io/v4-api/)** - Complete API reference and endpoints
- **[The TVDB API Information & Licensing](https://www.thetvdb.com/api-information)** - API pricing, licensing, and attribution requirements

## 🚀 Features

- **Full TVDB V4 API Support** - Access to all available endpoints
- **Laravel Integration** - Seamless Laravel service provider and facade
- **Extended Data Support** - Get comprehensive series, episode, and movie information
- **Translation Support** - Multi-language content retrieval
- **Search Functionality** - Powerful search capabilities across the database
- **Type and Status Support** - Access to metadata types and statuses
- **Laravel 10 Compatible** - Updated for the latest Laravel version

## 📦 Installation

### Via Composer

You can install the package with Composer using Packagist:

```bash
composer require denand/tvdb-v4-client
```

### Configuration

1. **Publish the configuration file:**
```bash
php artisan vendor:publish --provider="DenAnd\TvdbV4Client\TvdbV4ClientServiceProvider"
```

2. **Configure your TVDB API credentials in `config/tvdb-v4-client.php`:**
```php
return [
    'api_key' => env('TVDB_API_KEY', ''),
    'api_pin' => env('TVDB_API_PIN', ''),
    // Add other configuration options as needed
];
```

3. **Add your TVDB API credentials to your `.env` file:**
```env
TVDB_API_KEY=your_api_key_here
TVDB_API_PIN=your_api_pin_here
```

## 🔧 Usage

### Basic Usage

```php
use DenAnd\TvdbV4Client\TvdbV4Client;

$tvdb = new TvdbV4Client();

// Get extended data for a TV series
$series = $tvdb->getSeries('269586');

// Get series translations
$translations = $tvdb->getSeriesTranslations('269586', 'eng');

// Get series with full data (translations + extended data)
$seriesFull = $tvdb->getSeriesFull('269586', 'eng');

// Search for series
$search = $tvdb->search('Brooklyn Nine-Nine');

// Search and get extended data
$seriesByName = $tvdb->getSeriesByName('Brooklyn Nine-Nine');
```

### Laravel Facade Usage

```php
use DenAnd\TvdbV4Client\Facades\TvdbV4Client;

// Using the facade
$series = TvdbV4Client::getSeries('269586');
$search = TvdbV4Client::search('Breaking Bad');
```

### Available Methods

- `getSeries($id)` - Get extended series data
- `getSeriesTranslations($id, $language)` - Get series translations
- `getSeriesFull($id, $language)` - Get series with translations and extended data
- `search($query)` - Search for series, movies, or people
- `getSeriesByName($name)` - Search and get extended data by name
- `getTypes()` - Get available types
- `getStatuses()` - Get available statuses

## 🧪 Testing

```bash
composer test
```

## 📋 Requirements

- PHP 7.4 or higher
- Laravel 8.0+ (for Laravel integration)
- The TVDB API credentials

## 🔗 API Documentation & Resources

- **[The TVDB V4 API Documentation](https://thetvdb.github.io/v4-api/)** - Complete API reference
- **[The TVDB API Information](https://www.thetvdb.com/api-information)** - Licensing, pricing, and attribution requirements
- **[The TVDB Website](https://www.thetvdb.com/)** - Main website and data contribution

## 📄 Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes.

## 🤝 Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email denandteam@gmail.com instead of using the issue tracker.

## 📜 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## 🙏 Attribution

When using this package, please ensure you comply with The TVDB's attribution requirements. Display the following attribution to end users:

> "Metadata provided by TheTVDB. Please consider adding missing information or subscribing."

For more information about attribution requirements, visit [The TVDB API Information page](https://www.thetvdb.com/api-information).

## 👥 Credits

- [DenAnd Team](https://github.com/denand-team) - Package development and maintenance
- [The TVDB](https://www.thetvdb.com/) - API and data provider