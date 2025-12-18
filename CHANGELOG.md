# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.1.0]

### Added
- ImageMagick 7 support with automatic version detection and cross-platform compatibility (Windows, macOS, Linux)
- Comprehensive test coverage for `Color`, `Query`, `Support`, and `Cache\File` classes (63 new tests)
- Automatic ImageMagick path detection in test bootstrap
- `TestHelper` utility class for platform-aware test assertions

### Fixed
- `Color::validColorName()` regex anchoring bug preventing proper color validation
- `Query::prepareOptions()` not removing empty strings from options array
- `MetaData::parseVerbose()` missing return statement causing TypeError
- `Cache::setCache()` type inconsistency (parameter changed from `string` to `array<string>`)
- PHPUnit 10 compatibility and cross-platform test issues

### Changed
- Upgraded PHPUnit from 9.6.x to stable 10.5.60
- Modernized PHPDoc annotations for PHP 8.4 compatibility
- Updated test expectations to match new test data

## [1.0.2] - 2024-07-15

### Changed
- Updated to support PHP 8.4

## [1.0.1] - 2021-05-17

### Added
- PSR-12 coding standard compliance
- Strict type checking implementation
- Cross-platform build support (Ubuntu, macOS, Windows)

### Changed
- Refactored to support latest PHPUnit
- Moved unit tests to new location
- Updated to PHP 8 support

### Removed
- Dropped support for PHP versions prior to 8.0

## [1.0.0] - 2016-05-15

### Added
- First stable release after 4 years of development
- Complete ImageMagick wrapper functionality

[Unreleased]: https://github.com/localgod/karla/compare/v1.0.2...HEAD
[1.0.2]: https://github.com/localgod/karla/releases/tag/v1.0.2
[1.0.1]: https://github.com/localgod/karla/releases/tag/v1.0.1
[1.0.0]: https://github.com/localgod/karla/releases/tag/v1.0.0
