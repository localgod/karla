<?php
/**
 * Karla Imagemagick wrapper library test bootstrap file
 *
 * PHP Version 5.1.2
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @version  SVN: <1>
 * @link     http://www.greenoak.dk/ GreenOak
 * @since    2010-06-05
 */
if (false === spl_autoload_functions()) {
	if (function_exists('__autoload')) {
		spl_autoload_register('__autoload', false);
	}
}
require_once dirname(__FILE__).'/../src/Karla.php';
spl_autoload_register(array('Karla', 'autoload'));