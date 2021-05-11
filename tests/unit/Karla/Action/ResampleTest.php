<?php
use Karla\Karla;


/**
 * Resample Test file
 *
 * PHP Version 7.4<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
/**
 * Resample Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class ResampleTest extends PHPUnit\Framework\TestCase
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
    public function resample()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->resample(200, 200, 72, 72)
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -density 72x72  -resample \'200x200\' "'.$this->testDataPath.'/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function resampleTwice()
    {
        $this->expectException(BadMethodCallException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->resample(200, 200, 72, 72)
            ->resample(200, 200, 72, 72)
            ->out('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function resampleWithResize()
    {
        $this->expectException(BadMethodCallException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->resize(200, 200)
            ->resample(200, 200, 72, 72)
            ->out('test-200x200.png')
            ->getCommand();
    }


    /**
     * Test
     *
     * @test
     * @return void
     */
    public function resampleWithDensity()
    {
        $this->expectException(BadMethodCallException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->density()
            ->resample(200, 200, 72, 72)
            ->out('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function resampleWithOnlyWidth()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->resample(200)
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -resample \'200x0\' "'.$this->testDataPath.'/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
     }

    /**
     * Test
     *
     * @return void
     */
    public function resampleWithOnlyOriginalWidth()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->resample(200, 200, 72)
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -density 72x72 -resample \'200x200\' "'.$this->testDataPath.'/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }
}