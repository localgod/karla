<?php
use Karla\Karla;
/**
 * Karla Test file
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
 * Karla Test class
 *
 * @category Test
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 */
class KarlaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     *
     * @test
     * @return void
     */
    public function getInstance()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $this->assertInstanceOf('Karla\Karla', $karla);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function raw()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $this->assertTrue(preg_match('/Version\:\sImageMagick/', $karla->raw('identify', '--version')) == 1);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function convert()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $this->assertInstanceOf('Karla\Program\Convert', $karla->convert());
    }

    /**
     * Test
     *
     * @return void
     */
    public function identify()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $this->assertInstanceOf('Karla\Program\Identify', $karla->identify());
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function composite()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $this->assertInstanceOf('Karla\Program\Composite', $karla->composite());
    }
}
