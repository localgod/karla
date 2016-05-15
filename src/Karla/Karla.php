<?php
/**
 * Karla Imagemagick wrapper library
 *
 * PHP Version 5.3<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2010-06-05
 */
namespace Karla;

/**
 * Karla core class
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Karla
{
    /**
     * Path to imagemagick binary
     *
     * @var string $binPath imagemagick binary
     */
    private $binPath;

    /**
     * Cache controller
     *
     * @var Cache
     */
    private $cache;

    /**
     * Instance of a imagmagick object.
     *
     * @var Karla $instance imagmagick object.
     */
    private static $instance;

    /**
     * Get a instance of Karla.
     *
     * @param string $binPath
     *            Path to imagemagic binaries (optional)
     * @param Cache $cache
     *            Cache controller (optional)
     *
     * @return Karla
     * @throws \InvalidArgumentException
     */
    public static function perform($binPath = '/opt/local/bin/', Cache $cache = null)
    {
        if (! (Karla::$instance instanceof Karla)) {
            try {
                Karla::$instance = new Karla($binPath, $cache);
            } catch (\InvalidArgumentException $e) {
                throw new \RuntimeException($e->getMessage() . '(' . $binPath . ')');
            }
        }

        return Karla::$instance;
    }

    /**
     * Construct a new Karla object.
     *
     * @param string $binPath
     *            Path to imagemagic binaries
     * @param Cache $cache
     *            Cache controller
     *
     * @throws \InvalidArgumentException if path for imagemagick is invalid
     */
    private function __construct($binPath, $cache)
    {
        if (! file_exists($binPath)) {
            throw new \InvalidArgumentException('Bin path not found');
        }

        if (shell_exec($binPath . 'convert -version | grep ImageMagick') == "") {
            throw new \InvalidArgumentException('ImageMagick could not be located at specified path');
        }
        $this->binPath = 'export PATH=$PATH:' . $binPath . ';';
        $this->cache = $cache;
    }

    /**
     * Run a raw ImageMagick command
     *
     * Karla was never intended to wrap all of the functionality of ImageMagick
     * and likely never will, you will from time to time need to write arguments
     * to ImageMagick like you would have done directly in the consol.
     *
     * @param string $program
     *            Imagemagick tool to use
     * @param string $arguments
     *            Arguments for the tool
     *
     * @return string Result of the command if any
     * @throws \InvalidArgumentException if you try to run a non ImageMagick program
     */
    public function raw($program, $arguments = "")
    {
        if (! Program\ImageMagick::validProgram($program)) {
            throw new \InvalidArgumentException('ImageMagick could not be located at specified path');
        }
        strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ? $bin = $program . '.exe' : $bin = $program;

        return shell_exec($this->binPath . $bin . ' ' . $arguments);
    }

    /**
     * Start a convert operation
     *
     * @return Program\Convert
     */
    public function convert()
    {
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ?
            Program\ImageMagick::IMAGEMAGICK_CONVERT . '.exe' : Program\ImageMagick::IMAGEMAGICK_CONVERT;

        return new Program\Convert($this->binPath, $bin, $this->cache);
    }

    /**
     * Start a identify operation
     *
     * @return Program\Identify
     */
    public function identify()
    {
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ?
            Program\ImageMagick::IMAGEMAGICK_IDENTIFY . '.exe' : Program\ImageMagick::IMAGEMAGICK_IDENTIFY;

        return new Program\Identify($this->binPath, $bin, $this->cache);
    }

    /**
     * Start a composite operation
     *
     * @return Program\Composite
     */
    public function composite()
    {
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ?
            Program\ImageMagick::IMAGEMAGICK_COMPOSITE . '.exe' : Program\ImageMagick::IMAGEMAGICK_COMPOSITE;

        return new Program\Composite($this->binPath, $bin, $this->cache);
    }
}
