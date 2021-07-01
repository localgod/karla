# Why would you want to use Karla

For most people who starts working with php and ImageMagick you either install the PECL extension Imagick or work directly with ImageMagick through shell_exec().

While Imagick has a much bigger feature set that Karla ever will, it is still a limited implementation of all the features available in ImageMagick's toolbox. Karla allows you to access all of ImageMagick like with the shell_exec() approche, and have focused on making some commen operations convinient.

Karla offers a subset of the functionalities that Imagick provides, but with two destinct differences which is why Karla was written:

You can chain your argument so your image operations are more query like.
You have direct access to ImageMagick's console tools in a convenient way, should you need the full power of ImageMagick.

Karla is tested complient with the 7.3, 7.4 and 8.0 version of php, and have a decent suite of unittests.

## Requirements

Php version 7.3< build with the following extension: pcre, SPL (default build-in in most distributions)
Your php setup need to allow shell_exec()
ImageMagick

## Installation

Copy the Karla folder to your site, and add the following lines to you script:

```php
spl_autoload_register(
function ($name)
{
    if ('Karla\\' == substr($name, 0, 6)) {
        $path = __DIR__ . '/../src' . DIRECTORY_SEPARATOR
        . str_replace('\\', DIRECTORY_SEPARATOR, $name)
        . '.php';
        require_once $path;
    }
});
```

Or you can just use [Composer](http://getcomposer.org/).

## Examples

The following sections illustrates common operations performed with Imagick, Karla and in the console.
### Change format to png.

Imagick code
```php
$image = new Imagick();
$image->readImage('demo.jpg');
$image->setImageFormat('png');
$image->writeImage('demo.png', true);    
```
Karla code
```php
Karla::perform()->convert()->in('demo.jpg')->out('demo.png')->execute();
```
Imagemagick in console
```bash
convert "demo.jpg" "demo.png"
```   