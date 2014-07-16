<?php
/**
 * Karla Imagemagick wrapper library demo file
 *
 * PHP Version 5.3
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
spl_autoload_register(function ($name)
{
    if ('Karla\\' == substr($name, 0, 6)) {
        $path = __DIR__ . '/../src' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $name) . '.php';
        require_once $path;
    }
});

/**
 * Demo class for Karla
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/karla Karla
 */
class Demo
{

    /**
     * Clean path
     *
     * @param string $path
     *            Path to Clean
     *
     * @return string
     */
    private function _cleanPath($path)
    {
        return str_replace(dirname(__FILE__), '', str_replace('export PATH=$PATH:/opt/local/bin/;', '', $path));
    }

    /**
     * Generate examples
     *
     * @return void
     */
    public function examples()
    {
        $examples = array();
        $examples[] = $this->_example1();
        $examples[] = $this->_example2();
        $examples[] = $this->_example3();
        $examples[] = $this->_example4();
        $examples[] = $this->_example5();
        $examples[] = $this->_example6();
        $examples[] = $this->_example7();
        $examples[] = $this->_example8();
        $examples[] = $this->_example9();
        $examples[] = $this->_example10();
        $examples[] = $this->_example11();
        return $examples;
    }

    /**
     * Example 1
     *
     * @return array
     */
    private function _example1()
    {
        $basepath = '' . dirname(__FILE__) . DIRECTORY_SEPARATOR;
        Karla::perform()->convert()
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo.png')
            ->execute();
        $cleanCommand = $this->_cleanPath(Karla::perform()->convert()
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo.png')
            ->getCommand());
        return array(
            'name' => 'Change format to png.',
            'original' => 'demo.jpg',
            'result' => 'demo.png',
            'imagick' => '$image = new Imagick();
    $image->readImage(\'demo.jpg\');
    $image->setImageFormat(\'png\');
    $image->writeImage(\'demo-100x100.jpg\', true);',
            'code' => 'Karla::perform()->convert()->in(\'demo.jpg\')->out(\'demo.png\')->execute();',
            'console' => $cleanCommand
        );
    }

    /**
     * Example 2
     *
     * @return array
     */
    private function _example2()
    {
        $basepath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        Karla::perform()->convert()
            ->resize(100, 100)
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-100x100.jpg')
            ->execute();
        $cleanCommand = $this->_cleanPath(Karla::perform()->convert()
            ->resize(100, 100)
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-100x100.jpg')
            ->getCommand());
        return array(
            'name' => 'Resize image',
            'original' => 'demo.jpg',
            'result' => 'demo-100x100.jpg',
            'imagick' => '$image = new Imagick();
    $image->readImage(\'demo.jpg\');
    $image->resizeImage(200, 200, Imagick::FILTER_LANCZOS, 0.9, true);
    $image->writeImage(\'demo-100x100.jpg\', true);',
            'code' => 'Karla::perform()->convert()->resize(100, 100)->in(\'demo.jpg\')->out(\'demo-100x100.jpg\')->execute();',
            'console' => $cleanCommand
        );
    }

    /**
     * Example 3
     *
     * @return array
     */
    private function _example3()
    {
        $basepath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        Karla::perform()->convert()
            ->quality(10)
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-low.jpg')
            ->execute();
        $cleanCommand = $this->_cleanPath(Karla::perform()->convert()
            ->quality(10)
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-low.jpg')
            ->getCommand());
        return array(
            'name' => 'Change quality',
            'original' => 'demo.jpg',
            'result' => 'demo-low.jpg',
            'imagick' => '$image = new Imagick();
    $image->readImage(\'demo.jpg\');
    $image->setImageCompression(imagick::COMPRESSION_JPEG);
    $image->setImageCompressionQuality(10);
    $image->writeImage(\'demo-low.jpg\'); ',
            'code' => 'Karla::perform()->convert()->quality(10)->in(\'demo.jpg\')->out(\'demo-low.jpg\')->execute();',
            'console' => $cleanCommand
        );
    }

    /**
     * Example 4
     *
     * @return array
     */
    private function _example4()
    {
        $basepath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        Karla::perform()->convert()
            ->crop(100, 100, 50, 50)
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-crop.jpg')
            ->execute();
        $cleanCommand = $this->_cleanPath(Karla::perform()->convert()
            ->crop(100, 100, 50, 50)
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-crop.jpg')
            ->getCommand());
        return array(
            'name' => 'Crop image',
            'original' => 'demo.jpg',
            'result' => 'demo-crop.jpg',
            'imagick' => '$image = new Imagick();
    $image->readImage(\'demo.jpg\');
    $image->cropImage(100, 100, 50, 50);
    $image->writeImage(\'demo-crop.jpg\'); ',
            'code' => 'Karla::perform()->convert()->crop(100, 100, 50, 50)->in(\'demo.jpg\')->out(\'demo-crop.jpg\')->execute();',
            'console' => $cleanCommand
        );
    }

    /**
     * Example 5
     *
     * @return array
     */
    private function _example5()
    {
        $basepath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        Karla::perform()->convert()
            ->flip()
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-flip.jpg')
            ->execute();
        $cleanCommand = $this->_cleanPath(Karla::perform()->convert()
            ->flip()
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-flip.jpg')
            ->getCommand());
        return array(
            'name' => 'Mirror image vertical',
            'original' => 'demo.jpg',
            'result' => 'demo-flip.jpg',
            'imagick' => '$image = new Imagick();
    $image->readImage(\'demo.jpg\');
    $image->flipImage();
    $image->writeImage(\'demo-flip.jpg\'); ',
            'code' => 'Karla::perform()->convert()->flip()->in(\'demo.jpg\')->out(\'demo-flip.jpg\')->execute();',
            'console' => $cleanCommand
        );
    }

    /**
     * Example 6
     *
     * @return array
     */
    private function _example6()
    {
        $basepath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        Karla::perform()->convert()
            ->flop()
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-flop.jpg')
            ->execute();
        $cleanCommand = $this->_cleanPath(Karla::perform()->convert()
            ->flop()
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-flop.jpg')
            ->getCommand());
        return array(
            'name' => 'Mirror image horizontal',
            'original' => 'demo.jpg',
            'result' => 'demo-flop.jpg',
            'imagick' => '$image = new Imagick();
    $image->readImage(\'demo.jpg\');
    $image->flopImage();
    $image->writeImage(\'demo-flop.jpg\'); ',
            'code' => 'Karla::perform()->convert()->flop()->in(\'demo.jpg\')->out(\'demo-flop.jpg\')->execute();',
            'console' => $cleanCommand
        );
    }

    /**
     * Example 7
     *
     * @return array
     */
    private function _example7()
    {
        $basepath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        Karla::perform()->convert()
            ->type('Grayscale')
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-grayscale.jpg')
            ->execute();
        $cleanCommand = $this->_cleanPath(Karla::perform()->convert()
            ->type('Grayscale')
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-grayscale.jpg')
            ->getCommand());
        return array(
            'name' => 'Grayscale image',
            'original' => 'demo.jpg',
            'result' => 'demo-grayscale.jpg',
            'imagick' => '$image = new Imagick();
    $image->readImage(\'demo.jpg\');
    $image->modulateImage(100,0,100);
    $image->writeImage(\'demo-grayscale.jpg\'); ',
            'code' => '$Karla::perform()->convert()->type(\'Grayscale\')->in(\'demo.jpg\')->out(\'demo-grayscale.jpg\')->execute();',
            'console' => $cleanCommand
        );
    }

    /**
     * Example 8
     *
     * @return array
     */
    private function _example8()
    {
        $basepath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        Karla::perform()->convert()
            ->sepia(80)
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-sepia.jpg')
            ->execute();
        $cleanCommand = $this->_cleanPath(Karla::perform()->convert()
            ->sepia(80)
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-sepia.jpg')
            ->getCommand());
        return array(
            'name' => 'Sepia tone image',
            'original' => 'demo.jpg',
            'result' => 'demo-sepia.jpg',
            'imagick' => '$image = new Imagick();
    $image->readImage(\'demo.jpg\');
    $image->sepiaToneImage();
    $image->writeImage(\'demo-sepia.jpg\'); ',
            'code' => 'Karla::perform()->convert()->sepia(80)->in(\'demo.jpg\')->out(\'demo-sepia.jpg\')->execute();',
            'console' => $cleanCommand
        );
    }

    /**
     * Example 9
     *
     * @return array
     */
    private function _example9()
    {
        $basepath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        Karla::perform()->convert()
            ->polaroid(- 10)
            ->borderColor('#ffffff')
            ->background('#000000')
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-polaroid.png')
            ->execute();
        $cleanCommand = $this->_cleanPath(Karla::perform()->convert()
            ->polaroid(- 10)
            ->borderColor('#ffffff')
            ->background('#000000')
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-polaroid.png')
            ->getCommand());
        return array(
            'name' => 'Add polaroid effect to image',
            'original' => 'demo.jpg',
            'result' => 'demo-polaroid.png',
            'imagick' => '$image = new Imagick();
    $image->readImage(\'demo.jpg\');
    $image->polaroid();
    $image->writeImage(\'demo-polaroid.jpg\'); ',
            'code' => 'Karla::perform()->convert()->polaroid(-10)->borderColor(\'#ffffff\')->background(\'#000000\')->in(\'demo.jpg\')->out(\'demo-polaroid.png\')->execute();',
            'console' => $cleanCommand
        );
    }

    /**
     * Example 10
     *
     * @return array
     */
    private function _example10()
    {
        $basepath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        Karla::perform()->convert()
            ->rotate(- 45, 'gray')
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-rotate.png')
            ->execute();
        $cleanCommand = $this->_cleanPath(Karla::perform()->convert()
            ->rotate(- 45, 'gray')
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-rotate.png')
            ->getCommand());
        return array(
            'name' => 'Rotate image 45 degrees left',
            'original' => 'demo.jpg',
            'result' => 'demo-rotate.png',
            'imagick' => '$image = new Imagick();
	$image->readImage(\'demo.jpg\');
	$image->rotateImage(new ImagickPixel(\'gray\'), -45);
	$image->writeImage(\'demo-rotate.jpg\'); ',
            'code' => 'Karla::perform()->convert()->rotate(-45, \'gray\')->in(\'demo.jpg\')->out(\'demo-rotate.png\')->execute();',
            'console' => $cleanCommand
        );
    }

    /**
     * Example 11
     *
     * @return array
     */
    private function _example11()
    {
        $basepath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        Karla::perform()->convert()
            ->raw('-vignette 5x65000 -gaussian-blur 20')
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-magic.png')
            ->execute();
        $cleanCommand = $this->_cleanPath(Karla::perform()->convert()
            ->raw('-vignette 5x65000 -gaussian-blur 20')
            ->in($basepath . 'demo.jpg')
            ->out($basepath . 'demo-magic.png')
            ->getCommand());
        return array(
            'name' => 'Do \'magic\' stuff',
            'original' => 'demo.jpg',
            'result' => 'demo-magic.png',
            'imagick' => '//Not possible',
            'code' => 'Karla::perform()->convert()->raw(\'-vignette 5x65000 -gaussian-blur 20\')->in(\'demo.jpg\')->out(\'demo-magic.png\')->execute();',
            'console' => $cleanCommand
        );
    }
}
