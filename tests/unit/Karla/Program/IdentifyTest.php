<?php
use Karla\Karla;


/**
 * Identify Test file
 *
 * PHP Version 7.4<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
/**
 * Identify Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class IdentifyTest extends PHPUnit\Framework\TestCase
{
    /**
     * Path to test files
     *
     * @var string
     */
    private $testDataPath;
    
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return void
	 */
	protected function setUp(): void
	{
		if (! file_exists(PATH_TO_IMAGEMAGICK.'convert')) {
			$this->markTestSkipped('The imagemagick executables are not available.');
		}
		$this->testDataPath = realpath(__DIR__.'/../../_data/');
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
            ->in($this->testDataPath.'/demo.jpg')
            ->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';identify "'.$this->testDataPath.'/demo.jpg'.'"');
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function invalidInputfile()
    {
        $this->expectException(InvalidArgumentException::class);
        $command = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo2.jpg')
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
            ->in($this->testDataPath.'/demo.jpg')
            ->execute();
        $this->assertTrue(preg_match('/demo\.jpg\sJPEG\s200x155\s200x155\+0\+0\s8-bit\ssRGB.*/', $result) == 1);
    }

    /**
     * Test
     * 
     * @test
     *
     * @return void
     */
    public function executeNoRaw()
    {
        $result = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
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
    public function executeNoRawVerbose()
    {
        $result = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in($this->testDataPath.'/demo.jpg')
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
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(false);
        $this->assertTrue(preg_match('/demo\.jpg\sJPEG\s200x155\s200x155\+0\+0\s8-bit\ssRGB.*/', $result) == 1);
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
            ->in($this->testDataPath.'/demo.jpg')
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
            ->in($this->testDataPath.'/demo.jpg')
            ->verbose()
            ->getCommand();
        $this->assertEquals($command, 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';identify -verbose "'.$this->testDataPath.'/demo.jpg'.'"');
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function verboseTwice()
    {
        $this->expectException(BadMethodCallException::class);
        $command = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->verbose()
            ->verbose()
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function __clone()
    {
        $this->expectException(BadMethodCallException::class);
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
            ->in($this->testDataPath.'/demo.jpg')
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
