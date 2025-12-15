<?php

/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 8.0<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */

declare(strict_types=1);

namespace Karla\Program;

/**
 * Class for wrapping ImageMagicks composite tool
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Composite extends ImageMagick
{
    /**
     * Add base file argument
     */
    public function basefile(): self
    {
        return $this;
    }

    /**
     * Add change file argument
     */
    public function changefile(): self
    {
        return $this;
    }

    /**
     * Add output file argument
     */
    public function outputfile(): self
    {
        return $this;
    }

    /**
     * Raw arguments directly to ImageMagick
     *
     * @param string $arguments Arguments
     * @param bool $input Defaults to an input option, use false to use it as an output option
     *
     * @see ImageMagick::raw()
     */
    public function raw(string $arguments, bool $input = true): self
    {
        parent::raw($arguments, $input);
        return $this;
    }
}
