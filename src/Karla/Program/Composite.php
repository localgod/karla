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
namespace Karla\Program;
/**
 * Class for wrapping ImageMagicks composite tool
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 */
class Composite extends ImageMagick
{

    /**
     * Add base file argument
     *
     * @return Composite
     */
    public function basefile()
    {
        return $this;
    }

    /**
     * Add change file argument
     *
     * @return Composite
     */
    public function changefile()
    {
        return $this;
    }

    /**
     * Add output file argument
     *
     * @return Composite
     */
    public function outputfile()
    {
        return $this;
    }

    /**
     * Raw arguments directly to ImageMagick
     *
     * @param string $arguments
     *            Arguments
     * @param boolean $input
     *            Defaults to an input option, use false to use it as an output option
     *
     * @return Composite
     * @see ImageMagick::raw()
     */
    public function raw($arguments, $input = true)
    {
        parent::raw($arguments, $input);

        return $this;
    }
}
