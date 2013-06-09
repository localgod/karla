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
 * Type Test class
 *
 * @category Test
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class TypeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test
     *
     * @test
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
}