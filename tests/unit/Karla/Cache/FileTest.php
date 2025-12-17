<?php
use Karla\Karla;
use Karla\Cache\File;

require_once __DIR__ . '/../../TestHelper.php';

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
	 * 
	 */
	protected function setUp(): void
	{
		if (! TestHelper::isImageMagickAvailable(PATH_TO_IMAGEMAGICK)) {
			$this->markTestSkipped('The imagemagick executables are not available.');
		}
		
		// Create cache directory if it doesn't exist
		$cachePath = __DIR__ . '/../../_cache/';
		if (!is_dir($cachePath)) {
		    mkdir($cachePath, 0777, true);
		}
		
		$this->cacheDataPath = realpath($cachePath);
		$this->testDataPath = realpath(__DIR__.'/../../_data/');
	}
	
	/**
	 * Tears down the fixture
	 */
	protected function tearDown(): void
	{
	    // Clean up cache files after tests
	    if (is_dir($this->cacheDataPath)) {
	        $files = glob($this->cacheDataPath . '/*.{jpg,png,gif}', GLOB_BRACE);
	        foreach ($files as $file) {
	            if (is_file($file)) {
	                unlink($file);
	            }
	        }
	    }
	}
	
	/**
	 * Test constructor with invalid path throws exception
	 */
	public function testConstructorInvalidPath(): void
	{
	    $this->expectException(\InvalidArgumentException::class);
	    $this->expectExceptionMessage('Path not found');
	    
	    new File('/path/that/does/not/exist');
	}
	
	/**
	 * Test constructor with non-writable path throws exception
	 */
	public function testConstructorNonWritablePath(): void
	{
	    if (DIRECTORY_SEPARATOR === '\\') {
	        $this->markTestSkipped('Skipping permission test on Windows');
	    }
	    
	    $tempDir = sys_get_temp_dir() . '/karla_readonly_' . uniqid();
	    mkdir($tempDir);
	    chmod($tempDir, 0444); // Read-only
	    
	    try {
	        $this->expectException(\InvalidArgumentException::class);
	        $this->expectExceptionMessage('Path not writable');
	        
	        new File($tempDir);
	    } finally {
	        chmod($tempDir, 0755);
	        rmdir($tempDir);
	    }
	}
	
	/**
	 * Test constructor with file instead of directory throws exception
	 */
	public function testConstructorNotDirectory(): void
	{
	    $tempFile = tempnam(sys_get_temp_dir(), 'karla_');
	    
	    try {
	        $this->expectException(\InvalidArgumentException::class);
	        $this->expectExceptionMessage('Path not a directory');
	        
	        new File($tempFile);
	    } finally {
	        unlink($tempFile);
	    }
	}
	
	/**
	 * Test isCached returns false when file not cached
	 */
	public function testIsCachedReturnsFalse(): void
	{
	    $cache = new File($this->cacheDataPath);
	    $inputFile = $this->testDataPath . '/demo.jpg';
	    $outputFile = $this->cacheDataPath . '/output.png';
	    $options = ['-resize 100x100', '-quality 90'];
	    
	    $this->assertFalse($cache->isCached($inputFile, $outputFile, $options));
	}
	
	/**
	 * Test setCache and isCached
	 */
	public function testSetCacheAndIsCached(): void
	{
	    $cache = new File($this->cacheDataPath);
	    $inputFile = $this->testDataPath . '/demo.jpg';
	    $outputFile = $this->cacheDataPath . '/output.png';
	    $options = ['-resize 100x100'];
	    
	    // Initially not cached
	    $this->assertFalse($cache->isCached($inputFile, $outputFile, $options));
	    
	    // Create a dummy output file
	    copy($inputFile, $outputFile);
	    
	    // Cache it
	    $cache->setCache($inputFile, $outputFile, $options);
	    
	    // Now should be cached
	    $this->assertTrue($cache->isCached($inputFile, $outputFile, $options));
	    
	    // Clean up
	    @unlink($outputFile);
	    $cachedFile = $cache->getCached($inputFile, $outputFile, $options);
	    @unlink($cachedFile);
	}
	
	/**
	 * Test getCached returns correct filename
	 */
	public function testGetCachedFilename(): void
	{
	    $cache = new File($this->cacheDataPath);
	    $inputFile = $this->testDataPath . '/demo.jpg';
	    $outputFile = $this->cacheDataPath . '/output.png';
	    $options = ['-resize 100x100'];
	    
	    $cachedFile = $cache->getCached($inputFile, $outputFile, $options);
	    
	    // Should return a path in cache directory with .png extension
	    $this->assertStringContainsString($this->cacheDataPath, $cachedFile);
	    $this->assertStringEndsWith('.png', $cachedFile);
	}
	
	/**
	 * Test cache filename is consistent
	 */
	public function testCacheFilenameConsistent(): void
	{
	    $cache = new File($this->cacheDataPath);
	    $inputFile = $this->testDataPath . '/demo.jpg';
	    $outputFile = $this->cacheDataPath . '/output.png';
	    $options = ['-resize 100x100'];
	    
	    $cachedFile1 = $cache->getCached($inputFile, $outputFile, $options);
	    $cachedFile2 = $cache->getCached($inputFile, $outputFile, $options);
	    
	    $this->assertEquals($cachedFile1, $cachedFile2);
	}
	
	/**
	 * Test cache filename changes with different options
	 */
	public function testCacheFilenameDifferentOptions(): void
	{
	    $cache = new File($this->cacheDataPath);
	    $inputFile = $this->testDataPath . '/demo.jpg';
	    $outputFile = $this->cacheDataPath . '/output.png';
	    
	    $cachedFile1 = $cache->getCached($inputFile, $outputFile, ['-resize 100x100']);
	    $cachedFile2 = $cache->getCached($inputFile, $outputFile, ['-resize 200x200']);
	    
	    $this->assertNotEquals($cachedFile1, $cachedFile2);
	}
	
	/**
	 * Test getCached integration with Karla
	 */
	public function testGetCachedWithExecution(): void
	{
	    if (!TestHelper::isImageMagickAvailable(PATH_TO_IMAGEMAGICK)) {
	        $this->markTestSkipped('ImageMagick is not available');
	    }
	    
	    $cache = new File($this->cacheDataPath);
	    $inputFile = $this->testDataPath . '/demo.jpg';
	    $outputFile = $this->cacheDataPath . '/output_exec.png';
	    $options = ['-resize 50x50'];
	    
	    // Initially not cached
	    $this->assertFalse($cache->isCached($inputFile, $outputFile, $options));
	    
	    // Create output file and cache it
	    copy($inputFile, $outputFile);
	    $cache->setCache($inputFile, $outputFile, $options);
	    
	    // Verify cached file exists
	    $cachedFile = $cache->getCached($inputFile, $outputFile, $options);
	    $this->assertFileExists($cachedFile);
	    
	    // Clean up
	    @unlink($outputFile);
	    @unlink($cachedFile);
	}
	
	/**
	 * Test setCache creates file with correct content
	 */
	public function testSetCacheFileContent(): void
	{
	    $cache = new File($this->cacheDataPath);
	    $inputFile = $this->testDataPath . '/demo.jpg';
	    $outputFile = $this->cacheDataPath . '/output_content.png';
	    $options = ['-resize 75x75'];
	    
	    // Create output file with known content
	    copy($inputFile, $outputFile);
	    $originalContent = file_get_contents($outputFile);
	    
	    // Cache it
	    $cache->setCache($inputFile, $outputFile, $options);
	    
	    // Get cached file and verify content matches
	    $cachedFile = $cache->getCached($inputFile, $outputFile, $options);
	    $this->assertFileExists($cachedFile);
	    
	    $cachedContent = file_get_contents($cachedFile);
	    $this->assertEquals($originalContent, $cachedContent);
	    
	    // Clean up
	    @unlink($outputFile);
	    @unlink($cachedFile);
	}
}
