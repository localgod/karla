<?php
use Karla\Karla;

/**
 * Identify Test file
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
 * Identify Test class
 *
 * @category Test
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class IdentifyTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::inputfile
     *
     * @return void
     */
    public function inputfile()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $command = $karla->identify()
            ->inputfile('tests/_data/demo.jpg')
            ->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';identify "tests/_data/demo.jpg"');
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::inputfile
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function invalidInputfile()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $command = $karla->identify()
            ->inputfile('tests/_data/demo2.jpg')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::execute
     *
     * @return void
     */
    public function execute()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $result = $karla->identify()
            ->inputfile('tests/_data/demo.jpg')
            ->execute();
        $this->assertTrue(preg_match('/tests\/_data\/demo\.jpg\sJPEG\s200x155\s200x155\+0\+0\s8-bit\ssRGB.*/', $result) == 1);
    }

    /**
     * Test
     *
     * @covers Karla\Program\Identify::execute
     *
     * @return void
     */
    public function executeNoRaw()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $result = $karla->identify()
            ->inputfile('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertInstanceOf('Karla\Program\Metadata', $result);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::execute
     *
     * @return void
     */
    public function executeNoReset()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $result = $karla->identify()
            ->inputfile('tests/_data/demo.jpg')
            ->execute(false);
        $this->assertTrue(preg_match('/tests\/_data\/demo\.jpg\sJPEG\s200x155\s200x155\+0\+0\s8-bit\ssRGB.*/', $result) == 1);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::execute
     *
     * @return void
     */
    public function executeNoResetNoRaw()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $result = $karla->identify()
            ->inputfile('tests/_data/demo.jpg')
            ->execute(false, false);
        $this->assertInstanceOf('Karla\Program\Metadata', $result);
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::verbose
     *
     * @return void
     */
    public function verbose()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $command = $karla->identify()
            ->inputfile('tests/_data/demo.jpg')
            ->verbose()
            ->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';identify -verbose "tests/_data/demo.jpg"');
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::verbose
     *
     * @return void
     */
    public function verboseTwice()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $command = $karla->identify()
            ->inputfile('tests/_data/demo.jpg')
            ->verbose()
            ->verbose()
            ->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';identify -verbose "tests/_data/demo.jpg"');
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::gravity
     *
     * @return void
     */
    public function gravity()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $this->assertInstanceOf('Karla\Program\Identify', $karla->identify()
            ->gravity(''));
        $command = $karla->identify()
            ->inputfile('tests/_data/demo.jpg')
            ->gravity('center')
            ->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';identify "tests/_data/demo.jpg"');
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::gravity
     *
     * @return void
     */
    public function gravityTwice()
    {
        $karla = Karla::getInstance(PATH_TO_IMAGEMAGICK);
        $command = $karla->identify()
            ->inputfile('tests/_data/demo.jpg')
            ->gravity('center')
            ->gravity('center')
            ->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';identify "tests/_data/demo.jpg"');
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::isDirty
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
     * @covers Karla\Program\Identify::__clone
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function __clone()
    {
        $object = clone Karla::getInstance(PATH_TO_IMAGEMAGICK)->identify();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::getCommand
     *
     * @return void
     */
    public function getCommand()
    {
        $this->assertNotNull(Karla::getInstance(PATH_TO_IMAGEMAGICK)->identify()
            ->inputfile('tests/_data/demo.jpg')
            ->getCommand());
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::reset
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
     * @covers Karla\Program\Identify::raw
     *
     * @return void
     */
    public function raw()
    {
        $this->assertInstanceOf('Karla\Program\Identify', Karla::getInstance(PATH_TO_IMAGEMAGICK)->identify()
            ->raw(''));
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::density
     *
     * @return void
     */
    public function density()
    {
        $this->assertInstanceOf('Karla\Program\Identify', Karla::getInstance(PATH_TO_IMAGEMAGICK)->identify()
            ->density());
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Identify::validProgram
     *
     * @return void
     */
    public function validProgram()
    {
        $this->assertTrue(Karla::getInstance(PATH_TO_IMAGEMAGICK)->composite()
            ->validProgram('identify'));
        $this->assertFalse(Karla::getInstance(PATH_TO_IMAGEMAGICK)->composite()
            ->validProgram('git'));
    }
}
