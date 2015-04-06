<?php
use Karla\Karla;

/**
 * Strip Test file
 *
 * PHP Version 5.3<
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
/**
 * Strip Test class
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class StripTest extends \PHPUnit_Framework_TestCase
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
     * @covers Karla\Program\Convert::strip
     *
     * @return void
     */
    public function strip()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->strip()
            ->out('test-200x200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -strip "tests/_data/demo.jpg" "./test-200x200.png"';
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
    public function stripTwice()
    {
        Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->strip()
            ->strip()
            ->out('test-200x200.png')
            ->getCommand();
    }
}