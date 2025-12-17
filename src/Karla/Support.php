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
 * @since    2013-05-26
 */

declare(strict_types=1);

namespace Karla;

use Karla\Program;
use Karla\Program\Identify;
use Karla\Program\Convert;
use Karla\Program\ImageMagick;
use Karla\Program\Composite;

/**
 * Class for querying for supported features
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Support
{
    /**
     * Get the appropriate binary for -list commands.
     * For ImageMagick 6, use 'convert'; for IM7, use 'magick'.
     *
     * @param Program $program Program instance to extract binary path from
     */
    private static function getListBinary(Program $program): string
    {
        $binary = $program->getBinary();
        
        // If it's already 'magick' (IM7), return as-is
        if (str_contains($binary, 'magick')) {
            return $binary;
        }
        
        // For IM6, replace tool-specific binary with 'convert' which supports -list
        // Extract path and replace binary name with 'convert'
        $binPath = dirname($binary) . DIRECTORY_SEPARATOR;
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) == "WIN";
        $convertBin = $isWindows ? 'convert.exe' : 'convert';
        
        return $binPath . $convertBin;
    }

    /**
     * Check if a gravity is supported by ImageMagick.
     *
     * @param Program $program Program to check
     * @param string $gravity Gravity to check
     *
     * @throws \BadMethodCallException if called in a wrong context
     */
    public static function gravity(Program $program, string $gravity): bool
    {
        if (! ($program instanceof Convert) && ! ($program instanceof Composite)) {
            $message = 'This method can not be used in this context. (' . get_class($program) . ')';
            throw new \BadMethodCallException($message);
        }

        // Use the appropriate binary for -list commands
        // Redirect stderr to stdout to capture all output
        $command = self::getListBinary($program) . ' -list gravity 2>&1';

        $gravities = shell_exec($command);
        if ($gravities === null || trim($gravities) === '') {
            return false;
        }

        $gravities = explode("\n", $gravities);
        $count = count($gravities);
        for ($i = 0; $i < $count; $i++) {
            $gravities[$i] = trim(strtolower($gravities[$i]));
        }

        return in_array(strtolower(trim($gravity)), $gravities);
    }

    /**
     * Check if an image type is supported by the ImageMagick program.
     *
     * @param Program $program Program to check
     * @param string $type Type to check
     */
    public static function imageTypes(Program $program, string $type): bool
    {
        if (! ($program instanceof Convert) && ! ($program instanceof Identify)) {
            $message = 'This method can not be used in this context. (' . get_class($program) . ')';
            throw new \BadMethodCallException($message);
        }

        // Use the appropriate binary for -list commands
        // Redirect stderr to stdout to capture all output
        $command = self::getListBinary($program) . ' -list type 2>&1';

        $types = shell_exec($command);
        if ($types === null || trim($types) === '') {
            return false;
        }

        $types = explode("\n", $types);
        $count = count($types);
        for ($i = 0; $i < $count; $i++) {
            $types[$i] = trim(strtolower($types[$i]));
        }

        return in_array(strtolower(trim($type)), $types);
    }

    /**
     * Check if a colorspace is supported by the ImageMagick program.
     *
     * @param Program $program Program to check
     * @param string $colorSpace Colorspace to check
     */
    public static function colorSpace(Program $program, string $colorSpace): bool
    {
        if (! ($program instanceof Convert) && ! ($program instanceof Identify)) {
            $message = 'This method can not be used in this context. (' . get_class($program) . ')';
            throw new \BadMethodCallException($message);
        }

        // Use the appropriate binary for -list commands
        // Redirect stderr to stdout to capture all output
        $command = self::getListBinary($program) . ' -list colorspace 2>&1';

        $colorspaces = shell_exec($command);
        if ($colorspaces === null || trim($colorspaces) === '') {
            // Command failed, return false
            return false;
        }

        $colorspaces = explode("\n", $colorspaces);
        $count = count($colorspaces);
        for ($i = 0; $i < $count; $i++) {
            $colorspaces[$i] = trim(strtolower($colorspaces[$i]));
        }

        return in_array(strtolower(trim($colorSpace)), $colorspaces);
    }

    /**
     * Check if a method is supported by ImageMagick.
     *
     * @param Program $program Program to check
     * @param string $method Method to check
     *
     * @throws \BadMethodCallException if called in a wrong context
     */
    public static function layerMethod(Program $program, string $method): bool
    {
        if (! ($program instanceof Convert) && ! ($program instanceof Identify)) {
            throw new \BadMethodCallException('This method can not be used in this context');
        }

        // Use the appropriate binary for -list commands
        // Redirect stderr to stdout to capture all output
        $command = self::getListBinary($program) . ' -list layers 2>&1';

        $methods = shell_exec($command);
        if ($methods === null || trim($methods) === '') {
            return false;
        }

        $methods = explode("\n", $methods);
        $count = count($methods);
        for ($i = 0; $i < $count; $i++) {
            $methods[$i] = trim(strtolower($methods[$i]));
        }

        return in_array(strtolower(trim($method)), $methods);
    }

    /**
     * Check if a format is supported by ImageMagick.
     *
     * @param Program $program Program to check
     * @param string $format Format to check
     *
     * @throws \BadMethodCallException if called in a wrong context
     */
    public static function supportedFormat(Program $program, string $format): bool
    {
        if (! ($program instanceof Convert) && ! ($program instanceof Identify)) {
            throw new \BadMethodCallException('This method can not be used in this context');
        }

        // Use the appropriate binary for -list commands
        // Redirect stderr to stdout to capture all output
        $command = self::getListBinary($program) . ' -list format 2>&1';

        $formats = shell_exec($command);
        if ($formats === null || trim($formats) === '') {
            return false;
        }

        $formats = explode("\n", $formats);
        $count = count($formats);
        for ($i = 0; $i < $count; $i++) {
            $matches = [];
            preg_match("/^[\s]*[A-Z0-9]+/", $formats[$i], $matches);
            if (isset($matches[0]) && ! strpos($matches[0], 'Format')) {
                $formats[$i] = strtolower(trim($matches[0]));
            }
        }

        return in_array(strtolower(trim($format)), $formats);
    }
}
