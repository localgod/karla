<?php
use Karla\Karla;

/**
 * Identify Test file
 *
 * PHP Version 5.3<
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
/**
 * Identify Test class
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class IdentifyTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return void
	 */
	protected function setUp()
	{
		if (! file_exists(PATH_TO_IMAGEMAGICK.'convert')) {
			$this->markTestSkipped('The imagemagick executables are not available.');
		}
	}
    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function in()
    {
        $command = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';identify "tests/_data/demo.jpg"');
    }

    /**
     * Test
     *
     * @test
     * @expectedException InvalidArgumentException
     *
     * @return void
     */
    public function invalidInputfile()
    {
        $command = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo2.jpg')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function execute()
    {
        $result = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute();
        $this->assertTrue(preg_match('/tests\/_data\/demo\.jpg\sJPEG\s200x155\s200x155\+0\+0\s8-bit\ssRGB.*/', $result) == 1);
    }

    /**
     * Test
     *
     * @return void
     */
    public function executeNoRaw()
    {
        $result = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertInstanceOf('Karla\Metadata', $result);
    }

    /**
     * Test
     *
     * @return void
     */
    public function executeNoRawVerbose()
    {
        $result = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in('tests/_data/demo.jpg')
            ->execute(true, false);
        $this->assertInstanceOf('Karla\Metadata', $result);
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function executeNoReset()
    {
        $result = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(false);
        $this->assertTrue(preg_match('/tests\/_data\/demo\.jpg\sJPEG\s200x155\s200x155\+0\+0\s8-bit\ssRGB.*/', $result) == 1);
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function executeNoResetNoRaw()
    {
        $result = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->execute(false, false);
        $this->assertInstanceOf('Karla\Metadata', $result);
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function verbose()
    {
        $command = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->verbose()
            ->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';identify -verbose "tests/_data/demo.jpg"');
    }

    /**
     * Test
     *
     * @test
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function verboseTwice()
    {
        $command = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->verbose()
            ->verbose()
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function __clone()
    {
        $object = clone Karla::perform(PATH_TO_IMAGEMAGICK)->identify();
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getCommand()
    {
        $this->assertNotNull(Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in('tests/_data/demo.jpg')
            ->getCommand());
    }

    /**
     * Test
     *
     * @test
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
     *
     * @return void
     */
    public function raw()
    {
        $this->assertInstanceOf('Karla\Program\Identify', Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->raw(''));
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function validProgram()
    {
        $this->assertTrue(Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->validProgram('identify'));
        $this->assertFalse(Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->validProgram('git'));
    }
}
