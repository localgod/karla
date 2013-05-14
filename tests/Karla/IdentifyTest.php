<?php
/**
 * Identify Test file
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
 * Identify Test class
 *
 * @category   Test
 * @package    Karla
 * @subpackage Karla
 * @author     Johannes Skov Frandsen <localgod@heaven.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/localgod/Karla Karla
 */
class IdentifyTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test
     *
     * @test
     * @covers Identify::inputfile
     * @return void
     */
    public function inputfile()
    {
        $karla = Karla::getInstance();
        $command = $karla->identify()->inputfile('tests/_data/demo.jpg')->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:/opt/local/bin/;identify "tests/_data/demo.jpg"');
    }
    /**
     * Test
     *
     * @test
     * @covers Identify::inputfile
     * @expectedException InvalidArgumentException
     * @return void
     */
    public function invalidInputfile()
    {
        $karla = Karla::getInstance();
        $command = $karla->identify()->inputfile('tests/_data/demo2.jpg')->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Identify::execute
     * @return void
     */
    public function execute()
    {
        $karla = Karla::getInstance();
        $result = $karla->identify()->inputfile('tests/_data/demo.jpg')->execute();
        $this->assertTrue(preg_match('/tests\/_data\/demo\.jpg\sJPEG\s200x155\s200x155\+0\+0\s8-bit\ssRGB.*/', $result) == 1);
    }
    /**
     * Test
     *
     * @test
     * @covers Identify::execute
     * @return void
     */
    public function executeNoRaw()
    {
        $karla = Karla::getInstance();
        $result = $karla->identify()->inputfile('tests/_data/demo.jpg')->execute(true, false);
        $this->assertTrue($result instanceof MetaData);
    }
    /**
     * Test
     *
     * @test
     * @covers Identify::execute
     * @return void
     */
    public function executeNoReset()
    {
        $karla = Karla::getInstance();
        $result = $karla->identify()->inputfile('tests/_data/demo.jpg')->execute(false);
        $this->assertTrue(preg_match('/tests\/_data\/demo\.jpg\sJPEG\s200x155\s200x155\+0\+0\s8-bit\ssRGB.*/', $result) == 1);

    }
    /**
     * Test
     *
     * @test
     * @covers Identify::execute
     * @return void
     */
    public function executeNoResetNoRaw()
    {
        $karla = Karla::getInstance();
        $result = $karla->identify()->inputfile('tests/_data/demo.jpg')->execute(false, false);
        $this->assertTrue($result instanceof MetaData);
    }

    /**
     * Test
     *
     * @test
     * @covers Identify::verbose
     * @return void
     */
    public function verbose()
    {
        $karla = Karla::getInstance();
        $command = $karla->identify()->inputfile('tests/_data/demo.jpg')->verbose()->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:/opt/local/bin/;identify -verbose "tests/_data/demo.jpg"');
    }
    /**
     * Test
     *
     * @test
     * @covers Identify::verbose
     * @return void
     */
    public function verboseTwice()
    {
        $karla = Karla::getInstance();
        $command = $karla->identify()->inputfile('tests/_data/demo.jpg')->verbose()->verbose()->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:/opt/local/bin/;identify -verbose "tests/_data/demo.jpg"');
    }
    /**
     * Test
     *
     * @test
     * @covers Identify::gravity
     * @return void
     */
    public function gravity()
    {
        $karla = Karla::getInstance();
        $this->assertInstanceOf('Identify', $karla->identify()->gravity(''));
        $command = $karla->identify()->inputfile('tests/_data/demo.jpg')->gravity('center')->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:/opt/local/bin/;identify "tests/_data/demo.jpg"');
    }
    /**
     * Test
     *
     * @test
     * @covers Identify::gravity
     * @return void
     */
    public function gravityTwice()
    {
        $karla = Karla::getInstance();
        $command = $karla->identify()->inputfile('tests/_data/demo.jpg')->gravity('center')->gravity('center')->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:/opt/local/bin/;identify "tests/_data/demo.jpg"');
    }

    /**
     * Test
     *
     * @test
     * @covers Identify::isDirty
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
     * @covers Identify::__clone
     * @expectedException BadMethodCallException
     * @return void
     */
    public function __clone()
    {
        $object = clone Karla::getInstance()->identify();
    }

    /**
     * Test
     *
     * @test
     * @covers Identify::getCommand
     * @return void
     */
    public function getCommand()
    {
        $this->assertNotNull(Karla::getInstance()->identify()->inputfile('tests/_data/demo.jpg')->getCommand());
    }

    /**
     * Test
     *
     * @test
     * @covers Identify::reset
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
     * @covers Identify::raw
     * @return void
     */
    public function raw()
    {
        $this->assertInstanceOf('Identify', Karla::getInstance()->identify()->raw(''));
    }

    /**
     * Test
     *
     * @test
     * @covers Identify::density
     * @return void
     */
    public function density()
    {
       $this->assertInstanceOf('Identify', Karla::getInstance()->identify()->density());
    }

    /**
     * Test
     *
     * @test
     * @covers Identify::validProgram
     * @return void
     */
    public function validProgram()
    {
        $this->assertTrue(Karla::getInstance()->composite()->validProgram('identify'));
        $this->assertFalse(Karla::getInstance()->composite()->validProgram('git'));
    }
}
