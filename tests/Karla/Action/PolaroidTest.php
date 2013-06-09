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
 * Polaroid Test class
 *
 * @category Test
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class PolaroidTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test
     *
     * @test
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