<?php
/**
 * Convert Test file
 *
 * PHP Version 7.4<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
use Karla\Karla;

/**
 * Convert Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class ConvertTest extends PHPUnit\Framework\TestCase
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
     * @return void
     */
    public function invalidInputfile()
    {
        $this->expectException(InvalidArgumentException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo2.jpg')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function inputfileWithoutOutputfile()
    {
        $this->expectException(RuntimeException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function outputfileWithoutInputfile()
    {
        $this->expectException(RuntimeException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->out('test-1920x1200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function invalidOutputfile()
    {
        $this->expectException(InvalidArgumentException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->out('/nowhere/test-1920x1200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function inputfileAndOutputfile()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "'.$this->testDataPath.'/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function removeProfile()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->removeProfile('iptc')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "'.$this->testDataPath.'/demo.jpg" +profile iptc "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function density()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->density()
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "'.$this->testDataPath.'/demo.jpg" -density 72x72 "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function densityWithInvalidWidth()
    {
        $this->expectException(InvalidArgumentException::class);
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->density('chrismas')
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" -density 72x72 "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function densityWithInvalidHeight()
    {
        $this->expectException(InvalidArgumentException::class);
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->density(72, 'chrismas')
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" -density 72x72 "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function densityWithResample()
    {
        $this->expectException(BadMethodCallException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->resample(200, 200, 72, 72)
            ->density()
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
    public function profile()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->profile($this->testDataPath.'/sRGB_Color_Space_Profile.icm')
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "'.$this->testDataPath.'/demo.jpg" -profile "'.$this->testDataPath.'/sRGB_Color_Space_Profile.icm" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function profileWithInvalidPath()
    {
        $this->expectException(InvalidArgumentException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->profile($this->testDataPath.'/RGB_Color_Space_Profile.icm')
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
    public function changeProfile()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->changeProfile($this->testDataPath.'/sRGB_Color_Space_Profile.icm', $this->testDataPath.'/sRGB_Color_Space_Profile.icm')
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "'.$this->testDataPath.'/demo.jpg" -profile "'.$this->testDataPath.'/sRGB_Color_Space_Profile.icm"   -profile "'.$this->testDataPath.'/sRGB_Color_Space_Profile.icm" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function changeProfileTwice()
    {
        $this->expectException(BadMethodCallException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->changeProfile($this->testDataPath.'/sRGB_Color_Space_Profile.icm', $this->testDataPath.'/sRGB_Color_Space_Profile.icm')
            ->changeProfile($this->testDataPath.'/sRGB_Color_Space_Profile.icm', $this->testDataPath.'/_data/sRGB_Color_Space_Profile.icm')
            ->out('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function changeProfileInvalidNewProfile()
    {
        $this->expectException(InvalidArgumentException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->changeProfile($this->testDataPath.'/sRGB_Color_Space_Profile.icm', $this->testDataPath.'/RGB_Color_Space_Profile.icm')
            ->out('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function changeProfileInvalidOldProfile()
    {
        $this->expectException(InvalidArgumentException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->changeProfile($this->testDataPath.'/RGB_Color_Space_Profile.icm', $this->testDataPath.'/sRGB_Color_Space_Profile.icm')
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
    public function gravity()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->out('test-200x200.png')
            ->gravity('center')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -gravity center "'.$this->testDataPath.'/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function gravityTwice()
    {
        $this->expectException(BadMethodCallException::class);
        $karla = Karla::perform(PATH_TO_IMAGEMAGICK);
        $karla->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->gravity('center')
            ->gravity('center')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function __clone()
    {
        $this->expectException(BadMethodCallException::class);
        $object = clone Karla::perform(PATH_TO_IMAGEMAGICK)->convert();
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function getCommand()
    {
        $command = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->out('test-1920x1200.png')
            ->getCommand();
        $this->assertNotNull($command);
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function execute()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function raw()
    {
        $this->assertInstanceOf('Karla\Program\Convert', Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->raw(''));
    }

    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function validProgram()
    {
        $this->assertTrue(Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->validProgram('convert'));
        $this->assertFalse(Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->validProgram('git'));
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
            ->rotate(- 45, 'gray')
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -rotate "-45"  -background gray "'.$this->testDataPath.'/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @return void
     */
    public function rotateTwice()
    {
        $this->expectException(BadMethodCallException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->rotate(- 45, 'gray')
            ->rotate(- 45, 'gray')
            ->out('test-200x200.png')
            ->getCommand();
    }
}
