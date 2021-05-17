<?php
use Karla\Karla;

/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2013-05-14
 */
/**
 * FileCache Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class FileTest extends PHPUnit\Framework\TestCase
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
	protected function setUp(): void
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
	protected function tearDown(): void
	{
	    //exec('rm -r '.(__DIR__.'/../../_cache/'));
	}
	
    /**
     * Test
     * @test
     */
    public function getCached()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
          );
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK, new \Karla\Cache\File($this->cacheDataPath))->convert()
        ->in($this->testDataPath.'/demo.jpg')
        ->crop(100, 100)
        ->background('red')
        ->out($this->cacheDataPath.'/'.md5($this->testDataPath.'/demo.jpg').'.png')
        ->execute();
        $this->assertEquals('"'.$this->cacheDataPath.'/1ddd465aeac5809d158b06a7b5d7c42a.png'.'"', $actual);
    }

    /**
     * Test
     * @test
     */
    public function setCache()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
          );
        Karla::perform(PATH_TO_IMAGEMAGICK, new \Karla\Cache\File($this->cacheDataPath))->convert()
        ->in($this->testDataPath.'/demo.jpg')
        ->crop(100, 100)
        ->background('red')
        ->out($this->cacheDataPath.'/'.md5($this->testDataPath.'/demo.jpg').'.png')
        ->execute();
        $this->assertTrue(file_exists($this->cacheDataPath.'/1ddd465aeac5809d158b06a7b5d7c42a.png'));
    }
}
