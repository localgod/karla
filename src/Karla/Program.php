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
 * @since    2012-04-05
 */
namespace Karla;
/**
 * Interface for all classes wrapping ImageMagick tools
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
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
