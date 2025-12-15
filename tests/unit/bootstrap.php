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

// Load environment variables from .env file if it exists
$envFile = realpath(__DIR__ . '/../../.env');
if ($envFile && file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if (!empty($key) && !isset($_ENV[$key])) {
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
}

// Determine ImageMagick path
$imageMagickPath = null;

// First check environment variable from .env
if (!empty($_ENV['IMAGEMAGICK_PATH'])) {
    $imageMagickPath = $_ENV['IMAGEMAGICK_PATH'];
}

// If not set, try to auto-detect
if (empty($imageMagickPath)) {
    $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    
    if ($isWindows) {
        // Windows: check common locations and convert paths
        $possiblePaths = [
            'C:/dev/imagemagick/',
            'C:/Program Files/ImageMagick/',
            'C:/ImageMagick/',
        ];
        
        foreach ($possiblePaths as $path) {
            // Check for both ImageMagick 6 (convert.exe) and 7 (magick.exe)
            if (file_exists($path . 'magick.exe') || file_exists($path . 'convert.exe')) {
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
}

define('PATH_TO_IMAGEMAGICK', $imageMagickPath);

require_once realpath(__DIR__ . '/../../vendor/autoload.php');
require_once __DIR__ . '/TestHelper.php';