<?php
use Karla\Karla;


/**
 * Bordercolor Test file
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
/**
 * Bordercolor Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class BordercolorTest extends PHPUnit\Framework\TestCase
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
    public function bordercolorWithColorName()
    {
        // You will not be able to see the border in the resulting image, as this test has no border argument.
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->bordercolor('red')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', '-bordercolor red "'.$this->testDataPath.'/demo.jpg" "./test-1920x1200.png"');
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * 
     */
    public function bordercolorTwice()
    {
        $this->expectException(BadMethodCallException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->bordercolor('red')
            ->bordercolor('red')
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
    public function bordercolorWithHexColor()
    {
        // You will not be able to see the border in the resulting image, as this test has no border argument.
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->bordercolor('#666666')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', '-bordercolor "#666666" "'.$this->testDataPath.'/demo.jpg" "./test-1920x1200.png"');
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function bordercolorWithRgbColor()
    {
        // You will not be able to see the border in the resulting image, as this test has no border argument.
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->bordercolor('rgb(255,255,255)')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', '-bordercolor "rgb(255,255,255)" "'.$this->testDataPath.'/demo.jpg" "./test-1920x1200.png"');
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * 
     */
    public function bordercolorWithInvalidColor()
    {
        $this->expectException(InvalidArgumentException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->bordercolor('grenish')
            ->out('test-1920x1200.png')
            ->getCommand();
    }
}