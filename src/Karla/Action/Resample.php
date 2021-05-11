<?php

/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 7.4<
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
    private int $newWidth;

    /**
     * New height
     *
     * @var integer
     */
    private int $newHeight;

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
    public function __construct(int $newWidth, int|null $newHeight)
    {
        $this->newWidth = $newWidth;
        $newHeight == null ? $this->newHeight = 0 : $this->newHeight = $newHeight;
    }

    /**
     * (non-PHPdoc)
     *
     * @param Query $query
     *            The query to add the action to
     * @return Query
     * @see Action::perform()
     */
    public function perform(Query $query): Query
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
