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
 * Class for wrapping ImageMagicks identify tool
 *
 * @category   Utility
 * @package    Karla
 * @subpackage Karla
 * @author     Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/localgod/Karla Karla
 */
class Identify extends ImageMagick
{
	/**
	 * Input file
	 * @var string
	 */
	protected $inputFile;

	/**
	 * Add input argument
	 *
	 * @param string $filePath Input file path
	 *
	 * @return Identify
	 * @throws InvalidArgumentException
	 */
	public function inputfile($filePath)
	{
		if (!file_exists($filePath)) {
			$message = 'The input file path (' .
			$filePath . ') is invalid or the file could not be located.';
			throw new InvalidArgumentException($message);
		}
		$file = new SplFileObject($filePath);
		if ($file->isReadable()) {
			$this->inputFile = '"' . $file->getPathname() . '"';
		}
		$this->dirty();
		return $this;
	}

	/**
	 * Execute the command
	 *
	 * @param boolean $reset Reset the query
	 * @param boolean $raw   Get the raw output
	 *
	 * @see lib/Imagemagick#execute()
	 * @return string|MetaData
	 */
	public function execute($reset = true, $raw = true)
	{
		$result = parent::execute();
		if ($reset) {
			$this->reset();
		}
		if (!$raw) {
			return new MetaData($result);
		}
		return trim($result);
	}
	/**
	 * Add verbose argument
	 *
	 * @return Identify
	 */
	public function verbose()
	{
		if (!$this->isOptionSet('verbose', $this->inputOptions)) {
			$this->inputOptions[] = "-verbose ";
		}
		$this->dirty();
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see lib/Imagemagick#getCommand()
	 * @return string
	 */
	public function getCommand()
	{
		!is_array($this->inputOptions) ? $this->inputOptions = array() : null;
		$options = $this->prepareOptions($this->inputOptions) == '' ? '' : $this->prepareOptions($this->inputOptions).' ';

		return $this->binPath.$this->bin . ' ' . $options . $this->inputFile;
	}

	/**
	 * Set the gravity
	 *
	 * Gravity has no effect when used in this context
	 *
	 * @param string $gravity Gravity
	 *
	 * @return Identify
	 */
	public function gravity($gravity)
	{
		return $this;
	}
}