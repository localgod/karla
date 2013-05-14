<?php
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5
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
 * @category   Utility
 * @package    Karla
 * @subpackage Karla
 * @author     Johannes Skov Frandsen <localgod@heaven.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/localgod/Karla Karla
 */
class CompositeTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test
     *
     * @test
     * @covers Composite::basefile
     * @return void
     */
    public function basefile()
    {
        $this->assertInstanceOf('Composite', Karla::getInstance()->composite()->basefile());
    }

    /**
     * Test
     *
     * @test
     * @covers Composite::changefile
     * @return void
     */
    public function changefile()
    {
        $this->assertInstanceOf('Composite', Karla::getInstance()->composite()->changefile());
    }

    /**
     * Test
     *
     * @test
     * @covers Composite::outputfile
     * @return void
     */
    public function outputfile()
    {
        $this->assertInstanceOf('Composite', Karla::getInstance()->composite()->outputfile());
    }

    /**
     * Test
     *
     * @test
     * @covers Composite::raw
     * @return void
     */
    public function raw()
    {
        $this->assertInstanceOf('Composite', Karla::getInstance()->composite()->raw(''));
    }

    /**
     * Test
     *
     * @test
     * @covers Composite::gravity
     * @return void
     */
    public function gravity()
    {
        $this->assertInstanceOf('Composite', Karla::getInstance()->composite()->gravity(''));
    }

    /**
     * Test
     *
     * @test
     * @covers Composite::isDirty
     * @return void
     */
    public function isDirty()
    {
        $this->assertTrue(!Karla::getInstance()->composite()->isDirty());
    }

    /**
     * Test
     *
     * @test
     * @covers Composite::__clone
     * @expectedException BadMethodCallException
     * @return void
     */
    public function __clone()
    {
        $object = clone Karla::getInstance()->composite();
    }

    /**
     * Test
     *
     * @test
     * @covers Composite::getCommand
     * @return void
     */
    public function getCommand()
    {
        $this->assertNotNull(Karla::getInstance()->composite()->getCommand());
    }

    /**
     * Test
     *
     * @test
     * @covers Composite::execute
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
     * @covers Composite::reset
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
     * @covers Composite::density
     * @return void
     */
    public function density()
    {
       $this->assertInstanceOf('Composite', Karla::getInstance()->composite()->density());
    }

    /**
     * Test
     *
     * @test
     * @covers Composite::validProgram
     * @return void
     */
    public function validProgram()
    {
        $this->assertTrue(Karla::getInstance()->composite()->validProgram('composite'));
        $this->assertFalse(Karla::getInstance()->composite()->validProgram('git'));
    }
}
