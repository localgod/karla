<?php
namespace Karla\Program;
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5.3
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 * @since    2012-04-05
 */
/**
 * Class for wrapping ImageMagick arguments used by all tools
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 */
abstract class ImageMagick implements \Karla\Program
{

    /**
     * ImageMagick tool animate
     *
     * @var string
     */
    const IMAGEMAGICK_ANIMATE = 'animate';

    /**
     * ImageMagick tool compare
     *
     * @var string
     */
    const IMAGEMAGICK_COMPARE = 'compare';

    /**
     * ImageMagick tool composite
     *
     * @var string
     */
    const IMAGEMAGICK_COMPOSITE = 'composite';

    /**
     * ImageMagick tool
     *
     * @var string
     */
    const IMAGEMAGICK_CONJURE = 'conjure';

    /**
     * ImageMagick tool conjure
     *
     * @var string
     */
    const IMAGEMAGICK_CONVERT = 'convert';

    /**
     * ImageMagick tool display
     *
     * @var string
     */
    const IMAGEMAGICK_DISPLAY = 'display';

    /**
     * ImageMagick tool identify
     *
     * @var string
     */
    const IMAGEMAGICK_IDENTIFY = 'identify';

    /**
     * ImageMagick tool import
     *
     * @var string
     */
    const IMAGEMAGICK_IMPORT = 'import';

    /**
     * ImageMagick tool mogrify
     *
     * @var string
     */
    const IMAGEMAGICK_MOGRIFY = 'mogrify';

    /**
     * ImageMagick tool montage
     *
     * @var string
     */
    const IMAGEMAGICK_MONTAGE = 'montage';

    /**
     * ImageMagick tool stream
     *
     * @var string
     */
    const IMAGEMAGICK_STREAM = 'stream';

    /**
     * Input option
     *
     * @var Array
     */
    protected $inputOptions;

    /**
     * Output option
     *
     * @var Array
     */
    protected $outputOptions;

    /**
     * Path to binaries
     *
     * @var string
     */
    protected $binPath;

    /**
     * Name of binary
     *
     * @var string
     */
    protected $bin;

    /**
     * Cache controller
     *
     * @var Cache
     */
    protected $cache;

    /**
     * Is the object dirty (has any arguments been set)
     *
     * @var boolean
     */
    private $dirty;

    /**
     * Contructs a new program
     *
     * @param string $binPath
     *            Path to binaries
     * @param string $bin
     *            Binary
     * @param Cache $cache
     *            Cache controller (default null = no cache)
     *
     * @return void
     * @throws InvalidArgumentException
     */
    final public function __construct($binPath, $bin, $cache = null)
    {
        if ($binPath == '') {
            throw new \InvalidArgumentException('Invalid bin path');
        }
        if ($bin == '') {
            throw new \InvalidArgumentException('Invalid bin');
        }
        $this->binPath = $binPath;
        $this->bin = $bin;
        $this->cache = $cache;
        $this->reset();
    }

    /**
     * Is the object dirty
     *
     * (has any arguments been set)
     *
     * @return boolean
     */
    public function isDirty()
    {
        return $this->dirty;
    }

    /**
     * Set the object as beeing dirty
     *
     * (Arguments has been set)
     *
     * @return void
     */
    protected function dirty()
    {
        $this->dirty = true;
    }

    /**
     * It should not be possible to clon the ImageMagick object.
     *
     * @return void
     */
    final public function __clone()
    {
        throw new \BadMethodCallException("Clone is not allowed");
    }

    /**
     * Get the command to run
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->binPath . $this->bin;
    }

    /**
     * Execute the command
     *
     * @param boolean $reset
     *            Reset the query
     *
     * @return string
     */
    public function execute($reset = true)
    {
        $result = shell_exec($this->getCommand());
        if ($reset) {
            $this->reset();
        }

        return $result;
    }

