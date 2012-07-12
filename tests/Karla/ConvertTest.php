<?php
/**
 * Convert Test file
 *
 * PHP Version 5.1.2
 *
 * @category Test
 * @package  Karla
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 * @since    2012-04-05
 */
/**
 * Convert Test class
 *
 * @category   Test
 * @package    Karla
 * @subpackage Karla
 * @author     Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/localgod/Karla Karla
 */
class ConvertTest extends PHPUnit_Framework_TestCase {

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return void
	 */
	protected function setUp() {
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return void
	 */
	protected function tearDown() {
	}

	/**
	 * Test
	 *
	 * @test
	 * @expectedException RuntimeException
	 * @return void
	 */
	public function inputfileWithoutOutputfile() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->getCommand();
	}

	/**
	 * Test
	 *
	 * @test
	 * @expectedException RuntimeException
	 * @return void
	 */
	public function outputfileWithoutInputfile() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->outputfile('test-1920x1200.png')->getCommand();
	}

	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function inputfileAndOutputfile() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->outputfile('test-1920x1200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert "_data/demo.jpg" "./test-1920x1200.png"', $command);
	}


	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function background() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->background('red')->outputfile('test-1920x1200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -background "red" "_data/demo.jpg" "./test-1920x1200.png"', $command);
	}
	
	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function bordercolorWithColorName() {
		//You will not be able to see the border in the resulting image, as this test has no border argument.
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->borderColor('red')->outputfile('test-1920x1200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -bordercolor red "_data/demo.jpg" "./test-1920x1200.png"', $command);
	}
	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function bordercolorWithHexColor() {
		//You will not be able to see the border in the resulting image, as this test has no border argument.
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->borderColor('#666666')->outputfile('test-1920x1200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -bordercolor "#666666" "_data/demo.jpg" "./test-1920x1200.png"', $command);
	}
	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function bordercolorWithRgbColor() {
		//You will not be able to see the border in the resulting image, as this test has no border argument.
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->borderColor('rgb(255,255,255)')->outputfile('test-1920x1200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -bordercolor "rgb(255,255,255)" "_data/demo.jpg" "./test-1920x1200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function removeProfile() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->removeProfile('iptc')->outputfile('test-1920x1200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert +profile iptc "_data/demo.jpg" "./test-1920x1200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function testResample() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->resample(200, 200, 72, 72)->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -density 72x72  -resample \'200x200\' "_data/demo.jpg" "./test-200x200.png"', $command);
	}
	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function testResampleWithOnlyWidth() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->resample(200)->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -resample \'200\' "_data/demo.jpg" "./test-200x200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function testReset() {
		$karla = Karla::getInstance();
		$convert = $karla->convert();
		$convert->inputfile('_data/demo.jpg')->resample(200)->outputfile('test-200x200.png')->getCommand();
		$this->assertTrue($convert->isDirty());
		$convert->reset();
		$this->assertFalse($convert->isDirty());
	}

	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function testSize() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->size(200, 200)->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -size 200x200 "_data/demo.jpg" "./test-200x200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @return void
	 */
	public function testDensity() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->density()->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert "_data/demo.jpg" -density 72x72 "./test-200x200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function testFlatten() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->flatten()->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -flatten "_data/demo.jpg" "./test-200x200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function testStrip() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->strip()->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -strip "_data/demo.jpg" "./test-200x200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function testProfile() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->profile('_data/sRGB_Color_Space_Profile.icm')->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert "_data/demo.jpg" -profile "_data/sRGB_Color_Space_Profile.icm" "./test-200x200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function testChangeProfile() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')
			->changeProfile('_data/sRGB_Color_Space_Profile.icm', '_data/sRGB_Color_Space_Profile.icm')->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert "_data/demo.jpg" -profile "_data/sRGB_Color_Space_Profile.icm"   -profile "_data/sRGB_Color_Space_Profile.icm" "./test-200x200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function testLayers() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->layers('flatten')->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -layers flatten "_data/demo.jpg" "./test-200x200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function testResize() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->resize(100, 100)->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -resize 100x100\> "_data/demo.jpg" "./test-200x200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @test
	 * @return crop
	 */
	public function testCrop() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->crop(100, 100)->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -crop 100x100+0+0 +repage "_data/demo.jpg" "./test-200x200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function testQuality() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->crop(100, 100)->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -crop 100x100+0+0 +repage "_data/demo.jpg" "./test-200x200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @test
	 * @return void
	 */
	public function testColorspace() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->colorspace('rgb')->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert "_data/demo.jpg" -colorspace rgb "./test-200x200.png"', $command);
	}

	/**
	 * Test
	 *
	 * @todo Implement testGravity().
	 * @return void
	 */
	public function testGravity() {
		$karla = Karla::getInstance();
		$command = $karla->convert()->inputfile('_data/demo.jpg')->gravity('center')->outputfile('test-200x200.png')->getCommand();
		$this->assertEquals('export PATH=$PATH:/opt/local/bin/;convert -gravity center "_data/demo.jpg" "./test-200x200.png"', $command);
	}
}