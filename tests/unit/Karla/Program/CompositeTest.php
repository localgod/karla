<?php
use Karla\Karla;

/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2013-05-14
 */
/**
 * Composite Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class CompositeTest extends PHPUnit\Framework\TestCase
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
		if (! TestHelper::isImageMagickAvailable(PATH_TO_IMAGEMAGICK)) {
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
    public function basefile()
    {
        $this->assertInstanceOf('Karla\Program\Composite', Karla::perform(PATH_TO_IMAGEMAGICK)->composite()
            ->basefile());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function changefile()
    {
        $this->assertInstanceOf('Karla\Program\Composite', Karla::perform(PATH_TO_IMAGEMAGICK)->composite()
            ->changefile());
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function outputfile()
    {
        $this->assertInstanceOf('Karla\Program\Composite', Karla::perform(PATH_TO_IMAGEMAGICK)->composite()
            ->outputfile());
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
        $this->assertInstanceOf('Karla\Program\Composite', Karla::perform(PATH_TO_IMAGEMAGICK)->composite()
            ->raw(''));
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
        $object = clone Karla::perform(PATH_TO_IMAGEMAGICK)->composite();
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
        $this->assertNotNull(Karla::perform(PATH_TO_IMAGEMAGICK)->composite()
            ->getCommand());
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
        $this->markTestIncomplete('This test has not been implemented yet.');
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
    public function validProgram()
    {
        $this->assertTrue(Karla::perform(PATH_TO_IMAGEMAGICK)->composite()
            ->validProgram('composite'));
        $this->assertFalse(Karla::perform(PATH_TO_IMAGEMAGICK)->composite()
            ->validProgram('git'));
    }
}
