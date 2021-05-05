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
namespace Karla\Cache;

/**
 * Class for file caching
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class File implements \Karla\Cache
{

    /**
     * Cache directory
     *
     * @var string
     */
    private $cacheDir;

    /**
     * Create a new file cache
     *
     * @param string $dirName
     *            Path to cach directory
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($dirName)
    {
        $this->setCacheDir($dirName);
    }

    /**
     * Set the cache directory
     *
     * @param string $dirName
     *            Path to the cache directory
     *
     * @return void
     * @throws \InvalidArgumentException if path was not found
     * @throws \InvalidArgumentException if path was not writeable
     * @throws \InvalidArgumentException if path was a directoy
     */
    private function setCacheDir($dirName)
    {
        if (! file_exists($dirName)) {
            throw new \InvalidArgumentException("Path not found", 0);
        }
        if (! is_writeable($dirName)) {
            throw new \InvalidArgumentException("Path not writable", 1);
        }
        if (! is_dir($dirName)) {
            throw new \InvalidArgumentException("Path not a directory", 2);
        }
        $this->cacheDir = $dirName;
    }

    /**
     * Create a string representation of the options used
     *
     * @param string[] $options
     *            Options
     *
     * @return string
     */
    private function options2string($options)
    {
        $output = array();
        foreach ($options as $option) {
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
        return implode('&', $output);
    }

    /**
     * Generate cache name
     *
     * @param string $inputFile
     *            Path to file
     * @param string $outputFile
     *            Path to file
     * @param string[] $options
     *            Options
     *
     * @return boolean
     */
    private function cacheName($inputFile, $outputFile, $options)
    {
        $inputFile = str_replace('"', '', $inputFile);
        $outputFile = str_replace('"', '', $outputFile);
        $ext = pathinfo(basename($outputFile), PATHINFO_EXTENSION);
        $filename = $inputFile . $this->options2string($options);
        return $this->cacheDir . '/' . md5($filename) . '.' . $ext;
    }

    /**
     * Check if there exists a cached version of the file
     *
     * @param string $inputFile
     *            Path to file
     * @param string $outputFile
     *            Path to file
     * @param string[] $options
     *            Options
     *
     * @return boolean
     */
    public function isCached($inputFile, $outputFile, $options)
    {
        $filename = $this->cacheName($inputFile, $outputFile, $options);
        return file_exists($filename);
    }

    /**
     * Get cached version of the file
     *
     * @param string $inputFile
     *            Path to file
     * @param string $outputFile
     *            Path to file
     * @param string[] $options
     *            Options
     *
     * @return string
     */
    public function getCached($inputFile, $outputFile, $options)
    {
        return $this->cacheName($inputFile, $outputFile, $options);
    }

    /**
     * Set cached version of the file
     *
     * @param string $inputFile
     *            Path to file
     * @param string $outputFile
     *            Path to file
     * @param string[] $options
     *            Options
     *
     * @return void
     */
    public function setCache($inputFile, $outputFile, $options)
    {
        $filename = $this->cacheName($inputFile, $outputFile, $options);
        file_put_contents($filename, file_get_contents(str_replace('"', '', $outputFile)));
        shell_exec('chmod 666 ' . $filename);
    }
}
