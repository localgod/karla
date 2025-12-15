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
 * Class for handling crop action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Crop implements Action
{
    /**
     * Width
     *
     * @var int
     */
    private int|null $width;

    /**
     * Height
     *
     * @var int
     */
    private int|null $height;

    /**
     * X offset
     *
     * @var int
     */
    private int $xOffset;

    /**
     * Y offset
     *
     * @var int
     */
    private int $yOffset;

    /**
     * Construct a new crop action
     *
     * @param int $width Image width
     * @param int $height Image height
     * @param int $xOffset X offset from upper-left corner
     * @param int $yOffset Y offset from upper-left corner
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(int|null $width, int|null $height, int $xOffset, int $yOffset)
    {
        $this->width = $width;
        $this->height = $height;
        $this->xOffset = $xOffset;
        $this->yOffset = $yOffset;
    }

    /**
     * (non-PHPdoc)
     *
     * @param Query $query The query to add the action to
     *
     * @see Action::perform()
     */
    public function perform(Query $query): Query
    {
        $query->notWith('crop', Query::ARGUMENT_TYPE_INPUT);

        $option = " -crop " . $this->width . "x" . $this->height;

        if ($this->xOffset >= 0) {
            $option = $option . "+" . $this->xOffset;
        } else {
            $option = $option . $this->xOffset;
        }

        if ($this->yOffset >= 0) {
            $option = $option . "+" . $this->yOffset;
        } else {
            $option = $option . $this->yOffset;
        }

        // http://www.imagemagick.org/Usage/crop/#crop_repage
        $option = $option . " +repage ";
        $query->setInputOption($option);

        return $query;
    }
}
