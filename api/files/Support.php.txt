<?php
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5.3
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 * @since    2013-05-26
 */
namespace Karla;

use Karla\Program\Identify;
use Karla\Program\Convert;
use Karla\Program\ImageMagick;

/**
 * Class for quering for supported features
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Support
{
    /**
     * Check if a gravity is supported by ImageMagick.
     *
     * @param Program $program
     *            Program to check
     * @param string $gravity
     *            Gravity to check
     *
     * @return boolean
     * @throws \BadMethodCallException if called in a wrong context
     */
    public static function gravity($program, $gravity)
    {
        if (! ($program instanceof Convert) && ! ($program instanceof Composite)) {
            throw new \BadMethodCallException('This method can not be used in this context. (' . get_class($program) . ')');
        }
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ? ImageMagick::IMAGEMAGICK_CONVERT . '.exe' : ImageMagick::IMAGEMAGICK_CONVERT;
        $gravities = shell_exec($program->binPath . $bin . ' -list gravity');
        $gravities = explode("\n", $gravities);
        for ($i = 0; $i < count($gravities); $i ++) {
            $gravities[$i] = trim(strtolower($gravities[$i]));
        }

        return in_array(strtolower(trim($gravity)), $gravities);
    }

    /**
     * Check if a image type is supported by the ImageMagick program.
     *
     * @param Program $program
     *            Program to check
     * @param string $type
     *            Type to check
     *
     * @return boolean
     */
    public static function imageTypes($program, $type)
    {
        if (! ($program instanceof Convert) && ! ($program instanceof Identify)) {
            throw new \BadMethodCallException('This method can not be used in this context. (' . get_class($program) . ')');
        }
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ? ImageMagick::IMAGEMAGICK_CONVERT . '.exe' : ImageMagick::IMAGEMAGICK_CONVERT;
        $types = shell_exec($program->binPath . $bin . ' -list type');
        $types = explode("\n", $types);
        for ($i = 0; $i < count($types); $i ++) {
            $types[$i] = trim(strtolower($types[$i]));
        }

        return in_array(strtolower(trim($type)), $types);
    }

    /**
     * Check if a colorspace is supported by the ImageMagick program.
     *
     * @param Program $program
     *            Program to check
     * @param string $colorSpace
     *            Colorspace to check
     *
     * @return boolean
     */
    public static function colorSpace($program, $colorSpace)
    {
        if (! ($program instanceof Convert) && ! ($program instanceof Identify)) {
            throw new \BadMethodCallException('This method can not be used in this context. (' . get_class($program) . ')');
        }
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ? ImageMagick::IMAGEMAGICK_CONVERT . '.exe' : ImageMagick::IMAGEMAGICK_CONVERT;
        $colorspaces = shell_exec($program->binPath . $bin . ' -list colorspace');
        $colorspaces = explode("\n", $colorspaces);
        for ($i = 0; $i < count($colorspaces); $i ++) {
            $colorspaces[$i] = trim(strtolower($colorspaces[$i]));
        }

        return in_array(strtolower(trim($colorSpace)), $colorspaces);
    }

    /**
     * Check if a method is supported by ImageMagick.
     *
     * @param Program $program
     *            Program to check
     * @param string $method
     *            Method to check
     *
     * @return boolean
     * @throws \BadMethodCallException if called in a wrong context
     */
    public static function layerMethod($program, $method)
    {
        if (! ($program instanceof Convert) && ! ($program instanceof Identify)) {
            throw new \BadMethodCallException('This method can not be used in this context');
        }
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ? ImageMagick::IMAGEMAGICK_CONVERT . '.exe' : ImageMagick::IMAGEMAGICK_CONVERT;
        $methods = shell_exec($program->binPath . $bin . ' -list layers');
        $methods = explode("\n", $methods);
        for ($i = 0; $i < count($methods); $i ++) {
            $methods[$i] = trim(strtolower($methods[$i]));
        }

        return in_array(strtolower(trim($method)), $methods);
    }

    /**
     * Check if a format is supported by ImageMagick.
     *
     * @param Program $program
     *            Program to check
     * @param string $format
     *            Format to check
     *
     * @return boolean
     * @throws \BadMethodCallException if called in a wrong context
     */
    public static function supportedFormat($program, $format)
    {
        if (! ($program instanceof Convert) && ! ($program instanceof Identify)) {
            throw new \BadMethodCallException('This method can not be used in this context');
        }
        $bin = strtoupper(substr(PHP_OS, 0, 3)) == "WIN" ? ImageMagick::IMAGEMAGICK_CONVERT . '.exe' : ImageMagick::IMAGEMAGICK_CONVERT;
        $formats = shell_exec($program->binPath . $bin . ' -list format');
        $formats = explode("\n", $formats);
        for ($i = 0; $i < count($formats); $i ++) {
            preg_match("/^[\s]*[A-Z0-9]+/", $formats[$i], $matches);
            if (isset($matches[0])) {
                if (! strpos($matches[0], 'Format')) {
                    $formats[$i] = strtolower(trim($matches[0]));
                }
            }
        }

        return in_array(strtolower(trim($format)), $formats);
    }
}
