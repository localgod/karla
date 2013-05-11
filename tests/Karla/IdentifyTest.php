<?php
/**
 * Identify Test file
 *
 * PHP Version 5.1.2
 *
 * @category Test
 * @package  Karla
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
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
 * @author     Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/localgod/Karla Karla
 */
class IdentifyTest extends PHPUnit_Framework_TestCase
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown()
    {
    }

    /**
     * Test
     *
     * @test
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
     * @return void
     */
    public function gravity()
    {
        $karla = Karla::getInstance();
        $command = $karla->identify()->inputfile('tests/_data/demo.jpg')->gravity('center')->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:/opt/local/bin/;identify "tests/_data/demo.jpg"');
    }
    /**
     * Test
     *
     * @test
     * @return void
     */
    public function gravityTwice()
    {
        $karla = Karla::getInstance();
        $command = $karla->identify()->inputfile('tests/_data/demo.jpg')->gravity('center')->gravity('center')->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:/opt/local/bin/;identify "tests/_data/demo.jpg"');
    }
}
