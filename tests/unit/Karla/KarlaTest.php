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
		$this->testDataPath = realpath(__DIR__.'/../_data/');
	}

    /**
     * Skip the current test if ImageMagick is not available.
     *
     * 
     */
    private function requireImageMagick(): void
    {
        if (! TestHelper::isImageMagickAvailable(PATH_TO_IMAGEMAGICK)) {
            $this->markTestSkipped('The imagemagick executables are not available.');
        }
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
        $this->requireImageMagick();
        $this->assertInstanceOf('Karla\Karla', Karla::perform(PATH_TO_IMAGEMAGICK));
    }

    /**
     * Test that the constructor is public and creates a valid Karla instance.
     *
     * @test
     *
     * 
     */
    public function constructor()
    {
        $this->requireImageMagick();
        $this->assertInstanceOf('Karla\Karla', new Karla(PATH_TO_IMAGEMAGICK));
    }

    /**
     * Test that the constructor accepts an explicit version and skips detection.
     *
     * @test
     */
    public function constructorWithExplicitVersion()
    {
        $karla = new Karla(sys_get_temp_dir(), null, 7);
        $this->assertInstanceOf('Karla\Karla', $karla);

        $ref = new \ReflectionProperty(Karla::class, 'version');
        $ref->setAccessible(true);
        $this->assertSame(7, $ref->getValue($karla));
    }

    /**
     * Test that perform() accepts and passes through an explicit version.
     *
     * @test
     */
    public function performWithExplicitVersion()
    {
        $karla = Karla::perform(sys_get_temp_dir(), null, 6);
        $this->assertInstanceOf('Karla\Karla', $karla);

        $ref = new \ReflectionProperty(Karla::class, 'version');
        $ref->setAccessible(true);
        $this->assertSame(6, $ref->getValue($karla));
    }

    /**
     * Test that the constructor throws an exception for an invalid path.
     *
     * @test
     *
     * 
     */
    public function constructorWithInvalidPath()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Karla('/going/nowhere/');
    }

    /**
     * Test that each call to perform() returns a fresh instance.
     *
     * @test
     *
     * 
     */
    public function performReturnsFreshInstance()
    {
        $this->requireImageMagick();
        $first  = Karla::perform(PATH_TO_IMAGEMAGICK);
        $second = Karla::perform(PATH_TO_IMAGEMAGICK);
        $this->assertNotSame($first, $second);
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
        $this->requireImageMagick();
        $karla = new Karla(PATH_TO_IMAGEMAGICK);
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
        $this->requireImageMagick();
        $karla = new Karla(PATH_TO_IMAGEMAGICK);
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
        $this->requireImageMagick();
        $karla = new Karla(PATH_TO_IMAGEMAGICK);
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
        $this->requireImageMagick();
        $karla = new Karla(PATH_TO_IMAGEMAGICK);
        $this->assertInstanceOf('Karla\Program\Composite', $karla->composite());
    }
}
