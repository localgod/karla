<?php
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5.3<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2013-05-26
 */
namespace Karla\Action;

use Karla\Query;
use Karla\Action;

/**
 * Class for handeling crop action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Crop implements Action
{

    /**
     * Width
     * @var integer
     */
    private $width;

    /**
     * Height
     * @var integer
     */
    private $height;

    /**
     * X offset
     * @var integer
     */
    private $xOffset;

    /**
     * Y offset
     * @var integer
     */
    private $yOffset;

    /**
     * Construct a new crop action
     *
     * @param integer $width
     *            Image width
     * @param integer $height
     *            Image height
     * @param integer $xOffset
     *            X offset from upper-left corner
     * @param integer $yOffset
     *            Y offset from upper-left corner
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($width, $height, $xOffset, $yOffset)
    {
        if (! is_numeric($width) && $width != '') {
            $message = 'width must be an integer value or empty.';
            throw new \InvalidArgumentException($message);
        }
        if (! is_numeric($height) && $height != '') {
            $message = 'height must be an integer value or empty.';
            throw new \InvalidArgumentException($message);
        }
        if (! is_numeric($xOffset)) {
            $message = 'xOffset must be an integer value.';
            throw new \InvalidArgumentException($message);
        }
        if (! is_numeric($yOffset)) {
            $message = 'yOffset must be an integer value.';
            throw new \InvalidArgumentException($message);
        }

        $this->width = (int) $width;
        $this->height = (int) $height;
        $this->xOffset = (int) $xOffset;
        $this->yOffset = (int) $yOffset;
    }

    /**
     * (non-PHPdoc)
     *
     * @param Query $query
     *            The query to add the action to
     * @return Query
     * @see Action::perform()
     */
    public function perform(Query $query)
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