    /**
     * Reset the command
     *
     * @return void
     */
    public function reset()
    {
        $this->inputOptions = array();
        $this->outputOptions = array();
        $this->dirty = false;
    }

    /**
     * Raw arguments directly to ImageMagick
     *
     * @param string $arguments
     *            Arguments
     * @param boolean $input
     *            Defaults to an input option, use false to use it as an output option
     *
     * @return void
     */
    public function raw($arguments, $input = true)
    {
        if ($input) {
            $this->inputOptions[] = $arguments;
        } else {
            $this->outputOptions[] = $arguments;
        }
    }

    /**
     * Set the gravity
     *
     * @param string $gravity
     *            Gravity
     *
     * @return ImageMagick
     */
    public function gravity($gravity)
    {
        if ($this->isOptionSet('gravity', $this->inputOptions)) {
            throw new \BadMethodCallException('Gravity can only be called once.');
        }
        if ($this->supportedGravity($gravity)) {
            $this->inputOptions[] = " -gravity " . $gravity;
            $this->dirty();

            return $this;
        }
    }

    /**
     * Set the density of the output image.
     *
     * @param integer $width
     *            The width of the image
     * @param integer $height
     *            The height of the image
     * @param boolean $output
     *            If output is true density is set for the resulting image
     *            If output is false density is used for reading the input image
     *
     * @return Convert
     * @throws BadMethodCallException if density has already been called
     * @throws InvalidArgumentException
     */
    public function density($width = 72, $height = 72, $output = true)
    {
        if ($this->isOptionSet('density', $this->inputOptions)) {
            $message = "'density()' can only be called once as in input argument.";
            throw new \BadMethodCallException($message);
        }
        if ($this->isOptionSet('density', $this->outputOptions)) {
            $message = "'density()' can only be called once as in input argument.";
            throw new \BadMethodCallException($message);
        }
        if (! is_numeric($width)) {
            $message = 'Width must be numeric values in the density method';
            throw new \InvalidArgumentException($message);
        }
        if (! is_numeric($width)) {
            $message = 'Height must be numeric values in the density method';
            throw new \InvalidArgumentException($message);
        }
        if ($output) {
            $this->outputOptions[] = " -density " . $width . "x" . $height;
        } else {
            $this->inputOptions[] = " -density " . $width . "x" . $height;
        }
        $this->dirty();

        return $this;
    }

    /**
     * Prepare option collection
     *
     * @param array $options
     *            Options
     *
     * @return string
     */
    final protected function prepareOptions(array $options)
    {
        $options = implode(' ', $options);
        if (trim($options) == '') {
            return '';
        }

        return trim($options);
    }

