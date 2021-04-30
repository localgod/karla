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

/**
 * Class for handeling resample action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Resample implements Action
{

    /**
     * New width
     *
     * @var integer
     */
    private $newWidth;

    /**
     * New height
     *
     * @var integer
     */
    private $newHeight;

    /**
     * Construct a new size action
     *
     * @param integer $newWidth
     *            New width
     * @param integer $newHeight
     *            New height
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($newWidth, $newHeight)
    {
        if (! is_numeric($newWidth)) {
            $message = 'You must supply new width as a integer.
                    Was (' . $newWidth . ')';
            throw new \InvalidArgumentException($message);
        }
        if ($newHeight != '' && ! is_numeric($newHeight)) {
            $message = 'You must supply new height as a integer or as an empty string.
                    Was (' . $newHeight . ')';
            throw new \InvalidArgumentException($message);
        }

        $this->newWidth = (int) $newWidth;
        $this->newHeight = (int) $newHeight;
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
        $query->notWith('resample', Query::ARGUMENT_TYPE_INPUT);
        $query->notWith('resize', Query::ARGUMENT_TYPE_INPUT);

        $option = " -resample '";
        if ($this->newWidth != "" && $this->newHeight != "") {
            $option = $option . $this->newWidth . "x" . $this->newHeight;
        } elseif ($this->newWidth != "") {
            $option = $option . $this->newWidth;
        }
        $option = $option . "' ";
        $query->setInputOption($option);

        return $query;
    }
}
