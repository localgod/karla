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
 * Background Test class
 *
 * @category Test
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class BackgroundTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test
     *
     * @test
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
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -background red "tests/_data/demo.jpg" "./test-1920x1200.png"';
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
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function backgroundWithInvalidColor()
    {
        Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->background('christmas')
            ->outputfile('test-1920x1200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function backgroundWithHexColor()
    {
        $actual = Karla::getInstance(PATH_TO_IMAGEMAGICK)->convert()
            ->inputfile('tests/_data/demo.jpg')
            ->background('#666666')
            ->outputfile('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -background "#666666" "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }
}
