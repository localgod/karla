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
 * @since    2024-01-01
 */

declare(strict_types=1);

namespace Karla;

/**
 * Class for validating file system paths to prevent directory traversal attacks
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class PathValidator
{
    /**
     * Validate a file path and return its resolved absolute path.
     *
     * Prevents directory traversal attacks by resolving the real path and
     * rejecting paths containing null bytes.
     *
     * @param string $path Path to validate
     *
     * @throws \InvalidArgumentException If the path contains null bytes or cannot be resolved.
     */
    public static function validatePath(string $path): string
    {
        if (str_contains($path, "\0")) {
            throw new \InvalidArgumentException('Path contains null bytes');
        }

        $realPath = realpath($path);

        if ($realPath === false) {
            throw new \InvalidArgumentException("Invalid path: {$path}");
        }

        return $realPath;
    }

    /**
     * Validate a directory path and return its resolved absolute path.
     *
     * Prevents directory traversal attacks by resolving the real path and
     * confirming the resolved path is a directory.
     *
     * @param string $path Directory path to validate
     *
     * @throws \InvalidArgumentException If the path is invalid or not a directory.
     */
    public static function validateDirectory(string $path): string
    {
        $realPath = self::validatePath($path);

        if (!is_dir($realPath)) {
            throw new \InvalidArgumentException("Path is not a directory: {$path}");
        }

        return $realPath;
    }
}
