<?php
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5.3<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */
namespace Karla;

/**
 * Interface for Karla caching tools
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
interface Cache
{

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
    public function isCached($inputFile, $outputFile, $options);

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
    public function getCached($inputFile, $outputFile, $options);

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
    public function setCache($inputFile, $outputFile, $options);
}
