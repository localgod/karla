# Karla

[![Main](https://github.com/localgod/karla/actions/workflows/php.yml/badge.svg?branch=master)](https://github.com/localgod/karla/actions/workflows/php.yml)
[![Latest Stable Version](https://poser.pugx.org/localgod/karla/v/stable)](https://packagist.org/packages/localgod/karla)
[![Total Downloads](https://poser.pugx.org/localgod/karla/downloads)](https://packagist.org/packages/localgod/karla)
[![Latest Unstable Version](https://poser.pugx.org/localgod/karla/v/unstable)](https://packagist.org/packages/localgod/karla)
[![License](https://poser.pugx.org/localgod/karla/license)](https://packagist.org/packages/localgod/karla)
[![Project Stats](https://www.openhub.net/p/Karla/widgets/project_thin_badge.gif)](https://www.openhub.net/p/Karla)
[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Flocalgod%2Fkarla.svg?type=shield&issueType=license)](https://app.fossa.com/projects/git%2Bgithub.com%2Flocalgod%2Fkarla?ref=badge_shield&issueType=license)

Karla is an ImageMagick wrapper written in PHP with support for method chaining.

✨ **Now with ImageMagick 7 support!** Automatically detects and works with both ImageMagick 6 and 7.

## Requirements

- PHP 8.0+ (8.2+ recommended)
- ImageMagick 6.x or 7.x
- PHP extensions: pcre, SPL (default in most distributions)
- [shell_exec()](http://php.net/manual/en/function.shell-exec.php) must be enabled

## Installation

```bash
composer require localgod/karla
```

## Getting Started

```php
use Karla\Karla;

$karla = new Karla('/path/to/imagemagick/');
$karla->convert()
    ->input('photo.jpg')
    ->resize(800, 600)
    ->output('photo-resized.jpg')
    ->execute();
```

See the [documentation](http://localgod.github.io/karla/) for more examples and usage details.

## Contributing

Contributions are welcome! See [CONTRIBUTE.md](CONTRIBUTE.md) for development setup, testing guidelines, and how to submit pull requests.

## License

[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Flocalgod%2Fkarla.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Flocalgod%2Fkarla?ref=badge_large)
