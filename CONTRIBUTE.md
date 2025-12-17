# Contributing to Karla

Karla is easy to extend and contributions are highly appreciated.

Before you make a pull request make sure all tests still run and, if you have added functionality, that appropriate tests have been added.

## Prerequisites

- PHP 8.0 or newer (8.2+ recommended)
- Composer
- ImageMagick 6.x or 7.x
- Git

## Quick Start

1. **Clone the repository:**
   ```bash
   git clone https://github.com/localgod/karla.git
   cd karla
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Run tests:**
   ```bash
   composer run unit
   ```

## ImageMagick Version Support

Karla automatically detects and supports both ImageMagick 6 and 7:

- **ImageMagick 6:** Uses traditional commands (`convert`, `identify`, `composite`)
- **ImageMagick 7:** Uses unified `magick` command with subcommands

No code changes needed - it just works! ✨

### Verifying Your Installation

Check which version you have:

```bash
# ImageMagick 7
magick -version

# ImageMagick 6
convert -version
```

## Running Tests

Karla is tested with PHP 8.2, 8.3, and 8.4 on Linux, macOS, and Windows.

### Unit Tests

```bash
# Run all tests
composer run unit

# Run with coverage
./bin/phpunit --coverage-html coverage --configuration ./tests/unit/phpunit.xml

# Run specific test
./bin/phpunit --filter BackgroundTest --configuration ./tests/unit/phpunit.xml
```

Once no test fails, you can check code coverage here: ./coverage/index.html

### Code Style

Karla is [PSR-12](https://www.php-fig.org/psr/psr-12/) compliant.

```bash
# Check code style
composer run cs

# Fix code style automatically
composer run cbf
```

Please keep pull requests compliant.

### Clean Up

```bash
# Remove test artifacts
composer run clean
```

## Project Structure

```
karla/
├── src/
│   └── Karla/          # Main source code
│       ├── Action/     # ImageMagick actions (resize, crop, etc.)
│       ├── Cache/      # Caching implementations
│       └── Program/    # ImageMagick program wrappers
├── tests/
│   └── unit/           # PHPUnit tests
│       ├── TestHelper.php  # Cross-platform test utilities
│       └── bootstrap.php   # Test bootstrap with auto-detection
├── demo/               # Usage examples
└── docs/               # Documentation
```

## Adding New Features

1. **Write tests first** - Use TestHelper for cross-platform compatibility
2. **Follow PSR-12** - Run `composer run cs` to check
3. **Update documentation** - Keep README and docs in sync
4. **Test on multiple platforms** - CI runs on Linux, macOS, and Windows

## Cross-Platform Development

### TestHelper Utilities

When writing tests, use `TestHelper` for platform-aware assertions:

```php
use TestHelper;

// In setUp() method
if (!TestHelper::isImageMagickAvailable(PATH_TO_IMAGEMAGICK)) {
    $this->markTestSkipped('ImageMagick not available');
}

// For command assertions
$expected = TestHelper::buildExpectedCommand(
    PATH_TO_IMAGEMAGICK,
    'convert',
    '-resize 100x100 input.jpg output.png'
);
```

### Path Handling

- Use forward slashes `/` even on Windows
- The `Karla` class handles platform-specific path conversion
- Bootstrap auto-detects ImageMagick on Windows in common locations

## Common Issues

### Tests Failing with "ImageMagick not available"

1. Verify ImageMagick is installed: `magick -version` or `convert -version`
2. Check ImageMagick is in a standard location or update `bootstrap.php` detection paths
3. Ensure the path includes a trailing slash

### Windows: "convert is not recognized"

Windows has a built-in `convert.exe` for disk operations. Solutions:
1. Use ImageMagick 7 (uses `magick` instead)
2. Ensure ImageMagick path comes before `C:\Windows\System32` in PATH
3. Update the `$possiblePaths` array in `tests/unit/bootstrap.php` with your custom path

### PSR-4 Autoloading Issues

After updating from PSR-0 to PSR-4:
```bash
composer dump-autoload
```

## Pull Request Checklist

Before submitting a pull request:

1. ✅ All tests pass: `composer run unit`
2. ✅ Code style is clean: `composer run cs`
3. ✅ New features have tests
4. ✅ Documentation is updated
5. ✅ Commits are clear and descriptive

## Continuous Integration

CI automatically runs on:
- **Platforms:** Linux, macOS, Windows
- **PHP versions:** 8.2, 8.3, 8.4
- **ImageMagick:** Automatically installed (latest stable)

The workflow:
1. Installs ImageMagick
2. Sets up PHP with required extensions
3. Runs code style checks
4. Runs unit tests
5. Generates coverage reports

## Resources

- [ImageMagick Documentation](https://imagemagick.org/)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)
- [Composer Documentation](https://getcomposer.org/doc/)

## Getting Help

- 📖 [Documentation](http://localgod.github.io/karla/)
- 🐛 [Issue Tracker](https://github.com/localgod/karla/issues)
- 💬 [Discussions](https://github.com/localgod/karla/discussions)

Thank you for contributing! 🚀
