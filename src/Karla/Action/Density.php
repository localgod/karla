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
 * @since    2013-05-26
 */

declare(strict_types=1);

namespace Karla\Action;

use Karla\Query;
use Karla\Action;

/**
 * Class for handeling density action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Density implements Action
{
    /**
     * Width
     *
     * @var integer
     */
    private int $width;

    /**
     * Height
     *
     * @var integer
     */
    private int $height;

    /**
     * Is it an output argument
     *
     * @var boolean
     */
    private bool $output;

    /**
     * Set the density of the output image.
     *
     * @param integer $width
     *            The width of the image
     * @param integer $height
     *            The height of the image
     * @param boolean $output
     *            If output is true density is set for the resulting image
     *            If output is false density is used for reading the input image
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(int $width, int $height, bool $output)
    {
        $this->width = $width;
        $this->height = $height;
        $this->output = $output;
    }

    /**
     * (non-PHPdoc)
     *
     * @param Query $query
     *            The query to add the action to
     * @return Query
     * @see Action::perform()
     * @throws \BadMethodCallException if density has already been called
     */
    public function perform(Query $query): Query
    {
        $query->notWith('density', Query::ARGUMENT_TYPE_INPUT);
        $query->notWith('density', Query::ARGUMENT_TYPE_OUTPUT);

        if ($this->output) {
            $query->setOutputOption(" -density " . $this->width . "x" . $this->height);
        } else {
            $query->setInputOption(" -density " . $this->width . "x" . $this->height);
        }
        return $query;
    }
}
