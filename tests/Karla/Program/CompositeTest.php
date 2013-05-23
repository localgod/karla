<?php
use Karla\Karla;
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5.3
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 * @since    2013-05-14
 */
/**
 * Composite Test class
 *
 * @category Test
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 */
class CompositeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Composite::basefile
     *
     * @return void
     */
    public function basefile()
    {
        $this->assertInstanceOf('Karla\Program\Composite', Karla::getInstance(PATH_TO_IMAGEMAGICK)->composite()
            ->basefile());
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Composite::changefile
     *
     * @return void
     */
    public function changefile()
    {
        $this->assertInstanceOf('Karla\Program\Composite', Karla::getInstance(PATH_TO_IMAGEMAGICK)->composite()
            ->changefile());
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Composite::outputfile
     *
     * @return void
     */
    public function outputfile()
    {
        $this->assertInstanceOf('Karla\Program\Composite', Karla::getInstance(PATH_TO_IMAGEMAGICK)->composite()
            ->outputfile());
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Composite::raw
     * @covers Karla\Program\ImageMagick::raw
     *
     * @return void
     */
    public function raw()
    {
        $this->assertInstanceOf('Karla\Program\Composite', Karla::getInstance(PATH_TO_IMAGEMAGICK)->composite()
            ->raw(''));
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Composite::gravity
     *
     * @return void
     */
    public function gravity()
    {
        $this->assertInstanceOf('Karla\Program\Composite', Karla::getInstance(PATH_TO_IMAGEMAGICK)->composite()
            ->gravity(''));
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Composite::isDirty
     *
     * @return void
     */
    public function isDirty()
    {
        $this->assertTrue(! Karla::getInstance(PATH_TO_IMAGEMAGICK)->composite()
            ->isDirty());
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Composite::__clone
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function __clone()
    {
        $object = clone Karla::getInstance(PATH_TO_IMAGEMAGICK)->composite();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Composite::getCommand
     *
     * @return void
     */
    public function getCommand()
    {
        $this->assertNotNull(Karla::getInstance(PATH_TO_IMAGEMAGICK)->composite()
            ->getCommand());
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Composite::execute
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
     * @covers Karla\Program\Composite::reset
     *
     * @return void
     */
    public function reset()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Composite::density
     *
     * @return void
     */
    public function density()
    {
        $this->assertInstanceOf('Karla\Program\Composite', Karla::getInstance(PATH_TO_IMAGEMAGICK)->composite()
            ->density());
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Composite::validProgram
     *
     * @return void
     */
    public function validProgram()
    {
        $this->assertTrue(Karla::getInstance(PATH_TO_IMAGEMAGICK)->composite()
            ->validProgram('composite'));
        $this->assertFalse(Karla::getInstance(PATH_TO_IMAGEMAGICK)->composite()
            ->validProgram('git'));
    }
}
