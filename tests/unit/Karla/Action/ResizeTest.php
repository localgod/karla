<?php
use Karla\Karla;


/**
 * Resize Test file
 *
 * PHP Version 7.4<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
/**
 * Resize Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class ResizeTest extends PHPUnit\Framework\TestCase
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
    public function resize()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->resize(100, 100)
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -resize 100x100\> "'.$this->testDataPath.'/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function resizeWithResample()
    {
        $this->expectException(BadMethodCallException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->resample(200, 200, 72, 72)
            ->resize(200, 200)
            ->out('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function resizeTwice()
    {
        $this->expectException(BadMethodCallException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->resize(200, 200)
            ->resize(200, 200)
            ->out('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Karla\Program\Convert::resize
     *
     * @return void
     */
    public function resizeWithoutMaintainingAspectRatio()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->resize(200, 200, false)
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -resize 200x200\>! "'.$this->testDataPath.'/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }
}
