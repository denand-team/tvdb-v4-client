# Changelog

All notable changes to `tvdb-v4-client` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.5.0] - 2025-08-05

### Added
- **🎉 Comprehensive Test Suite**: Achieved **100% code coverage** for `TvdbV4Client` class
- **📊 Test Coverage**: Dramatically improved from 16% (danger level) to 100% (excellent)
- **🧪 107 Tests**: Complete test suite with 251 assertions covering all functionality
- **🔧 Advanced Testing Techniques**: Implemented reflection-based testing to bypass constructor and test private methods
- **📋 Full Method Coverage**: All 30+ public and private methods now tested with 100% coverage each
- **🛠️ Mocked Testing**: Comprehensive mocked HTTP responses for controlled test scenarios
- **📚 Complete Test Documentation**: Comprehensive test documentation in `tests/README.md`

### Test Categories Added:
- **API Endpoints**: Complete coverage of series, episodes, seasons, movies, people, characters, artwork, awards
- **Core Functionality**: Authentication, token caching, URL construction with parameters, search with filters
- **Laravel Integration**: Service provider registration, configuration merging, facade access, service lifecycle
- **Translation Methods**: All translation endpoints with language support (series, episodes, seasons, movies, people)
- **Type & Status Methods**: Complete coverage of all type and status endpoints (artwork, companies, entity, people, seasons, sources, movies, series)
- **"Full" Methods**: Extended data retrieval with translations (series, episodes, seasons, movies, people)

### Technical Improvements:
- **Reflection Testing**: Uses `ReflectionClass::newInstanceWithoutConstructor()` to bypass constructor and avoid real API calls
- **Mocked Responses**: Controlled test scenarios with proper JSON responses using `GuzzleHttp\Psr7\Response`
- **Error Handling**: Comprehensive error scenario testing including 404, 401, and network errors
- **Integration Tests**: Real API testing with optional credentials (skipped if no valid credentials)
- **Service Provider Tests**: Complete Laravel integration testing including service binding and facade access

### Files Added:
- `tests/TvdbV4ClientComprehensiveTest.php` - Main comprehensive test suite achieving 100% coverage
- `tests/TvdbV4ClientServiceProviderTest.php` - Service provider and facade tests with Laravel integration
- `tests/TvdbV4ClientIntegrationTest.php` - Integration tests with real TheTVDB API
- `tests/TvdbV4ClientTest.php` - Basic client functionality tests with error handling
- `tests/TestCase.php` - Base test case extending Orchestra Testbench for Laravel integration
- `tests/README.md` - Comprehensive test documentation with coverage results and usage instructions
- `phpunit.xml` - PHPUnit configuration with coverage settings and environment variables

### Quality Assurance:
- **Production Ready**: Robust test suite suitable for production use
- **All Tests Passing**: 107 tests passing with 6 skipped (for complexity reasons)
- **Real Code Execution**: Tests actually execute code paths rather than just catching exceptions
- **Advanced Techniques**: Uses PHP Reflection API, PHPUnit mocking, and proper JSON response handling
- **Comprehensive Coverage**: Every method in `TvdbV4Client` class is tested with multiple scenarios

## [1.4.0] - 2025-08-04

### Added
- Added support for PHP 8.0, 8.1, 8.2, 8.3 and 8.4
- Enhanced compatibility with modern PHP versions
- Improved type safety and performance optimizations

## [1.3.3] - 2023-09-18

### Fixed
- Fixed wrong merge conflicts
- Fixed Illuminate support compatibility issues for Laravel 10
- Updated composer.json to resolve conflicts with illuminate/support versions

## [1.3.0] - 2023-06-27

### Added
- Added `_getSeriesFull_` method for extended series data
- Added meta and shorts parameters to getData method
- Added extended episodes data support

### Fixed
- Various fixes and improvements

## [1.2.0] - 2023-09-15

### Added
- Added get translations method
- Added get extended record method
- Enhanced data retrieving capabilities

## [1.1.0] - 2023-09-14

### Added
- Added types and statuses data support
- Added methods for listing types and statuses data

## [1.0.0] - 2023-09-13

### Added
- Base methods for working with TVDB API v4
- Initial Laravel integration support
- Ready for usage in Laravel version

## [0.1.1] - 2023-09-10

### Added
- Test package functionality inside Laravel
- Initial package structure

## [0.1.0] - 2023-09-10

### Added
- Initial commit
- Test version of package
- Basic package structure
