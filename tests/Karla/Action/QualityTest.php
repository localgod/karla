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
 * Quality Test class
 *
 * @category Test
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class QualityTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test
     *
     * @test
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
}