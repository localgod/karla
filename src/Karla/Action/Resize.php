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
use InvalidArgumentException;

/**
 * Class for handling resize action
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
     * @var int|null
     */
    private int|null $width;

    /**
     * Height of new image
     *
     * @var int|null
     */
    private int|null $height;

    /**
     * Maintain aspect ratio
     *
     * @var bool
     */
    private bool $maintainAspectRatio;

    /**
     * Don't scale up
     *
     * @var bool
     */
    private bool $dontScaleUp;

    /**
     * Default we ignored aspect ratio
     * @var string
     */
    private string $aspect = self::ASPECT_FIT;

    /**
     * Construct a new size action
     *
     * @param int|null $width Image width
     * @param int|null $height Image height
     * @param bool $maintainAspectRatio Should we maintain aspect ratio?
     * @param bool $dontScaleUp Should we prohibit scaling up?
     * @param string $aspect How should we handle aspect ratio?
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(
        int|null $width,
        int|null $height,
        bool $maintainAspectRatio,
        bool $dontScaleUp,
        string $aspect = Resize::ASPECT_FIT
    ) {
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
        if (!in_array($aspect, array(Resize::ASPECT_FIT, Resize::ASPECT_FILL))) {
            $message = sprintf('aspect must be "%s" or "%s".', Resize::ASPECT_FIT, Resize::ASPECT_FILL);
            throw new \InvalidArgumentException($message);
        }

        $this->width = $width;
        $this->height = $height;
        $this->maintainAspectRatio = $maintainAspectRatio;
        $this->dontScaleUp = $dontScaleUp;
        $this->aspect = $aspect;
    }

    /**
     * Perform the resize action
     *
     * @param Query $query The query to add the action to
     *
     * @see Action::perform()
     */
    public function perform(Query $query): Query
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
