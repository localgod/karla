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
 * Class for handling polaroid action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Polaroid implements Action
{
    /**
     * Angle
     *
     * @var int
     */
    private int $angle;

    /**
     * Construct a new polaroid action
     *
     * @param int $angle Angle
     *
     * @throws \InvalidArgumentException If the supplied angle is not an integer between 0 and 360.
     */
    public function __construct(int $angle)
    {
        if ($angle > 360 || $angle < 0) {
            $message = 'The supplied angle (' . $angle . ') must be an integer between 0 and 360';
            throw new \InvalidArgumentException($message);
        }
        $this->angle = $angle;
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
        $query->notWith('polaroid', Query::ARGUMENT_TYPE_INPUT);
        $query->setInputOption(" -polaroid " . $this->angle . '');

        return $query;
    }
}
