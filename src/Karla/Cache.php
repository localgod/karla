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

namespace Karla;

/**
 * Interface for Karla caching tools
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
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
    public function isCached(string $inputFile, string $outputFile, array $options): bool;

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
    public function getCached(string $inputFile, string $outputFile, array $options): string;

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
    public function setCache(string $inputFile, string $outputFile, string $options): void;
}
