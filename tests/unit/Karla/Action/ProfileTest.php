<?php
use Karla\Karla;


/**
 * Profile Test file
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2014-07-15
 */
/**
 * Profile Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class ProfileTest extends PHPUnit\Framework\TestCase
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
    public function profile()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->profile($this->testDataPath.'/sRGB_Color_Space_Profile.icm')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', '"'.$this->testDataPath.'/demo.jpg" -profile "'.$this->testDataPath.'/sRGB_Color_Space_Profile.icm" "./test-1920x1200.png"');
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function profileWithBuildinProfile()
    {
    	$actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
    	->in($this->testDataPath.'/demo.jpg')
    	->profile('','sRGB.icc')
    	->out('test-1920x1200.png')
    	->getCommand();
    	$expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', '"'.$this->testDataPath.'/demo.jpg" -profile sRGB.icc "./test-1920x1200.png"');
    	$this->assertEquals($expected, $actual);
    }
    
    /**
     * Test
     *
     * @test
     * @return crop
     */
    public function profileWithBothPathAndProfilenameAsArgument()
    {
        $this->expectException(LogicException::class);
    	Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
    	->in($this->testDataPath.'/demo.jpg')
    	->profile('tests/_data/sRGB_Color_Space_Profile.icm','sRGB.icc')
    	->out('test-200x200.png')
    	->getCommand();
    }
}