    /**
     * Check if an option is already set
     *
     * @param string $lookop
     *            Option to look up
     * @param array $optionList
     *            Optionlist to look in
     *
     * @return boolean
     */
    final protected function isOptionSet($lookop, array $optionList)
    {
        foreach ($optionList as $option) {
            if (strstr($option, $lookop)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a colorspace is supported by ImageMagick.
     *
     * @param string $colorSpace
     *            Colorspace to check
     *
     * @return boolean
     */
    final protected function supportedColorSpace($colorSpace)
    {
        if (! ($this instanceof Convert) && ! ($this instanceof Identify)) {
            throw new \BadMethodCallException('This method can not be used in this context');
        }
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ?
            ImageMagick::IMAGEMAGICK_CONVERT . '.exe' : ImageMagick::IMAGEMAGICK_CONVERT;
        $colorspaces = shell_exec($this->binPath . $bin . ' -list colorspace');
        $colorspaces = explode("\n", $colorspaces);
        for ($i = 0; $i < count($colorspaces); $i ++) {
            $colorspaces[$i] = trim(strtolower($colorspaces[$i]));
        }

        return in_array(strtolower(trim($colorSpace)), $colorspaces);
    }

    /**
     * Check if a image type is supported by ImageMagick.
     *
     * @param string $type
     *            Type to check
     *
     * @return boolean
     */
    final protected function supportedImageTypes($type)
    {
        if (! ($this instanceof Convert) && ! ($this instanceof Identify)) {
            throw new \BadMethodCallException('This method can not be used in this context');
        }
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ?
            ImageMagick::IMAGEMAGICK_CONVERT . '.exe' : ImageMagick::IMAGEMAGICK_CONVERT;
        $types = shell_exec($this->binPath . $bin . ' -list type');
        $types = explode("\n", $types);
        for ($i = 0; $i < count($types); $i ++) {
            $types[$i] = trim(strtolower($types[$i]));
        }

        return in_array(strtolower(trim($type)), $types);
    }

    /**
     * Check if a gravity is supported by ImageMagick.
     *
     * @param string $gravity
     *            Gravity to check
     *
     * @return boolean
     * @throws BadMethodCallException if called in a wrong context
     */
    final protected function supportedGravity($gravity)
    {
        if (! ($this instanceof Convert) && ! ($this instanceof Composite)) {
            throw new \BadMethodCallException('This method can not be used in this context');
        }
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ?
            ImageMagick::IMAGEMAGICK_CONVERT . '.exe' : ImageMagick::IMAGEMAGICK_CONVERT;
        $gravities = shell_exec($this->binPath . $bin . ' -list gravity');
        $gravities = explode("\n", $gravities);
        for ($i = 0; $i < count($gravities); $i ++) {
            $gravities[$i] = trim(strtolower($gravities[$i]));
        }

        return in_array(strtolower(trim($gravity)), $gravities);
    }

    /**
     * Check if a method is supported by ImageMagick.
     *
     * @param string $method
     *            Method to check
     *
     * @return boolean
     * @throws BadMethodCallException if called in a wrong context
     */
    final protected function supportedLayerMethod($method)
    {
        if (! ($this instanceof Convert) && ! ($this instanceof Identify)) {
            throw new \BadMethodCallException('This method can not be used in this context');
        }
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ?
            ImageMagick::IMAGEMAGICK_CONVERT . '.exe' : ImageMagick::IMAGEMAGICK_CONVERT;
        $methods = shell_exec($this->binPath . $bin . ' -list layers');
        $methods = explode("\n", $methods);
        for ($i = 0; $i < count($methods); $i ++) {
            $methods[$i] = trim(strtolower($methods[$i]));
        }

        return in_array(strtolower(trim($method)), $methods);
    }

    /**
     * Check if a format is supported by ImageMagick.
     *
     * @param string $format
     *            Format to check
     *
     * @return boolean
     * @throws BadMethodCallException if called in a wrong context
     */
    final protected function supportedFormat($format)
    {
        if (! ($this instanceof Convert) && ! ($this instanceof Identify)) {
            throw new \BadMethodCallException('This method can not be used in this context');
        }
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ?
            ImageMagick::IMAGEMAGICK_CONVERT . '.exe' : ImageMagick::IMAGEMAGICK_CONVERT;
        $formats = shell_exec($this->binPath . $bin . ' -list format');
        $formats = explode("\n", $formats);
        for ($i = 0; $i < count($formats); $i ++) {
            preg_match("/^[\s]*[A-Z0-9]+/", $formats[$i], $matches);
            if (isset($matches[0])) {
                if (! strpos($matches[0], 'Format')) {
                    $formats[$i] = strtolower(trim($matches[0]));
                }
            }
        }

        return in_array(strtolower(trim($format)), $formats);
    }

    /**
     * Check if the input is a valid ImageMagick program
     *
     * @param string $program
     *            Program name
     *
     * @return boolean
     */
    final public static function validProgram($program)
    {
        $class = new \ReflectionClass(__CLASS__);
        $constants = $class->getConstants();
        foreach ($constants as $constant) {
            if ($constant == $program) {
                return true;
            }
        }

        return false;
    }
}
