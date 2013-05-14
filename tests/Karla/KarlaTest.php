<?php
/**
 * Karla Test file
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
 * Karla Test class
 *
 * @category   Test
 * @package    Karla
 * @subpackage Karla
 * @author     Johannes Skov Frandsen <localgod@heaven.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/localgod/Karla Karla
 */
class KarlaTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test
     *
     * @test
     * @return void
     */
    public function testGetInstance()
    {
        $karla = Karla::getInstance();
        $this->assertTrue($karla instanceof Karla);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function testRaw()
    {
        $karla = Karla::getInstance();
        $this->assertTrue(preg_match('/Version\:\sImageMagick/', $karla->raw('identify', '--version')) == 1);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function testConvert()
    {
        $karla = Karla::getInstance();
        $this->assertTrue($karla->convert() instanceof Convert);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function testIdentify()
    {
        $karla = Karla::getInstance();
        $this->assertTrue($karla->identify() instanceof Identify);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function testComposite()
    {
        $karla = Karla::getInstance();
        $this->assertTrue($karla->composite() instanceof Composite);
    }
}
