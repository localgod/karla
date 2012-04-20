<?php
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 * @since    2012-04-05
 */
/**
 * Class for file caching
 *
 * @category   Utility
 * @package    Karla
 * @subpackage Karla
 * @author     Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/localgod/Karla Karla
 */
class FileCache implements Cache {
	/**
	 * Cache directory
	 * @var string
	 */
	private $_cacheDir;

	/**
	 * Create a new file cache
	 *
	 * @param string $dirName Path to cach directory
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct($dirName) {
		$this->_setCacheDir($dirName);
	}
	/**
	 * Create a path based on the option array
	 *
	 * @param array $options List of options
	 *
	 * @return string the created path
	 * @throws InvalidArgumentException
	 */
	private function _options2Path(array $options) {
		if (!is_array($options)) {
			throw new InvalidArgumentException("options argument must be an array");
		}
		return "";
	}
	/**
	 * Set the cache directory
	 *
	 * @param string $dirName Path to the cache directory
	 *
	 * @return void
	 * @throws InvalidArgumentException if path was not found
	 * @throws InvalidArgumentException if path was not writeable
	 * @throws InvalidArgumentException if path was a directoy
	 */
	private function _setCacheDir($dirName) {
		if (!file_exists($dirName)) {
			throw new InvalidArgumentException("Path not found", 0);
		}
		if (!is_writeable($dirName)) {
			throw new InvalidArgumentException("Path not writable", 1);
		}
		if (!is_dir($dirName)) {
			throw new InvalidArgumentException("Path not a directory", 2);
		}
		$this->_cacheDir = $dirName;
	}

	/**
	 * Check if there exists a cached version of the file
	 *
	 * @param string $filename Path to file
	 * @param string $options  Options
	 *
	 * @return void
	 */
	public function isCached($filename, $options) {
		return file_exists($filename, $options);
	}
	/**
	 * Get cached version of the file
	 *
	 * @param string $filename Path to file
	 * @param string $options  Options
	 *
	 * @return string
	 */
	public function getCached($filename, $options) {
		//TODO implement
	}

	/**
	 * Set cached version of the file
	 *
	 * @param string $filename Path to file
	 * @param string $options  Options
	 *
	 * @return void
	 */
	public function setCache($filename, $options) {
		//TODO implement
	}

	/**
	 * Set cached version of the file
	 *
	 * @param string $filename Path to file
	 * @param string $options  Options
	 *
	 * @return void
	 */
	public function removeOrphans($filename, $options) {
		//TODO implement
	}

	/**
	 * Create a string representation of the options used
	 *
	 * Include in a the output filename which can be handy for caching.
	 *
	 * @return string
	 */
	protected function options2String() {
		$output = array();
		foreach ($this->_inputOptions as $option) {
			if (strstr($option, 'resize')) {
				$option = str_replace('\>', '', $option);
				$option = str_replace('\<', '', $option);
			}
			if (strstr($option, 'crop')) {
				$option = str_replace(' +repage', '', $option);
			}
			$option = trim($option);
			$option = str_replace(' ', '_', $option);
			$option = str_replace('-', '', $option);
			$output[] = $option;
		}
		return '#'.implode('#', $output);
	}
}