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

use Karla\Program;
use Karla\Query;
use Karla\Action;
use Karla\Support;
use Karla\Karla;

/**
 * Class for handeling gravity action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Gravity implements Action
{

    /**
     * The gravity of the image
     *
     * @var string
     */
    private string $gravity;

    /**
     * Construct a new gravity action
     *
     * @param \Karla\Program $program
     *            The program to use
     * @param string $gravity
     *            Gravity
     *
     * @throws \InvalidArgumentException If the supplied gravity is not supported by imagemagick.
     */
    public function __construct(Program $program, string $gravity)
    {
        if (! Support::gravity($program, $gravity)) {
            $message = 'The supplied gravity (' . $gravity . ') is not supported by imagemagick';
            throw new \InvalidArgumentException($message);
        }
        $this->gravity = $gravity;
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
        $query->notWith('gravity', Query::ARGUMENT_TYPE_INPUT);
        $query->setInputOption(" -gravity " . $this->gravity);
        return $query;
    }
}
