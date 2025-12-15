<?php
use Karla\Karla;

/**
 * Background Test file
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
/**
 * Background Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class BackgroundTest extends PHPUnit\Framework\TestCase
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
		$this->testDataPath = realpath(__DIR__.'/../../_data/');
	}

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function background()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->background('red')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', '-background red "'.$this->testDataPath.'/demo.jpg" "./test-1920x1200.png"');
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * 
     */
    public function backgroundTwice()
    {
        $this->expectException(BadMethodCallException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->background('red')
            ->background('blue')
            ->out('test-1920x1200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * 
     */
    public function backgroundWithInvalidColor()
    {
        $this->expectException(InvalidArgumentException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->background('christmas')
            ->out('test-1920x1200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function backgroundWithHexColor()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->background('#666666')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', '-background "#666666" "'.$this->testDataPath.'/demo.jpg" "./test-1920x1200.png"');
        $this->assertEquals($expected, $actual);
    }
}
