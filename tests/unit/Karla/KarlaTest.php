<?php
use Karla\Karla;


/**
 * Karla Test file
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
/**
 * Karla Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class KarlaTest extends PHPUnit\Framework\TestCase
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
	 * 
	 */
	protected function setUp(): void
	{
		if (! TestHelper::isImageMagickAvailable(PATH_TO_IMAGEMAGICK)) {
			$this->markTestSkipped('The imagemagick executables are not available.');
		}
		$this->testDataPath = realpath(__DIR__.'/../_data/');
	}
    /**
     * Test
     *
     * @expectedException RuntimeException
     *
     * 
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
     * 
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
     * 
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
     * 
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
     * 
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
     * 
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
     * 
     */
    public function composite()
    {
        $karla = Karla::perform(PATH_TO_IMAGEMAGICK);
        $this->assertInstanceOf('Karla\Program\Composite', $karla->composite());
    }
}
