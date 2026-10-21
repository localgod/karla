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
 * @since    2026-03-25
 */

declare(strict_types=1);

namespace Karla;

/**
 * Platform utility class for OS detection
 *
 * Centralises OS detection logic using the modern PHP_OS_FAMILY constant,
 * replacing the scattered `strtoupper(substr(PHP_OS, 0, 3)) == "WIN"` pattern.
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Platform
{
    /**
     * Determine whether the current OS is Windows.
     *
     * Uses PHP_OS_FAMILY (available since PHP 7.2) which returns 'Windows' on
     * all Windows variants, making the check both readable and reliable.
     */
    public static function isWindows(): bool
    {
        return PHP_OS_FAMILY === 'Windows';
    }

    /**
     * Return the platform-appropriate binary name.
     *
     * On Windows the `.exe` extension is appended; on all other platforms the
     * name is returned unchanged.
     *
     * @param string $binary Base binary name (e.g. 'convert', 'magick')
     *
     * @return string Binary name suitable for the current platform
     */
    public static function getBinary(string $binary): string
    {
        return self::isWindows() ? $binary . '.exe' : $binary;
    }

    /**
     * Return the shell invocation of a binary in the given bin path.
     *
     * On Windows the bin path is a directory prefix, and the full path is quoted
     * so install locations containing spaces (e.g. `C:\Program Files\...`) work.
     * On other platforms the bin path is an `export PATH=...;` prefix and the
     * binary is invoked by name.
     *
     * @param string $binPath Bin path prefix as stored by Karla
     * @param string $binary  Platform binary name (see getBinary())
     *
     * @return string Executable invocation suitable for the current platform
     */
    public static function getExecutable(string $binPath, string $binary): string
    {
        return self::isWindows() ? escapeshellarg($binPath . $binary) : $binPath . $binary;
    }
}
