<?php
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5.3<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2013-05-26
 */
namespace Karla\Action;

use Karla\Query;
use Karla\Action;

/**
 * Class for handeling rotate action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
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
    private $degree;

    /**
     * Rotate image
     *
     * @param integer $degree
     *            Degrees to rotate the image
     *
     * @return \Karla\Program\Convert
     * @throws \InvalidArgumentException if degree is not an integer value
     */
    public function __construct($degree)
    {
        if (! is_numeric($degree)) {
            $message = 'degree must be an integer value';
            throw new \InvalidArgumentException($message);
        }
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
    public function perform(Query $query)
    {
        $query->notWith('rotate', Query::ARGUMENT_TYPE_INPUT);
        $query->setInputOption(' -rotate "' . $this->degree . '"');
        return $query;
    }
}
