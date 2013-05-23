<?php

/**
 * Convert Test file
 *
 * PHP Version 5.1.2
 *
 * @category Test
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 * @since    2012-04-05
 */
/**
 * Convert Test class
 *
 * @category Test
 * @package Karla
 * @subpackage Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class ConvertTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test
     *
     * @test
     * @covers Convert::inputfile
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function invalidInputfile()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo2.jpg')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::inputfile
     * @expectedException RuntimeException
     *
     * @return void
     */
    public function inputfileWithoutOutputfile()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::outputfile
     * @expectedException RuntimeException
     *
     * @return void
     */
    public function outputfileWithoutInputfile()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->outputfile('test-1920x1200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::outputfile
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function invalidOutputfile()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->outputfile('/nowhere/test-1920x1200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::inputfile
     * @covers Convert::outputfile
     *
     * @return void
     */
    public function inputfileAndOutputfile()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->outputfile('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::background
     *
     * @return void
     */
    public function background()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->background('red')
            ->outputfile('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -background "red" "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::background
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function backgroundTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->background('red')
            ->background('blue')
            ->outputfile('test-1920x1200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::borderColor
     *
     * @return void
     */
    public function bordercolorWithColorName()
    {
        // You will not be able to see the border in the resulting image, as this test has no border argument.
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->borderColor('red')
            ->outputfile('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -bordercolor red "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::borderColor
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function bordercolorTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->borderColor('red')
            ->borderColor('red')
            ->outputfile('test-1920x1200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::borderColor
     *
     * @return void
     */
    public function bordercolorWithHexColor()
    {
        // You will not be able to see the border in the resulting image, as this test has no border argument.
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->borderColor('#666666')
            ->outputfile('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -bordercolor "#666666" "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::borderColor
     *
     * @return void
     */
    public function bordercolorWithRgbColor()
    {
        // You will not be able to see the border in the resulting image, as this test has no border argument.
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->borderColor('rgb(255,255,255)')
            ->outputfile('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -bordercolor "rgb(255,255,255)" "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::borderColor
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function bordercolorWithInvalidColor()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->borderColor('grenish')
            ->outputfile('test-1920x1200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::removeProfile
     *
     * @return void
     */
    public function removeProfile()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->removeProfile('iptc')
            ->outputfile('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert +profile iptc "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::resample
     *
     * @return void
     */
    public function resample()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resample(200, 200, 72, 72)
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -density 72x72  -resample \'200x200\' "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::resample
     *
     * @return void
     */
    public function resampleWithOnlyWidth()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resample(200)
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -resample \'200\' "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Composite::reset
     *
     * @return void
     */
    public function reset()
    {
        $command = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()->inputfile('tests/_data/demo.jpg');
        $this->assertTrue($command->isDirty());
        $command->reset();
        $this->assertFalse($command->isDirty());
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::size
     *
     * @return void
     */
    public function size()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->size(200, 200)
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -size 200x200 "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::size
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function sizeTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
        ->inputfile('tests/_data/demo.jpg')
        ->size(200, 200)
        ->size(200, 200)
        ->outputfile('test-200x200.png')
        ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::size
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function sizeNoArguments()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
        ->inputfile('tests/_data/demo.jpg')
        ->size()
        ->outputfile('test-200x200.png')
        ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::density
     *
     * @return void
     */
    public function density()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->density()
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert "tests/_data/demo.jpg" -density 72x72 "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::flatten
     *
     * @return void
     */
    public function flatten()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->flatten()
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -flatten "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::flatten
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function flattenTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->flatten()
            ->flatten()
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::strip
     *
     * @return void
     */
    public function strip()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->strip()
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -strip "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::strip
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function stripTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
        ->inputfile('tests/_data/demo.jpg')
        ->strip()
        ->strip()
        ->outputfile('test-200x200.png')
        ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::profile
     *
     * @return void
     */
    public function profile()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->profile('tests/_data/sRGB_Color_Space_Profile.icm')
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert "tests/_data/demo.jpg" -profile "tests/_data/sRGB_Color_Space_Profile.icm" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::profile
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function profileWithInvalidPath()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->profile('tests/_data/RGB_Color_Space_Profile.icm')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::changeProfile
     *
     * @return void
     */
    public function changeProfile()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->changeProfile('tests/_data/sRGB_Color_Space_Profile.icm', 'tests/_data/sRGB_Color_Space_Profile.icm')
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert "tests/_data/demo.jpg" -profile "tests/_data/sRGB_Color_Space_Profile.icm"   -profile "tests/_data/sRGB_Color_Space_Profile.icm" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::layers
     *
     * @return void
     */
    public function layers()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->layers('flatten')
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -layers flatten "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::layers
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function layersWithIvalidMethod()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->layers('christmas')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::resize
     *
     * @return void
     */
    public function resize()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resize(100, 100)
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -resize 100x100\> "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::crop
     *
     * @return crop
     */
    public function crop()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->crop(100, 100)
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -crop 100x100+0+0 +repage "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::quality
     *
     * @return void
     */
    public function quality()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->quality(80)
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -quality 80 "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::quality
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function qualityTwice()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->quality(80)
            ->quality(80)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::quality
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function qualityUnSupportedFormat()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->quality(80, 'pdf')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::quality
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function qualityNotANumber()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->quality('pdf')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::quality
     * @expectedException RangeException
     *
     * @return void
     */
    public function qualityNotAValidQuality()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->quality(102)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::colorspace
     *
     * @return void
     */
    public function colorspace()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->colorspace('rgb')
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert "tests/_data/demo.jpg" -colorspace rgb "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::colorspace
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function colorspaceTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->colorspace('rgb')
            ->colorspace('rgb')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::colorspace
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function colorspaceInvalid()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->colorspace('brg')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::gravity
     *
     * @return void
     */
    public function gravity()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->gravity('center')
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -gravity center "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::isDirty
     *
     * @return void
     */
    public function isDirty()
    {
        $this->assertTrue(! Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->isDirty());
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::__clone
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function __clone()
    {
        $object = clone Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::getCommand
     *
     * @return void
     */
    public function getCommand()
    {
        $command = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->outputfile('test-1920x1200.png')
            ->getCommand();
        $this->assertNotNull($command);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::execute
     *
     * @return void
     */
    public function execute()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::raw
     *
     * @return void
     */
    public function raw()
    {
        $this->assertInstanceOf('Convert', Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->raw(''));
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::validProgram
     *
     * @return void
     */
    public function validProgram()
    {
        $this->assertTrue(Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->validProgram('convert'));
        $this->assertFalse(Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->validProgram('git'));
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::flip
     *
     * @return void
     */
    public function flip()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->flip()
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -flip "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::flip
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function flipTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
        ->inputfile('tests/_data/demo.jpg')
        ->flip()
        ->flip()
        ->outputfile('test-200x200.png')
        ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::rotate
     *
     * @return void
     */
    public function rotate()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->rotate(- 45, 'gray')
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -rotate "-45"  -background "gray" "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::rotate
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function rotateTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->rotate(- 45, 'gray')
            ->rotate(- 45, 'gray')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::flop
     *
     * @return void
     */
    public function flop()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->flop()
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -flop "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::flop
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function flopTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->flop()
            ->flop()
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::type
     *
     * @return void
     */
    public function type()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->type('Grayscale')
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert "tests/_data/demo.jpg" -type Grayscale "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::type
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function typeTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
        ->inputfile('tests/_data/demo.jpg')
        ->type('Grayscale')
        ->type('Grayscale')
        ->outputfile('test-200x200.png')
        ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::type
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function typeUnsupported()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
        ->inputfile('tests/_data/demo.jpg')
        ->type('Christmas')
        ->outputfile('test-200x200.png')
        ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::sepia
     *
     * @return void
     */
    public function sepia()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->sepia()
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert "tests/_data/demo.jpg" -sepia-tone 80% "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::sepia
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function sepiaTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->sepia()
            ->sepia()
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::sepia
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function sepiaInvalidThreshold()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->sepia('bobby')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::sepia
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function sepiaInvalidThresholdNumber()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->sepia(120)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::polaroid
     *
     * @return void
     */
    public function polaroid()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->polaroid()
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:'.PATH_TO_IMAGEMAGICK.';convert -polaroid 0 "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::polaroid
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function polaroidTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->polaroid()
            ->polaroid()
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::polaroid
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function polaroidInvalidAngle()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->polaroid('four')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::polaroid
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function polaroidToBigdAngle()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->polaroid(400)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }
}
