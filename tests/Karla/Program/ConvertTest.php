<?php
use Karla\Karla;

/**
 * Convert Test file
 *
 * PHP Version 5.3
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 * @since 2012-04-05
 */
/**
 * Convert Test class
 *
 * @category Test
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class ConvertTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test
     *
     * @test
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
     * @expectedException \InvalidArgumentException
     *
     * @return void
     */
    public function densityWithInvalidWidth()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->density('chrismas')
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" -density 72x72 "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @expectedException \InvalidArgumentException
     *
     * @return void
     */
    public function densityWithInvalidHeight()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->density(72, 'chrismas')
            ->outputfile('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" -density 72x72 "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -rotate "-45"  -background gray "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
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
}
