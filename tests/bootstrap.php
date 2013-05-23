<?php
/**
 * Karla Imagemagick wrapper library test bootstrap file
 *
 * PHP Version 5.3.1.2
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT

 * @link     https://github.com/localgod/Karla Karla
 * @since    2010-06-05
 */
if (false === spl_autoload_functions()) {
    if (function_exists('__autoload')) {
        spl_autoload_register('__autoload', false);
    }
}
if ("" == shell_exec("which convert | grep '/opt/local/bin/'")) {
    define('PATH_TO_IMAGEMAGICK', '/usr/bin/');
} else {
    define('PATH_TO_IMAGEMAGICK', '/opt/local/bin/');
}

spl_autoload_register(
function ($name)
{
    if ('Karla\\' == substr($name, 0, 6)) {
        $path = __DIR__ . '/../src' . DIRECTORY_SEPARATOR
        . str_replace('\\', DIRECTORY_SEPARATOR, $name)
        . '.php';
        var_dump($path);
        require_once $path;
    }
});
