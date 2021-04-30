<?php
/**
 * Karla Imagemagick wrapper library test bootstrap file
 *
 * PHP Version 5.3<
 *
 * @package  Karla
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT

 * @link     https://github.com/localgod/karla Karla
 * @since    2010-06-05
 */
if ("" == shell_exec("which convert | grep '/opt/local/bin/'")) {
    define('PATH_TO_IMAGEMAGICK', '/usr/bin/');
} else {
    define('PATH_TO_IMAGEMAGICK', '/opt/local/bin/');
}
require_once realpath(__DIR__ . '/../vendor/autoload.php');