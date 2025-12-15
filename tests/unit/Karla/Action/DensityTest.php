<?php
use Karla\Karla;


/**
 * Density Test file
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2014-07-15
 */
/**
 * Density Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class DensityTest extends PHPUnit\Framework\TestCase
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
    public function density()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->density()
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', '"'.$this->testDataPath.'/demo.jpg" -density 72x72 "./test-1920x1200.png"');
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function densityAsAnInputputArgument()
    {
    	$actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
    	->in($this->testDataPath.'/demo.jpg')
    	->density(72, 72, false)
    	->out('test-1920x1200.png')
    	->getCommand();
    	$expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', '-density 72x72 "'.$this->testDataPath.'/demo.jpg" "./test-1920x1200.png"');
    	$this->assertEquals($expected, $actual);
    }
    
    /**
     * Test
     *
     * @test
     * @return crop
     */
    public function callDensityWithInvalidOutputSelection()
    {
        //$this->expectException(InvalidArgumentException::class);
    	$actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
    	->in($this->testDataPath.'/demo.jpg')
    	->density(72, 72, 3)
    	->out('test-200x200.png')
    	->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', '"'.$this->testDataPath.'/demo.jpg" -density 72x72 "./test-200x200.png"');
        $this->assertEquals($expected, $actual);
    }
}
