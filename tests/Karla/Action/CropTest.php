<?php
use Karla\Karla;

/**
 * Crop Test file
 *
 * PHP Version 5.3<
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
/**
 * Crop Test class
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class CropTest extends \PHPUnit_Framework_TestCase
{
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
	}
    /**
     * Test
     *
     * @test
     *
     * @return crop
     */
    public function crop()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->crop(100, 100)
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -crop 100x100+0+0 +repage "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     *
     * @return crop
     */
    public function cropWidthOffset()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->crop(100, 100, 10, 10)
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -crop 100x100+10+10 +repage "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     *
     * @return crop
     */
    public function cropWidthNegativeOffset()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->crop(100, 100, - 10, - 10)
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -crop 100x100-10-10 +repage "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @expectedException BadMethodCallException
     *
     * @return crop
     */
    public function cropTwice()
    {
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->crop(100, 100)
            ->crop(100, 100)
            ->out('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @expectedException InvalidArgumentException
     *
     * @return crop
     */
    public function cropWithInvalidWidth()
    {
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->crop('chrismas', 100)
            ->out('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @expectedException InvalidArgumentException
     *
     * @return crop
     */
    public function cropWithInvalidHeight()
    {
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->crop(100, 'chrismas')
            ->out('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @expectedException InvalidArgumentException
     *
     * @return crop
     */
    public function cropWithInvalidXOffset()
    {
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->crop(100, 100, 'chrismas')
            ->out('test-200x200.png')
            ->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @expectedException InvalidArgumentException
     *
     * @return crop
     */
    public function cropWithInvalidYOffset()
    {
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->crop(100, 100, 0, 'chrismas')
            ->out('test-200x200.png')
            ->getCommand();
    }
}