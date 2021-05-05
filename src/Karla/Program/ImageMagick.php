<?php

/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 7.4<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */

declare(strict_types = 1);
namespace Karla\Program;

use Karla\Query;
use Karla\Cache;

/**
 * Class for wrapping ImageMagick arguments used by all tools
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
abstract class ImageMagick implements \Karla\Program
{

    /**
     * ImageMagick tool animate
     *
     * @var string
     */
    public const IMAGEMAGICK_ANIMATE = 'animate';

    /**
     * ImageMagick tool compare
     *
     * @var string
     */
    public const IMAGEMAGICK_COMPARE = 'compare';

    /**
     * ImageMagick tool composite
     *
     * @var string
     */
    public const IMAGEMAGICK_COMPOSITE = 'composite';

    /**
     * ImageMagick tool
     *
     * @var string
     */
    public const IMAGEMAGICK_CONJURE = 'conjure';

    /**
     * ImageMagick tool conjure
     *
     * @var string
     */
    public const IMAGEMAGICK_CONVERT = 'convert';

    /**
     * ImageMagick tool display
     *
     * @var string
     */
    public const IMAGEMAGICK_DISPLAY = 'display';

    /**
     * ImageMagick tool identify
     *
     * @var string
     */
    public const IMAGEMAGICK_IDENTIFY = 'identify';

    /**
     * ImageMagick tool import
     *
     * @var string
     */
    public const IMAGEMAGICK_IMPORT = 'import';

    /**
     * ImageMagick tool mogrify
     *
     * @var string
     */
    public const IMAGEMAGICK_MOGRIFY = 'mogrify';

    /**
     * ImageMagick tool montage
     *
     * @var string
     */
    public const IMAGEMAGICK_MONTAGE = 'montage';

    /**
     * ImageMagick tool stream
     *
     * @var string
     */
    public const IMAGEMAGICK_STREAM = 'stream';

    /**
     * Path to binaries
     *
     * @var string
     */
    public $binPath;

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
     * The current query
     *
     * @var Query
     */
    private $query;

    /**
     * Contructs a new program
     *
     * @param string $binPath
     *            Path to binaries
     * @param string $bin
     *            Binary
     * @param \Karla\Cache|null $cache
     *            Cache controller (default null = no cache)
     *
     * @throws \InvalidArgumentException
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
        $this->query = new Query();
        $this->getQuery()->reset();
    }

    /**
     * Get the current query
     *
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set the current query
     *
     * @param Query $query
     *            Query to set
     *
     * @return void
     */
    public function setQuery(Query $query)
    {
        $this->query = $query;
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
            $this->getQuery()->reset();
        }

        return $result;
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
            $this->getQuery()->setInputOption($arguments);
        } else {
            $this->getQuery()->setOutputOption($arguments);
        }
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
