<?php

/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 8.0<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */

declare(strict_types=1);

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
    public string $binPath;

    /**
     * Name of binary
     *
     * @var string
     */
    protected string $bin;

    /**
     * Cache controller
     *
     * @var Cache
     */
    protected Cache|null $cache;

    /**
     * The current query
     *
     * @var Query
     */
    private Query $query;

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
    final public function __construct(string $binPath, string $bin, \Karla\Cache|null $cache = null)
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
    public function getQuery(): Query
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
    public function setQuery(Query $query): void
    {
        $this->query = $query;
    }

    /**
     * It should not be possible to clon the ImageMagick object.
     *
     * @return void
     */
    final public function __clone(): void
    {
        throw new \BadMethodCallException("Clone is not allowed");
    }

    /**
     * Get the command to run
     *
     * @return string
     */
    public function getCommand(): string
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
    public function execute(bool $reset = true): string|object
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
     * @return self
     */
    public function raw(string $arguments, bool $input = true): self
    {
        if ($input) {
            $this->getQuery()->setInputOption($arguments);
        } else {
            $this->getQuery()->setOutputOption($arguments);
        }
        return $this;
    }

    /**
     * Check if the input is a valid ImageMagick program
     *
     * @param string $program
     *            Program name
     *
     * @return boolean
     */
    final public static function validProgram(string $program): bool
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
