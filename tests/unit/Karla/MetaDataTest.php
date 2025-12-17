<?php
use Karla\Karla;


/**
 * MetaData Test file
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2013-05-11
 */
/**
 * MetaData Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class MetaDataTest extends PHPUnit\Framework\TestCase
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
     * Meta data obejct
     *
     * @var MetaData
     */
    protected $object;

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        $this->object = null;
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getResolutionHeight()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(null, $this->object->getResolutionHeight());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getResolutionHeightVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(null, $this->object->getResolutionHeight());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getResolutionWidthVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(null, $this->object->getResolutionWidth());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getResolutionWidth()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(null, $this->object->getResolutionWidth());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function parseMethods()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(null, $this->object->getResolutionWidth());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function parseMethodsVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->verbose()
            ->execute(true, false);
        $this->assertEquals(null, $this->object->getResolutionWidth());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getFormatVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('jpeg', $this->object->getFormat());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getFormat()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('jpeg', $this->object->getFormat());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getDepthVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(8, $this->object->getDepth());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getDepth()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(8, $this->object->getDepth());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getColorspaceVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('srgb', $this->object->getColorspace());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getColorspace()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('srgb', $this->object->getColorspace());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getGeometryVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertArrayHasKey(0, $this->object->getGeometry());
        $this->assertArrayHasKey(1, $this->object->getGeometry());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getGeometry()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertArrayHasKey(0, $this->object->getGeometry());
        $this->assertArrayHasKey(1, $this->object->getGeometry());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getHeightVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(100, $this->object->getHeight());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getHeight()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(100, $this->object->getHeight());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getWidthVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(100, $this->object->getWidth());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getWidth()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals(100, $this->object->getWidth());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function listRawVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertStringStartsWith('<ul>', $this->object->listRaw());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function listRaw()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertStringStartsWith('<ul>', $this->object->listRaw());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getUnitVerbose()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->verbose()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('Pixels Per Inch', $this->object->getUnit());
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getUnit()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('Pixels Per Inch', $this->object->getUnit());
    }

     /**
     * Test
     *
     * @test
     *
     * 
     */
    public function getHash()
    {
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->assertEquals('39243b5cd4e795d41ee6aa79e6762939', $this->object->getHash());
    }

    /**
     * Test
     *
     * @test
     * 
     */
    public function getHashWithInvalidAlgorithm()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object = Karla::perform(PATH_TO_IMAGEMAGICK)->identify()
            ->in($this->testDataPath.'/demo.jpg')
            ->execute(true, false);
        $this->object->getHash('sha');
    }
}
