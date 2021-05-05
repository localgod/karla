<?php
use Karla\Karla;


/**
 * Rotate Test file
 *
 * PHP Version 7.4<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2014-07-15
 */
/**
 * Rotate Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class RotateTest extends PHPUnit\Framework\TestCase
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
    public function rotate()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->rotate(45)
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -rotate "45"  -background "#ffffff" "'.$this->testDataPath.'/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Test
     *
     * @test
     * @return crop
     */
    public function rotateWithInvalidDegreeArgument()
    {
        $this->expectException(InvalidArgumentException::class);
    	Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
    	->in($this->testDataPath.'/demo.jpg')
    	->rotate('two')
    	->out('test-200x200.png')
    	->getCommand();
    }
}
