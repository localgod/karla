<?php
use Karla\Karla;

/**
 * Karla Test file
 *
 * PHP Version 5.3<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
/**
 * Karla Test class
 *
 * @category Test
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class KarlaTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test
     *
     * @expectedException RuntimeException
     *
     * @return void
     */
    public function getInstanceWithInvalidPath()
    {
        Karla::perform('/going/nowhere/');
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function perform()
    {
        $this->assertInstanceOf('Karla\Karla', Karla::perform(PATH_TO_IMAGEMAGICK));
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function privateMethods()
    {
        $this->assertInstanceOf('Karla\Karla', Karla::perform(PATH_TO_IMAGEMAGICK));
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
        $karla = Karla::perform(PATH_TO_IMAGEMAGICK);
        $this->assertTrue(preg_match('/Version\:\sImageMagick/', $karla->raw('identify', '--version')) == 1);
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function convert()
    {
        $karla = Karla::perform(PATH_TO_IMAGEMAGICK);
        $this->assertInstanceOf('Karla\Program\Convert', $karla->convert());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function identify()
    {
        $karla = Karla::perform(PATH_TO_IMAGEMAGICK);
        $this->assertInstanceOf('Karla\Program\Identify', $karla->identify());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function composite()
    {
        $karla = Karla::perform(PATH_TO_IMAGEMAGICK);
        $this->assertInstanceOf('Karla\Program\Composite', $karla->composite());
    }
}
