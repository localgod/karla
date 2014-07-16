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

/**
 * Helper class for color operations
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 */
class Color
{

    /**
     * Check if supplied color is a valid hex color
     *
     * @param string $color
     *            Color to check
     *
     * @return boolean
     */
    public static function validHexColor($color)
    {
        $expr = '#?(([a-fA-F0-9]){3}){1,2}';

        return preg_match('/^' . $expr . '$/', $color);
    }

    /**
     * Check if this is a valid color name
     *
     * @param string $color
     *            Color to check
     *
     * @return boolean
     */
    public static function validColorName($color)
    {
        $expr = '(aqua)|(black)|(blue)|(fuchsia)|(gray)|(green)|(lime)|(maroon)|(navy)|
                (olive)|(orange)|(purple)|(red)|(silver)|(teal)|(white)|(yellow)';

        return preg_match('/^' . $expr . '$/', $color);
    }

    /**
     * Check if this is a valid rgb color definition
     *
     * @param string $color
     *            Color to check
     *
     * @return boolean
     */
    public static function validRgbColor($color)
    {
        $expr = '(rgb\(\s*\b([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\b\s*,
                \s*\b([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\b\s*,
                \s*\b([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\b\s*\))|
                (rgb\(\s*(\d?\d%|100%)+\s*,\s*(\d?\d%|100%)+\s*,\s*(\d?\d%|100%)+\s*\))';

        return preg_match('/^' . $expr . '$/x', $color);
    }
}
