<?php
/**
 * Karla Imagemagick wrapper library
 *
 * PHP Version 5.1.2
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @version  SVN: <1>
 * @link     http://www.greenoak.dk/ GreenOak
 * @since    2010-06-05
 */
/**
 * Karla core class
 *
 * @category   Utility
 * @package    Karla
 * @subpackage Karla
 * @author     Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       http://karla.greenoak.dk/ Karla
 */
class Karla
{
    /**
     * Path to Karla root directory
     *
     * @var string $path Karla root directory
     */
    private static $_path;
    /**
     * Path to imagemagick binary
     *
     * @var string $_binPath imagemagick binary
     */
    private $_binPath;
    /**
     * Cache controller
     * @var Cache
     */
    private $_cache;
    /**
     * Instance of a imagmagick object.
     *
     * @var Karla $_instance imagmagick object.
     */
    private static $_instance;
    /**
     * Get a instance of Karla.
     *
     * @param string $binPath Path to imagemagic binaries (optional)
     * @param Cache  $cache   Cache controller (optional)
     *
     * @return Karla
     */
    public static function getInstance($binPath = '/opt/local/bin/', Cache $cache = null)
    {
        if (!(self::$_instance instanceof self)) {
            try {
                self::$_instance = new self($binPath, $cache);
            } catch (InvalidArgumentException $e) {
                exit($e->getMessage().'('.$binPath.')');
            }
        }

        return self::$_instance;
    }

    /**
     * Autoload function
     *
     * @param string $className Name of the class to load
     *
     * @return boolean true if the class was loaded, otherwise false
     */
    public static function autoload($className)
    {
        if (class_exists($className, false) || interface_exists($className, false)) {
            return false;
        }
        $class = self::getPath() .DIRECTORY_SEPARATOR . __CLASS__ .
        DIRECTORY_SEPARATOR. str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if (file_exists($class)) {
            require_once $class;

            return true;
        }

        return false;
    }

    /**
     * Get the root path to Karla
     *
     * @return string
     */
    public static function getPath()
    {
        if (!self::$_path) {
            self::$_path = dirname(__FILE__);
        }

        return self::$_path;
    }

    /**
     * Construct a new Karla object.
     *
     * @param string $binPath Path to imagemagic binaries
     * @param Cache  $cache   Cache controller
     *
     * @return void
     * @throws InvalidArgumentException if path for imagemagick is invalid
     */
    private function __construct($binPath, $cache)
    {
        if (!file_exists($binPath)) {
            throw new InvalidArgumentException('Bin path not found');
        }

        if (shell_exec($binPath . 'convert -version | grep ImageMagick') == "") {
            throw new InvalidArgumentException('ImageMagick could not be located at specified path');
        }
        $this->_binPath = 'export PATH=$PATH:'.$binPath.';';
        $this->_cache = $cache;
    }
    /**
     * Run a raw ImageMagick command
     *
     * Karla was never intended to wrap all of the functionality of ImageMagick
     * and likely never will, you will from time to time need to write arguments to
     * ImageMagick like you would have done directly in the consol.
     *
     * @param string $program   Imagemagick tool to use
     * @param string $arguments Arguments for the tool
     *
     * @return string                   Result of the command if any
     * @throws InvalidArgumentException if you try to run a non ImageMagick prohram
     */
    public function raw($program, $arguments = "")
    {
        if (!ImageMagick::validProgram($program)) {
            throw new InvalidArgumentException('ImageMagick could not be located at specified path');
        }
        strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ? $bin = $program.'.exe' : $bin = $program;

        return shell_exec($this->_binPath.$bin.' '.$arguments);
    }
    /**
     * Start a convert operation
     *
     * @return Convert
     */
    public function convert()
    {
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ? 
        	ImageMagick::IMAGEMAGICK_CONVERT.'.exe' : ImageMagick::IMAGEMAGICK_CONVERT;

        return new Convert($this->_binPath, $bin, $this->_cache);
    }

    /**
     * Start a identify operation
     *
     * @return Identify
     */
    public function identify()
    {
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ? 
        	ImageMagick::IMAGEMAGICK_IDENTIFY.'.exe' : ImageMagick::IMAGEMAGICK_IDENTIFY;

        return new Identify($this->_binPath, $bin, $this->_cache);
    }
    /**
     * Start a composite operation
     *
     * @return Composite
     */
    public function composite()
    {
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ? 
        	ImageMagick::IMAGEMAGICK_COMPOSITE.'.exe' : ImageMagick::IMAGEMAGICK_COMPOSITE;

        return new Composite($this->_binPath, $bin, $this->_cache);
    }

    /**
     * Create a background image
     *
     * @param integer $width    Background image width
     * @param integer $height   Background image height
     * @param string  $color    Background image color
     * @param string  $savePath Image save path
     *
     * @return string - path to generated image
     */
    public function createBackgroundImage($width, $height, $color, $savePath = '')
    {
        if ($savePath == '') {
            $path = dirname(__FILE__).DIRECTORY_SEPARATOR.'tempback.png';
        } else {
            $pathinfo = pathinfo($savePath);
            if (!file_exists($pathinfo['dirname'])) {
                $message = 'The output file path (' . $pathinfo['dirname'] .
                       ') is invalid or could not be located.';
                throw new InvalidArgumentException($message);
            }

            $path = ' "' . $file->getPathname() . '/' . $pathinfo['basename'] . '" ';
        }

        echo $this->convert()->size($width, $height)->background($color)->outputfile($path)->execute();

        return $path;
    }
}
