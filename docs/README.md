---
lang: en-US
title: Main
description: How to install and use Karla
---

# Why would you want to use Karla

For most people who starts working with [php](https://www.php.net/) and [ImageMagick](https://imagemagick.org/index.php) you either install the [PECL extension Imagick](https://pecl.php.net/package/imagick) or work directly with ImageMagick through [shell_exec()](https://www.php.net/manual/en/function.shell-exec).

While Imagick has a much bigger feature set than Karla ever will, it is still a limited implementation of all the features available in ImageMagick's toolbox. Karla allows you to access all of ImageMagick like with the shell_exec() approach, and have focused on making some commen operations convinient.

Karla offers a subset of the functionalities that Imagick provides, but with two destinct differences which is why Karla was written:

- You can chain your argument so your image operations are more query like.
- You have direct access to ImageMagick's console tools in a convenient way, should you need the full power of ImageMagick.

Karla is tested complient with the 7.3, 7.4 and 8.0 version of php, and have a decent suite of unittests.

## Requirements

- Php version 8.0< build with the following extension: pcre, SPL (default build-in in most distributions)
- Your php setup need to allow shell_exec()
- ImageMagick

### Legacy version

- For release 1.0.0 Php version 5.3.3 or newer build with the following extension: pcre, SPL (default build-in in most distributions)
- Your php setup needs to allow shell_exec()
- ImageMagick


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

![Demo image](/images/demo.jpg) ![Demo image](/images/demo.png)

#### Imagick code
```php
$image = new Imagick();
$image->readImage('demo.jpg');
$image->setImageFormat('png');
$image->writeImage('demo.png', true);    
```
#### Karla code
```php
Karla::perform()->convert()->in('demo.jpg')->out('demo.png')->execute();
```
#### Imagemagick in console
```bash
convert "demo.jpg" "demo.png"
```
### Resize image

![Demo image](/images/demo.jpg) ![Demo image](/images/demo-100x100.jpg)

#### Imagick code
```php
$image = new Imagick();
$image->readImage('demo.jpg');
$image->resizeImage(200, 200, Imagick::FILTER_LANCZOS, 0.9, true);
$image->writeImage('demo-100x100.jpg', true);    
```
#### Karla code
```php
Karla::perform()->convert()->resize(100, 100)->in('demo.jpg')->out('demo-100x100.jpg')->execute();    
```
#### Imagemagick in console
```bash
convert -resize 100x100\> "demo.jpg" "demo-100x100.jpg"
```

### Change quality

![Demo image](/images/demo.jpg) ![Demo image](/images/demo-low.jpg)

#### Imagick code

```php
$image = new Imagick();
$image->readImage('demo.jpg');
$image->setImageCompression(imagick::COMPRESSION_JPEG);
$image->setImageCompressionQuality(10);
$image->writeImage('demo-low.jpg');     
```
#### Karla code
```php
Karla::perform()->convert()->quality(10)->in('demo.jpg')->out('demo-low.jpg')->execute();    
```
#### Imagemagick in console
```bash
convert -quality 10 "demo.jpg" "demo-low.jpg"
```

### Crop image

![Demo image](/images/demo.jpg) ![Demo image](/images/demo-crop.jpg)

#### Imagick code
```php
$image = new Imagick();
$image->readImage('demo.jpg');
$image->cropImage(100, 100, 50, 50);
$image->writeImage('demo-crop.jpg');     
```
#### Karla code
```php
Karla::perform()->convert()->crop(100, 100, 50, 50)->in('demo.jpg')->out('demo-crop.jpg')->execute();    
```
#### Imagemagick in console
```bash
convert -crop 100x100+50+50 +repage "demo.jpg" "demo-crop.jpg"     
```

### Mirror image vertical

![Demo image](/images/demo.jpg) ![Demo image](/images/demo-flip.jpg)

#### Imagick code
```php
$image = new Imagick();
$image->readImage('demo.jpg');
$image->flipImage();
$image->writeImage('demo-flip.jpg');     
```
#### Karla code
```php
Karla::perform()->convert()->flip()->in('demo.jpg')->out('demo-flip.jpg')->execute();    
```
#### Imagemagick in console
```bash
convert -flip "demo.jpg" "demo-flip.jpg"
```

### Mirror image horizontal

![Demo image](/images/demo.jpg) ![Demo image](/images/demo-flop.jpg)

#### Imagick code
```php
$image = new Imagick();
$image->readImage('demo.jpg');
$image->flopImage();
$image->writeImage('demo-flop.jpg');     
```
#### Karla code
```php
Karla::perform()->convert()->flop()->in('demo.jpg')->out('demo-flop.jpg')->execute();    
```
#### Imagemagick in console
```bash
convert -flop "demo.jpg" "demo-flop.jpg"  
```  

### Grayscale image

![Demo image](/images/demo.jpg) ![Demo image](/images/demo-grayscale.jpg)

#### Imagick code
```php
$image = new Imagick();
$image->readImage('demo.jpg');
$image->modulateImage(100,0,100);  
$image->writeImage('demo-grayscale.jpg');     
```
#### Karla code
```php
Karla::perform()->convert()->type('Grayscale')->in('demo.jpg')->out('demo-grayscale.jpg')->execute();    
```
#### Imagemagick in console
```bash
convert -type Grayscale "demo.jpg" "demo-grayscale.jpg"
```   

### Sepia tone image

![Demo image](/images/demo.jpg) ![Demo image](/images/demo-sepia.jpg)

#### Imagick code
```php
$image = new Imagick();
$image->readImage('demo.jpg');
$image->sepiaToneImage();  
$image->writeImage('demo-sepia.jpg');
```   

#### Karla code
```php
Karla::perform()->convert()->sepia(80)->in('demo.jpg')->out('demo-sepia.jpg')->execute();    
```
#### Imagemagick in console
```bash
convert "demo.jpg" -sepia-tone 80% "demo-sepia.jpg"
```

### Add polaroid effect to image

![Demo image](/images/demo.jpg) ![Demo image](/images/demo-polaroid.png)

#### Imagick code
```php
$image = new Imagick();
$image->readImage('demo.jpg');
$image->polaroidImage(new ImagickDraw(), 25);
$image->writeImage('demo-sepia.jpg');     
```
#### Karla code
```php
Karla::perform()->convert()->polaroid(-10)->borderColor('#ffffff')->background('#000000')->in('demo.jpg')->out('demo-polaroid.png')->execute();    
```
#### Imagemagick in console
```bash
convert -polaroid -10  -bordercolor "#ffffff"  -background "#000000" "demo.jpg" "demo-polaroid.png"
```

### Rotate image 45 degrees left

![Demo image](/images/demo.jpg) ![Demo image](/images/demo-rotate.png)

#### Imagick code
```php
$image = new Imagick();
$image->readImage('demo.jpg');
$image->rotateImage(new ImagickPixel('gray'), -45);
$image->writeImage('demo-rotate.jpg');     
```
#### Karla query code
```php
Karla::perform()->convert()->rotate(-45, 'gray')->in('demo.jpg')->out('demo-rotate.png')->execute();    
```
#### Imagemagick query
```bash
convert -rotate "-45"  -background "gray" "demo.jpg" "demo-rotate.png"
```

### Do 'magic' stuff

![Demo image](/images/demo.jpg) ![Demo image](/images/demo-magic.png)

#### Imagick code
```php
//Not possible (but you can achive a similar result) 
```
#### Karla query code
```php
Karla::perform()->convert()->raw('-vignette 5x65000 -gaussian-blur 20')->in('demo.jpg')->out('demo-magic.png')->execute();    
```
#### Imagemagick query
```bash
convert -vignette 5x65000 -gaussian-blur 20 "demo.jpg" "demo-magic.png"
```

## Test coverage

[Unit test coverage](/karla/coverage)