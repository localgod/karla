<?php
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5.3
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 * @since    2013-05-26
 */
namespace Karla\Action;

use Karla\Query;
use Karla\Action;

/**
 * Class for handeling sepia action
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
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
     * @return void
     */
    public function __construct($threshold)
    {
        $this->threshold = $threshold;
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

        if (! is_integer($this->threshold) || $this->threshold > 100 || $this->threshold < 0) {
            $message = 'The supplied threshold (' . $this->threshold . ') must be between 0 - 100';
            throw new \InvalidArgumentException($message);
        }
        $query->setOutputOption(" -sepia-tone " . $this->threshold . '% ');

        return $query;
    }
}