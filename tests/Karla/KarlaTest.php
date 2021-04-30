<?php
use Karla\Karla;

/**
 * Karla Test file
 *
 * PHP Version 5.3<
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
class KarlaTest extends \PHPUnit_Framework_TestCase
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
	protected function setUp()
	{
		if (! file_exists(PATH_TO_IMAGEMAGICK.'convert')) {
			$this->markTestSkipped('The imagemagick executables are not available.');
		}
		$this->testDataPath = realpath(__DIR__.'/../_data/');
	}
    /**
     * Test
     *
     * @expectedException RuntimeException
     *
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
     */
    public function composite()
    {
        $karla = Karla::perform(PATH_TO_IMAGEMAGICK);
        $this->assertInstanceOf('Karla\Program\Composite', $karla->composite());
    }
}
