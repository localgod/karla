<?php

/**
 * Karla Imagemagick wrapper library
 *
 * PHP Version 8.0<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2010-06-05
 */

declare(strict_types=1);

namespace Karla;

/**
 * Karla core class
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
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
    private string $binPath;

    /**
     * Cache controller
     *
     * @var Cache
     */
    private Cache|null $cache;

    /**
     * ImageMagick major version
     *
     * @var int|null
     */
    private int|null $version = null;

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
     * @param Cache|null $cache
     *            Cache controller (optional)
     *
     * @return Karla
     * @throws \InvalidArgumentException
     */
    public static function perform(string $binPath = '/opt/local/bin/', Cache|null $cache = null): Karla
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
    private function __construct(string $binPath, Cache|null $cache)
    {
        if (! file_exists($binPath)) {
            throw new \InvalidArgumentException('Bin path not found');
        }

        // Detect ImageMagick version - try both v6 (convert) and v7 (magick)
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) == "WIN";
        $magickBin = $isWindows ? 'magick.exe' : 'magick';
        $convertBin = $isWindows ? 'convert.exe' : 'convert';
        
        $versionOutput = '';
        
        // Try ImageMagick 7 first (magick command)
        if (file_exists($binPath . $magickBin)) {
            $versionOutput = shell_exec($binPath . $magickBin . ' -version');
            if ($versionOutput && stripos($versionOutput, 'ImageMagick') !== false) {
                // Extract major version (e.g., "Version: ImageMagick 7.1.2" -> 7)
                if (preg_match('/ImageMagick (\d+)/', $versionOutput, $matches)) {
                    $this->version = (int)$matches[1];
                }
            }
        }
        
        // Fallback to ImageMagick 6 (convert command)
        if (empty($versionOutput) && file_exists($binPath . $convertBin)) {
            $versionOutput = shell_exec($binPath . $convertBin . ' -version');
            if ($versionOutput && stripos($versionOutput, 'ImageMagick') !== false) {
                if (preg_match('/ImageMagick (\d+)/', $versionOutput, $matches)) {
                    $this->version = (int)$matches[1];
                } else {
                    $this->version = 6; // Assume v6 if version not found but convert exists
                }
            }
        }
        
        if (empty($versionOutput)) {
            throw new \InvalidArgumentException('ImageMagick could not be located at specified path');
        }
        
        // Set binPath appropriately for the OS
        if (strtoupper(substr(PHP_OS, 0, 3)) == "WIN") {
            // On Windows, just use the direct path
            $this->binPath = rtrim($binPath, '/\\') . '/';
        } else {
            // On Unix, use export PATH
            $this->binPath = 'export PATH=$PATH:' . $binPath . ';';
        }
        
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
    public function raw(string $program, string $arguments = ""): string
    {
        if (! Program\ImageMagick::validProgram($program)) {
            throw new \InvalidArgumentException('ImageMagick could not be located at specified path');
        }
        strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ? $bin = $program . '.exe' : $bin = $program;

        // For ImageMagick 7+, prepend with magick command
        if ($this->version !== null && $this->version >= 7) {
            $magickBin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ? 
                Program\ImageMagick::IMAGEMAGICK_MAGICK . '.exe' : Program\ImageMagick::IMAGEMAGICK_MAGICK;
            $result = shell_exec($this->binPath . $magickBin . ' ' . $program . ' ' . $arguments);
        } else {
            $result = shell_exec($this->binPath . $bin . ' ' . $arguments);
        }

        return $result !== null ? $result : '';
    }

    /**
     * Start a convert operation
     *
     * @return Program\Convert
     */
    public function convert(): Program\Convert
    {
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ?
            Program\ImageMagick::IMAGEMAGICK_CONVERT . '.exe' : Program\ImageMagick::IMAGEMAGICK_CONVERT;

        return new Program\Convert($this->binPath, $bin, $this->cache, $this->version);
    }

    /**
     * Start a identify operation
     *
     * @return Program\Identify
     */
    public function identify(): Program\Identify
    {
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ?
            Program\ImageMagick::IMAGEMAGICK_IDENTIFY . '.exe' : Program\ImageMagick::IMAGEMAGICK_IDENTIFY;

        return new Program\Identify($this->binPath, $bin, $this->cache, $this->version);
    }

    /**
     * Start a composite operation
     *
     * @return Program\Composite
     */
    public function composite(): Program\Composite
    {
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ?
            Program\ImageMagick::IMAGEMAGICK_COMPOSITE . '.exe' : Program\ImageMagick::IMAGEMAGICK_COMPOSITE;

        return new Program\Composite($this->binPath, $bin, $this->cache, $this->version);
    }
}
