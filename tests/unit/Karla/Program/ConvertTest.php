<?php
/**
 * Convert Test file
 *
 * PHP Version 8.0<
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
     * 
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
     * 
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
     * 
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
     * 
     */
    public function inputfileAndOutputfile()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', escapeshellarg($this->testDataPath.'/demo.jpg').' '.escapeshellarg('./test-1920x1200.png'));
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     *
     * 
     */
    public function removeProfile()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->removeProfile('iptc')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', escapeshellarg($this->testDataPath.'/demo.jpg').' +profile iptc '.escapeshellarg('./test-1920x1200.png'));
        $this->assertEquals($expected, $actual);
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
            ->out('test-200x200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', escapeshellarg($this->testDataPath.'/demo.jpg').' -density 72x72 '.escapeshellarg('./test-200x200.png'));
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * 
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
     * 
     */
    public function profile()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->profile($this->testDataPath.'/sRGB_Color_Space_Profile.icm')
            ->out('test-200x200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', escapeshellarg($this->testDataPath.'/demo.jpg').' -profile '.escapeshellarg($this->testDataPath.'/sRGB_Color_Space_Profile.icm').' '.escapeshellarg('./test-200x200.png'));
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * 
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
     * 
     */
    public function changeProfile()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->changeProfile($this->testDataPath.'/sRGB_Color_Space_Profile.icm', $this->testDataPath.'/sRGB_Color_Space_Profile.icm')
            ->out('test-200x200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', escapeshellarg($this->testDataPath.'/demo.jpg').' -profile '.escapeshellarg($this->testDataPath.'/sRGB_Color_Space_Profile.icm').'   -profile '.escapeshellarg($this->testDataPath.'/sRGB_Color_Space_Profile.icm').' '.escapeshellarg('./test-200x200.png'));
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * 
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
     * 
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
     * 
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
     * 
     */
    public function gravity()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->out('test-200x200.png')
            ->gravity('center')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', '-gravity center '.escapeshellarg($this->testDataPath.'/demo.jpg').' '.escapeshellarg('./test-200x200.png'));
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * 
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
     * 
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
     * 
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
     * 
     */
    public function execute()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * Test
     *
     * @test
     */
    public function executeWithResultReturnsCommandResult()
    {
        $outputFile = '/tmp/karla-test-executeWithResult.jpg';
        $result = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath . '/demo.jpg')
            ->out($outputFile)
            ->executeWithResult();
        $this->assertInstanceOf(\Karla\CommandResult::class, $result);
        $this->assertTrue($result->isSuccess());
        if (file_exists($outputFile)) {
            unlink($outputFile);
        }
    }

    /**
     * Test
     *
     * @test
     *
     * 
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
     * 
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
     * 
     */
    public function rotate()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in($this->testDataPath.'/demo.jpg')
            ->rotate(- 45, 'gray')
            ->out('test-200x200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', '-rotate "-45"  -background gray '.escapeshellarg($this->testDataPath.'/demo.jpg').' '.escapeshellarg('./test-200x200.png'));
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     *
     *
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

    /**
     * Test that file paths with spaces are properly escaped using escapeshellarg()
     *
     * @test
     *
     *
     */
    public function inputfileWithSpacesIsEscaped()
    {
        $tempDir = sys_get_temp_dir() . '/karla-security-test';
        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        $tempFile = $tempDir . '/demo file.jpg';
        copy($this->testDataPath . '/demo.jpg', $tempFile);

        try {
            $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
                ->in($tempFile)
                ->out('test-output.png')
                ->getCommand();
            $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', escapeshellarg($tempFile).' '.escapeshellarg('./test-output.png'));
            $this->assertEquals($expected, $actual);
            $this->assertStringContainsString(escapeshellarg($tempFile), $actual);
        } finally {
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
            if (is_dir($tempDir)) {
                rmdir($tempDir);
            }
        }
    }

    /**
     * Test that output file paths with spaces are properly escaped using escapeshellarg()
     *
     * @test
     *
     *
     */
    public function outputfileWithSpacesIsEscaped()
    {
        $tempOutputDir = sys_get_temp_dir() . '/karla-output-test';
        if (! is_dir($tempOutputDir)) {
            mkdir($tempOutputDir, 0777, true);
        }

        try {
            $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
                ->in($this->testDataPath . '/demo.jpg')
                ->out($tempOutputDir . '/output file.png')
                ->getCommand();
            $expectedOutputPath = $tempOutputDir . '/output file.png';
            $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', escapeshellarg($this->testDataPath.'/demo.jpg').' '.escapeshellarg($expectedOutputPath));
            $this->assertEquals($expected, $actual);
            $this->assertStringContainsString(escapeshellarg($expectedOutputPath), $actual);
        } finally {
            if (is_dir($tempOutputDir)) {
                rmdir($tempOutputDir);
            }
        }
    }

    /**
     * Test that input() method works identically to in()
     *
     * @test
     */
    public function inputMethodWorksLikeIn()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->input($this->testDataPath.'/demo.jpg')
            ->output('test-1920x1200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', escapeshellarg($this->testDataPath.'/demo.jpg').' '.escapeshellarg('./test-1920x1200.png'));
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test that input() throws InvalidArgumentException for non-existent file
     *
     * @test
     */
    public function inputMethodThrowsOnInvalidFile()
    {
        $this->expectException(InvalidArgumentException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->input($this->testDataPath.'/nonexistent.jpg')
            ->getCommand();
    }

    /**
     * Test that output() throws InvalidArgumentException for non-existent directory
     *
     * @test
     */
    public function outputMethodThrowsOnInvalidPath()
    {
        $this->expectException(InvalidArgumentException::class);
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->output('/nowhere/test-1920x1200.png')
            ->getCommand();
    }

    /**
     * Test that input() and output() can be mixed with in() and out()
     *
     * @test
     */
    public function inputAndOutputCanMixWithInAndOut()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->input($this->testDataPath.'/demo.jpg')
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = TestHelper::buildExpectedCommand(PATH_TO_IMAGEMAGICK, 'convert', escapeshellarg($this->testDataPath.'/demo.jpg').' '.escapeshellarg('./test-1920x1200.png'));
        $this->assertEquals($expected, $actual);
    }
}
