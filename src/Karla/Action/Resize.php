<?php

/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5.3<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2013-05-26
 */

namespace Karla\Action;

use Karla\Query;
use Karla\Action;
use InvalidArgumentException;

/**
 * Class for handeling resize action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Resize implements Action
{

    /**
     * Preserve aspect ratio
     *
     * @var string
     */
    public const ASPECT_FILL = 'aspect_fill';

    /**
     * Ignored aspect ratio
     *
     * @var string
     */
    public const ASPECT_FIT = 'aspect_fit';

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
     * Default we ignored aspect ratio
     * @var string
     */
    private $aspect = self::ASPECT_FIT;

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
     * @param string $aspect
     *            How should we handle aspect ratio?
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($width, $height, $maintainAspectRatio, $dontScaleUp, $aspect = Resize::ASPECT_FIT)
    {
        if ($width == "" && $height == "") {
            $message = 'You must supply height or width or both to resize the image';
            throw new InvalidArgumentException($message);
        }
        if (! is_numeric($width) && $width != '') {
            $message = 'width must be an integer value or empty.';
            throw new InvalidArgumentException($message);
        }
        if (! is_numeric($height) && $height != '') {
            $message = 'height must be an integer value or empty.';
            throw new InvalidArgumentException($message);
        }
        if (! is_bool($maintainAspectRatio)) {
            $message = 'maintainAspectRatio must be an boolean value.';
            throw new InvalidArgumentException($message);
        }
        if (! is_bool($dontScaleUp)) {
            $message = 'dontScaleUp must be an boolean value.';
            throw new InvalidArgumentException($message);
        }

        if (!in_array($aspect, array(Resize::ASPECT_FIT, Resize::ASPECT_FILL))) {
            $message = sprintf('aspect must be "%s" or "%s".', Resize::ASPECT_FIT, Resize::ASPECT_FILL);
            throw new \InvalidArgumentException($message);
        }

        $this->width = (int) $width;
        $this->height = (int) $height;
        $this->maintainAspectRatio = $maintainAspectRatio;
        $this->dontScaleUp = $dontScaleUp;
        $this->aspect = $aspect;
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

        $option = " -resize ";

        if ($this->width != '') {
            $option .= $this->width;
        }

        if ($this->height != '') {
            $option .= "x" . $this->height;
        }

        if ($this->aspect == Resize::ASPECT_FILL) {
            $option .= "^";
        }

        if ($this->dontScaleUp) {
            $option .= "\>";
        }

        if (! $this->maintainAspectRatio) {
            $option .= "!";
        }
        $option .= " ";
        $query->setInputOption($option);

        return $query;
    }
}
