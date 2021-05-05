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

declare(strict_types = 1);
namespace Karla\Action;

use Karla\Query;
use Karla\Action;

/**
 * Class for handeling sepia action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Sepia implements Action
{

    /**
     * Threshold
     *
     * @var integer
     */
    private $threshold;

    /**
     * Construct a new size action
     *
     * @param integer $threshold
     *            Threshold
     *
     * @throws \InvalidArgumentException If The supplied threshold is not between 0 and 100
     */
    public function __construct($threshold)
    {
        if (! is_integer($threshold) || $threshold > 100 || $threshold < 0) {
            $message = 'The supplied threshold (' . $threshold . ') must be between 0 and 100';
            throw new \InvalidArgumentException($message);
        }
        $this->threshold = (int) $threshold;
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
        $query->notWith('sepia-tone', Query::ARGUMENT_TYPE_OUTPUT);
        $query->setOutputOption(" -sepia-tone " . $this->threshold . '% ');

        return $query;
    }
}
