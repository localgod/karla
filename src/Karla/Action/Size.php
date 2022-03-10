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
 * Class for handeling size action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Size implements Action
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
     * Construct a new size action
     *
     * @param integer $width
     *            New width
     * @param integer $height
     *            New height
     */
    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
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
        $query->notWith('size', Query::ARGUMENT_TYPE_INPUT);

        $query->setInputOption(" -size " . $this->width . "x" . $this->height . " ");

        return $query;
    }
}
