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

/**
 * Class for handeling layers action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Layers implements Action
{

    /**
     * Method
     *
     * @var string
     */
    private string $method;

    /**
     * Contruct new action
     *
     * @param \Karla\Program $program
     *            The program to use
     * @param string $method
     *            Method
     *
     * @throws \InvalidArgumentException If the supplied method is not supported by imagemagick.
     */
    public function __construct(Program $program, string $method)
    {
        if (! Support::layerMethod($program, $method)) {
            $message = 'The supplied method (' . $method . ') is not supported by imagemagick';
            throw new \InvalidArgumentException($message);
        }
        $this->method = $method;
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
        $query->setInputOption(" -layers " . $this->method);
        return $query;
    }
}
