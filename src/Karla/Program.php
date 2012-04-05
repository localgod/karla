<?php
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 * @since    2012-04-05
 */
/**
 * Interface for all classes wrapping ImageMagick tools
 *
 * @category   Utility
 * @package    Karla
 * @subpackage Karla
 * @author     Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/localgod/Karla Karla
 */
interface Program
{
	/**
	 * Execute the command
	 *
	 * @return string
	 */
	public function execute();
	/**
	 * Get the command to run
	 *
	 * @return string
	 */
	public function getCommand();
	/**
	 * Reset the command
	 *
	 * @return void
	 */
	public function reset();
}