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
use Karla\Support;
use Karla\Action;

/**
 * Class for handeling type action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Type implements Action
{

    /**
     * The type to use
     *
     * @var string
     */
    private $type;

    /**
     * Create a new type action
     *
     * @param Program $program
     *            The program to use
     * @param string $type
     *            The type to use
     *
     * @return void
     * @throws \InvalidArgumentException If the supplied colorspace is not supported by imagemagick
     */
    public function __construct($program, $type)
    {
        if (! Support::imageTypes($program, $type)) {
            $message = 'The supplied colorspace (' . $type . ') is not supported by imagemagick';
            throw new \InvalidArgumentException($message);
        }
        $this->type = $type;
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
        $query->notWith('type', Query::ARGUMENT_TYPE_OUTPUT);

        $query->setOutputOption(" -type " . $this->type . ' ');
        return $query;
    }
}
