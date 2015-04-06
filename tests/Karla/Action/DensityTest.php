<?php
use Karla\Karla;

/**
 * Density Test file
 *
 * PHP Version 5.3<
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2014-07-15
 */
/**
 * Density Test class
 *
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class DensityTest extends \PHPUnit_Framework_TestCase
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
    public function density()
    {
        $actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
            ->in('tests/_data/demo.jpg')
            ->density()
            ->out('test-1920x1200.png')
            ->getCommand();
        $expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert "tests/_data/demo.jpg" -density 72x72 "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * Test
     *
     * @test
     *
     * @return void
     */
    public function densityAsAnInputputArgument()
    {
    	$actual = Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
    	->in('tests/_data/demo.jpg')
    	->density(72, 72, false)
    	->out('test-1920x1200.png')
    	->getCommand();
    	$expected = 'export PATH=$PATH:' . PATH_TO_IMAGEMAGICK . ';convert -density 72x72 "tests/_data/demo.jpg" "./test-1920x1200.png"';
    	$this->assertEquals($expected, $actual);
    }
    
    /**
     * Test
     *
     * @test
     * @expectedException InvalidArgumentException
     *
     * @return crop
     */
    public function callDensityWithInvalidOutputSelection()
    {
    	Karla::perform(PATH_TO_IMAGEMAGICK)->convert()
    	->in('tests/_data/demo.jpg')
    	->density(72, 72, 3)
    	->out('test-200x200.png')
    	->getCommand();
    }

    
}
