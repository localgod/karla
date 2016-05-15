<?php
use Karla\Karla;
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5.3<
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2013-05-14
 */
/**
 * FileCache Test class
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class FileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Path to test files
     *
     * @var string
     */
    private $testDataPath;
    
    
    /**
     * Path to cache files
     *
     * @var string
     */
    private $cacheDataPath;
    
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
		exec('mkdir -p '.(__DIR__.'/../../_cache/'));
		$this->cacheDataPath = realpath(__DIR__.'/../../_cache/');
		$this->testDataPath = realpath(__DIR__.'/../../_data/');
	}
	
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return void
	 */
	protected function tearDown()
	{
	    //exec('rm -r '.(__DIR__.'/../../_cache/'));
	}
	
    /**
     * Test
     *
     * @todo For some reason this test works when it run as the only test but not in the entires suite
     */
    public function getCached()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK, new \Karla\Cache\File($this->cacheDataPath))->convert()
        ->in($this->testDataPath.'/demo.jpg')
        ->crop(100, 100)
        ->background('red')
        ->out($this->testDataPath.'/cached.png')
        ->execute();
        $this->assertEquals($this->cacheDataPath.'/324dc866d046ff712607f3c4decf1559.png', $actual);
    }

    /**
     * Test
     *
     * @test
     */
    public function setCache()
    {
        Karla::perform(PATH_TO_IMAGEMAGICK, new \Karla\Cache\File($this->cacheDataPath))->convert()
        ->in($this->testDataPath.'/demo.jpg')
        ->crop(100, 100)
        ->background('red')
        ->out($this->testDataPath.'/cached.png')
        ->execute();
        $this->assertTrue(file_exists($this->cacheDataPath.'/324dc866d046ff712607f3c4decf1559.png'));
    }
}
