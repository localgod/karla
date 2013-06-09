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
 * @since    2013-05-26
 */
namespace Karla\Action;

use Karla\Query;
use Karla\Action;

/**
 * Class for handeling resize action
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Resize implements Action
{

    /**
     * Width of new image
     *
     * @var integer
     */
    private $width;

    /**
     * Height of new image
     *
     * @var integer
     */
    private $height;

    /**
     * Maintain aspect ratio
     *
     * @var boolean
     */
    private $maintainAspectRatio;

    /**
     * Don't scale up
     *
     * @var boolean
     */
    private $dontScaleUp;

    /**
     * Construct a new size action
     *
     * @param integer $width
     *            Image width
     * @param integer $height
     *            Image height
     * @param boolean $maintainAspectRatio
     *            Should we maintain aspect ratio?
     * @param boolean $dontScaleUp
     *            Should we prohipped scaling up?
     *
     * @return void
     */
    public function __construct($width, $height, $maintainAspectRatio, $dontScaleUp)
    {
        $this->width = $width;
        $this->height = $height;
        $this->maintainAspectRatio = $maintainAspectRatio;
        $this->dontScaleUp = $dontScaleUp;
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
        $query->notWith('resize', Query::ARGUMENT_TYPE_INPUT);
        $query->notWith('resample', Query::ARGUMENT_TYPE_INPUT);

        if ($this->width == "" && $this->height == "") {
            $message = 'You must supply height or width or both to resize the image';
            throw new \InvalidArgumentException($message);
        }
        if (! is_numeric($this->width) && $this->width != '') {
            $message = 'width must be an integer value or empty.';
            throw new \InvalidArgumentException($message);
        }
        if (! is_numeric($this->height) && $this->height != '') {
            $message = 'height must be an integer value or empty.';
            throw new \InvalidArgumentException($message);
        }

        $option = " -resize ";

        if ($this->width != '') {
            $option = $option . $this->width;
        }

        if ($this->height != '') {
            $option = $option . "x" . $this->height;
        }

        if (! $this->maintainAspectRatio) {
            $option = $option . "!";
        }
        if ($this->dontScaleUp) {
            $option = $option . "\>";
        }
        $option = $option . " ";
        $query->setInputOption($option);

        return $query;
    }
}