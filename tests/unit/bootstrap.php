<?php

/**
 * Karla Imagemagick wrapper library test bootstrap file
 *
 * PHP Version 8.0<
 *
 * @package  Karla
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT

 * @link     https://github.com/localgod/karla Karla
 * @since    2010-06-05
 */

// Load Platform class directly before the autoloader so we can use it for OS detection
require_once __DIR__ . '/../../src/Karla/Platform.php';

// Determine ImageMagick path with auto-detection
$imageMagickPath = null;

if (\Karla\Platform::isWindows()) {
    // Windows: check common locations and convert paths
    $possiblePaths = [
        'C:/dev/imagemagick/',
        'C:/Program Files/ImageMagick/',
        'C:/ImageMagick/',
    ];

    foreach ($possiblePaths as $path) {
        // Check for both ImageMagick 6 (convert.exe) and 7 (magick.exe)
        if (file_exists($path . \Karla\Platform::getBinary('magick')) || file_exists($path . \Karla\Platform::getBinary('convert'))) {
            $imageMagickPath = $path;
            break;
        }
    }

    // Fallback
    if (empty($imageMagickPath)) {
        $imageMagickPath = 'C:/Program Files/ImageMagick/';
    }
} else {
    // Unix-like: use 'which' command
    if ("" == shell_exec("which convert | grep '/opt/local/bin/'")) {
        $imageMagickPath = '/usr/bin/';
    } else {
        $imageMagickPath = '/opt/local/bin/';
    }
}

define('PATH_TO_IMAGEMAGICK', $imageMagickPath);

require_once realpath(__DIR__ . '/../../vendor/autoload.php');
require_once __DIR__ . '/TestHelper.php';
