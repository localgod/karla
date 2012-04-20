<?php
/**
 * Karla Imagemagick wrapper library demo file
 *
 * PHP Version 5.1.2
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 * @since    2012-04-05
 */

if (false === spl_autoload_functions()) {
	if (function_exists('__autoload')) {
		spl_autoload_register('__autoload', false);
	}
}
require_once '../src/Karla.php';
spl_autoload_register(array('Karla', 'autoload'));
/**
 * Demo class for Karla
 *
 * @category   Utility
 * @package    Karla
 * @subpackage Karla
 * @author     Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/localgod/Karla Karla
 */
class Demo {

	/**
	 * Clean path
	 * 
	 * @param string $path Path to Clean
	 * 
	 * @return string
	 */
	private function _cleanPath($path) {
		return str_replace(dirname(__FILE__), '', str_replace('export PATH=$PATH:/opt/local/bin/;', '', $path));
	}
	/**
	 * Generate examples
	 * 
	 * @return void
	 */
	public function examples() {
		$examples = array();
		$examples[] = $this->_example1();
		$examples[] = $this->_example2();
		$examples[] = $this->_example3();
		$examples[] = $this->_example4();
		$examples[] = $this->_example5();
		$examples[] = $this->_example6();
		$examples[] = $this->_example7();
		$examples[] = $this->_example8();
		$examples[] = $this->_example9();
		return $examples;
	}
	/**
	 * Example 1
	 * 
	 * @return array
	 */
	private function _example1() {
        $karla = Karla::getInstance();
        $basepath = dirname(__FILE__).DIRECTORY_SEPARATOR;
        $karla->convert()->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo.png')->execute();
        $cleanCommand = $this->_cleanPath($karla->convert()->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo.png')->getCommand());
		return array(
		'name' => 'Change format to png.', 
		'original' => 'demo.jpg', 
		'result' => 'demo.png',
		'code' => '$karla->convert()->inputfile("demo.jpg")->outputfile("demo.png")->execute();',
		'console' => $cleanCommand 
		);
	}
	/**
	 * Example 2
	 * 
	 * @return array
	 */
	private function _example2() {
        $karla = Karla::getInstance();
        $basepath = dirname(__FILE__).DIRECTORY_SEPARATOR;
        $karla->convert()->resize(100, 100)->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-100x100.jpg')->execute();
        $cleanCommand = $this->_cleanPath($karla->convert()->resize(100, 100)->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-100x100.jpg')->getCommand());
		return array(
		'name' => 'Resize image', 
		'original' => 'demo.jpg', 
		'result' => 'demo-100x100.jpg',
		'code' => '$karla->convert()->resize(100, 100)->inputfile("demo.jpg")->outputfile("demo-100x100.jpg")->execute();',
		'console' => $cleanCommand 
		);
	}
	/**
	 * Example 3
	 * 
	 * @return array
	 */
	private function _example3() {
        $karla = Karla::getInstance();
        $basepath = dirname(__FILE__).DIRECTORY_SEPARATOR;
        $karla->convert()->quality(10)->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-low.jpg')->execute();
        $cleanCommand = $this->_cleanPath($karla->convert()->quality(10)->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-low.jpg')->getCommand());
		return array(
		'name' => 'Change quality', 
		'original' => 'demo.jpg', 
		'result' => 'demo-low.jpg',
		'code' => '$karla->convert()->quality(10)->inputfile("demo.jpg")->outputfile("demo-low.jpg")->execute();',
		'console' => $cleanCommand 
		);
	}
	/**
	 * Example 4
	 * 
	 * @return array
	 */
	private function _example4() {
        $karla = Karla::getInstance();
        $basepath = dirname(__FILE__).DIRECTORY_SEPARATOR;
        $karla->convert()->crop(100, 100, 50, 50)->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-crop.jpg')->execute();
        $cleanCommand = $this->_cleanPath($karla->convert()->crop(100, 100, 50, 50)->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-crop.jpg')->getCommand());
		return array(
		'name' => 'Crop image', 
		'original' => 'demo.jpg', 
		'result' => 'demo-crop.jpg',
		'code' => '$karla->convert()->crop(100, 100, 50, 50)->inputfile("demo.jpg")->outputfile("demo-crop.jpg")->execute();',
		'console' => $cleanCommand 
		);
	}
	/**
	 * Example 5
	 * 
	 * @return array
	 */
	private function _example5() {
        $karla = Karla::getInstance();
        $basepath = dirname(__FILE__).DIRECTORY_SEPARATOR;
        $karla->convert()->flip()->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-flip.jpg')->execute();
        $cleanCommand = $this->_cleanPath($karla->convert()->flip()->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-flip.jpg')->getCommand());
		return array(
		'name' => 'Mirror image vertical', 
		'original' => 'demo.jpg', 
		'result' => 'demo-flip.jpg',
		'code' => '$karla->convert()->flip()->inputfile("demo.jpg")->outputfile("demo-flip.jpg")->execute();',
		'console' => $cleanCommand 
		);
	}
	/**
	 * Example 6
	 * 
	 * @return array
	 */
	private function _example6() {
        $karla = Karla::getInstance();
        $basepath = dirname(__FILE__).DIRECTORY_SEPARATOR;
        $karla->convert()->flop()->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-flop.jpg')->execute();
        $cleanCommand = $this->_cleanPath($karla->convert()->flop()->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-flop.jpg')->getCommand());
		return array(
		'name' => 'Mirror image horizontal', 
		'original' => 'demo.jpg', 
		'result' => 'demo-flop.jpg',
		'code' => '$karla->convert()->flop()->inputfile("demo.jpg")->outputfile("demo-flop.jpg")->execute();',
		'console' => $cleanCommand 
		);
	}
	/**
	 * Example 7
	 * 
	 * @return array
	 */
	private function _example7() {
        $karla = Karla::getInstance();
        $basepath = dirname(__FILE__).DIRECTORY_SEPARATOR;
        $karla->convert()->type('Grayscale')->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-grayscale.jpg')->execute();
        $cleanCommand = $this->_cleanPath($karla->convert()->type('Grayscale')->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-grayscale.jpg')->getCommand());
		return array(
		'name' => 'Grayscale image', 
		'original' => 'demo.jpg', 
		'result' => 'demo-grayscale.jpg',
		'code' => '$karla->convert()->type("Grayscale")->inputfile("demo.jpg")->outputfile("demo-grayscale.jpg")->execute();',
		'console' => $cleanCommand 
		);
	}
	/**
	 * Example 8
	 * 
	 * @return array
	 */
	private function _example8() {
        $karla = Karla::getInstance();
        $basepath = dirname(__FILE__).DIRECTORY_SEPARATOR;
        $karla->convert()->sepia(80)->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-sepia.jpg')->execute();
        $cleanCommand = $this->_cleanPath($karla->convert()->sepia(80)->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-sepia.jpg')->getCommand());
		return array(
		'name' => 'Sepia tone image', 
		'original' => 'demo.jpg', 
		'result' => 'demo-sepia.jpg',
		'code' => '$karla->convert()->sepia(80)->inputfile("demo.jpg")->outputfile("demo-sepia.jpg")->execute();',
		'console' => $cleanCommand 
		);
	}
	/**
	 * Example 9
	 * 
	 * @return array
	 */
	private function _example9() {
        $karla = Karla::getInstance();
        $basepath = dirname(__FILE__).DIRECTORY_SEPARATOR;
        $karla->convert()->polaroid(-10)->borderColor('"#ffffff"')->background('#000000')->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-polaroid.png')->execute();
        $cleanCommand = $this->_cleanPath(
        	$karla->convert()->polaroid(-10)->borderColor('"#ffffff"')->background('#000000')->inputfile($basepath.'demo.jpg')->outputfile($basepath.'demo-polaroid.png')->getCommand()
        );
		return array(
		'name' => 'Add polaroid effect to image', 
		'original' => 'demo.jpg', 
		'result' => 'demo-polaroid.png',
		'code' => '$karla->convert()->polaroid(-10)->borderColor("#ffffff")->background("#000000")->inputfile("demo.jpg")->outputfile("demo-polaroid.png")->execute();', 
		'console' => $cleanCommand 
		);
	}
}
