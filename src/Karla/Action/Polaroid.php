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
 * Class for handeling polaroid action
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Polaroid implements Action
{

    /**
     * Angle
     *
     * @var integer
     */
    private $angle;

    /**
     * Construct a new size action
     *
     * @param integer $angle
     *            Angle
     *
     * @return void
     */
    public function __construct($angle)
    {
        $this->angle = $angle;
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
        $query->notWith('polaroid', Query::ARGUMENT_TYPE_INPUT);
        if (! is_numeric($this->angle) || $this->angle > 360 || $this->angle < 0) {
            $message = 'The supplied angle (' . $this->angle . ') must be an integer between 0 - 360';
            throw new \InvalidArgumentException($message);
        }
        $query->setInputOption(" -polaroid " . $this->angle . '');

        return $query;
    }
}