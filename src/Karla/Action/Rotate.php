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
 * Class for handeling rotate action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Rotate implements Action
{

    /**
     * Degrees to rotate the image
     *
     * @var integer
     */
    private int $degree;

    /**
     * Rotate image
     *
     * @param integer $degree
     *            Degrees to rotate the image
     *
     * @throws \InvalidArgumentException if degree is not an integer value
     */
    public function __construct(int $degree)
    {
        $this->degree = $degree;
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
        $query->notWith('rotate', Query::ARGUMENT_TYPE_INPUT);
        $query->setInputOption(' -rotate "' . $this->degree . '"');
        return $query;
    }
}
