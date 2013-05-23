<?php
use Karla\Karla;
/**
 * Convert Test file
 *
 * PHP Version 5.3
 *
 * @category Utility
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
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 */
class ConvertTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::inputfile
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
     * @covers Karla\Program\Convert::inputfile
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
     * @covers Karla\Program\Convert::outputfile
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
     * @covers Karla\Program\Convert::outputfile
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
     * @covers Karla\Program\Convert::inputfile
     * @covers Karla\Program\Convert::outputfile
     *
     * @return void
     */
    public function inputfileAndOutputfile()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->outputfile('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::background
     * @covers Karla\Program\ImageMagick::isOptionSet
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -background "red" "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::background
     * @covers Karla\Program\ImageMagick::isOptionSet
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
     * @covers Karla\Program\Convert::borderColor
     * @covers Karla\Program\Convert::validHexColor
     * @covers Karla\Program\Convert::validColorName
     * @covers Karla\Program\Convert::validRgbColor
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -bordercolor red "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::borderColor
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
     * @covers Karla\Program\Convert::borderColor
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -bordercolor "#666666" "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::borderColor
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -bordercolor "rgb(255,255,255)" "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::borderColor
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
     * @covers Karla\Program\Convert::removeProfile
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert +profile iptc "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resample
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -density 72x72  -resample \'200x200\' "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resample
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function resampleTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resample(200, 200, 72, 72)
            ->resample(200, 200, 72, 72)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resample
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function resampleWithResize()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resize(200, 200)
            ->resample(200, 200, 72, 72)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resize
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function resizeWithResample()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resample(200, 200, 72, 72)
            ->resize(200, 200)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resize
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function resizeTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resize(200, 200)
            ->resize(200, 200)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resize
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function resizeWithNoArguments()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resize()
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resize
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function resizeWithNonNumericWidth()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resize('christmas')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resize
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function resizeWithNonNumericHeight()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resize(200, 'christmas')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resize
     *
     * @return void
     */
    public function resizeWithoutMaintainingAspectRatio()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resize(200, 200, false)
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -resize 200x200!\> "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resample
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function resampleWithDensity()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->density()
            ->resample(200, 200, 72, 72)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resample
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function resampleWidthNotNumeric()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resample("christmas", 200, 72, 72)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resample
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function resampleHeightNotNumeric()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resample(200, "christmas", 72, 72)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resample
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function resampleOriginalHeightNotNumeric()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resample(200, 200, 72, "christmas")
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resample
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function resampleOriginalWidthNotNumeric()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resample(200, 200, "christmas", 72)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resample
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -resample \'200\' "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @covers Karla\Program\Convert::resample
     *
     * @return void
     * @todo not working
     */
    public function resampleWithOnlyOriginalWidth()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resample(200, 200, 72)
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -density 72x72 -resample \'200x200\' "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::reset
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
     * @covers Karla\Program\Convert::size
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -size 200x200 "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::size
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
     * @covers Karla\Program\Convert::size
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
     * @covers Karla\Program\Convert::density
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" -density 72x72 "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::density
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function densityWithResample()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->resample(200)
            ->density()
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::flatten
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -flatten "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::flatten
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
     * @covers Karla\Program\Convert::strip
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -strip "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::strip
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
     * @covers Karla\Program\Convert::profile
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" -profile "tests/_data/sRGB_Color_Space_Profile.icm" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::profile
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
     * @covers Karla\Program\Convert::changeProfile
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" -profile "tests/_data/sRGB_Color_Space_Profile.icm"   -profile "tests/_data/sRGB_Color_Space_Profile.icm" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::changeProfile
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function changeProfileTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->changeProfile('tests/_data/sRGB_Color_Space_Profile.icm', 'tests/_data/sRGB_Color_Space_Profile.icm')
            ->changeProfile('tests/_data/sRGB_Color_Space_Profile.icm', 'tests/_data/sRGB_Color_Space_Profile.icm')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::changeProfile
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function changeProfileInvalidNewProfile()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->changeProfile('tests/_data/sRGB_Color_Space_Profile.icm', 'tests/_data/RGB_Color_Space_Profile.icm')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::changeProfile
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function changeProfileInvalidOldProfile()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->changeProfile('tests/_data/RGB_Color_Space_Profile.icm', 'tests/_data/sRGB_Color_Space_Profile.icm')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::layers
     * @covers Karla\Program\ImageMagick::supportedLayerMethod
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -layers flatten "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::layers
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
     * @covers Karla\Program\Convert::resize
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -resize 100x100\> "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::crop
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -crop 100x100+0+0 +repage "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::crop
     *
     * @return crop
     */
    public function cropWidthOffset()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
        ->inputfile('tests/_data/demo.jpg')
        ->crop(100, 100, 10, 10)
        ->outputfile('test-200x200.png')
        ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -crop 100x100+10+10 +repage "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::crop
     *
     * @return crop
     */
    public function cropWidthNegativeOffset()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
        ->inputfile('tests/_data/demo.jpg')
        ->crop(100, 100, -10, -10)
        ->outputfile('test-200x200.png')
        ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -crop 100x100-10-10 +repage "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::crop
     * @expectedException BadMethodCallException
     *
     * @return crop
     */
    public function cropTwice()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->crop(100, 100)
            ->crop(100, 100)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }
    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::crop
     * @expectedException InvalidArgumentException
     *
     * @return crop
     */
    public function cropWithInvalidWidth()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->crop('chrismas', 100)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }
    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::crop
     * @expectedException InvalidArgumentException
     *
     * @return crop
     */
    public function cropWithInvalidHeight()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->crop(100, 'chrismas')
            ->outputfile('test-200x200.png')
            ->getCommand();
    }
    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::crop
     * @expectedException InvalidArgumentException
     *
     * @return crop
     */
    public function cropWithInvalidXOffset()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
        ->inputfile('tests/_data/demo.jpg')
        ->crop(100, 100, 'chrismas')
        ->outputfile('test-200x200.png')
        ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::crop
     * @expectedException InvalidArgumentException
     *
     * @return crop
     */
    public function cropWithInvalidYOffset()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
        ->inputfile('tests/_data/demo.jpg')
        ->crop(100, 100, 0, 'chrismas')
        ->outputfile('test-200x200.png')
        ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::quality
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -quality 80 "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::quality
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
     * @covers Karla\Program\Convert::quality
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
     * @covers Karla\Program\Convert::quality
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
     * @covers Karla\Program\Convert::quality
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
     * @covers Karla\Program\Convert::colorspace
     * @covers Karla\Program\ImageMagick::supportedColorSpace
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" -colorspace rgb "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::colorspace
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
     * @covers Karla\Program\Convert::colorspace
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
     * @covers Karla\Program\Convert::gravity
     * @covers Karla\Program\ImageMagick::supportedGravity
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -gravity center "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::isDirty
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
     * @covers Karla\Program\Convert::__clone
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
     * @covers Karla\Program\Convert::getCommand
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
     * @covers Karla\Program\Convert::execute
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
     * @covers Karla\Program\Convert::raw
     * @covers Karla\Program\ImageMagick::raw
     *
     * @return void
     */
    public function raw()
    {
        $this->assertInstanceOf('Karla\Program\Convert', Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->raw(''));
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::validProgram
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
     * @covers Karla\Program\Convert::flip
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -flip "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::flip
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
     * @covers Karla\Program\Convert::rotate
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -rotate "-45"  -background "gray" "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::rotate
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
     * @covers Karla\Program\Convert::flop
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -flop "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::flop
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
     * @covers Karla\Program\Convert::type
     * @covers Karla\Program\ImageMagick::supportedImageTypes
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" -type Grayscale "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::type
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
     * @covers Karla\Program\Convert::type
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
     * @covers Karla\Program\Convert::sepia
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" -sepia-tone 80% "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::sepia
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
     * @covers Karla\Program\Convert::sepia
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
     * @covers Karla\Program\Convert::sepia
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
     * @covers Karla\Program\Convert::polaroid
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -polaroid 0 "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::polaroid
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
     * @covers Karla\Program\Convert::polaroid
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
     * @covers Karla\Program\Convert::polaroid
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function polaroidToBigAngle()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->polaroid(400)
            ->outputfile('test-200x200.png')
            ->getCommand();
    }
}
