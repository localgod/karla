<?php
use Karla\Karla;

/**
 * Flatten Test file
 *
 * PHP Version 5.3<
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since 2012-04-05
 */
/**
 * Flatten Test class
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class FlattenTest extends \PHPUnit_Framework_TestCase
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
     * @return void
     */
    public function flatten()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->flatten()
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -flatten "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @expectedException BadMethodCallException
     *
     * @return void
     */
    public function flattenTwice()
    {
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->flatten()
            ->flatten()
            ->out('test-200x200.png')
            ->getCommand();
    }
}