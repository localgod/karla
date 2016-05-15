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
use Karla\Support;

/**
 * Class for handeling colorspace action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Colorspace implements Action
{

    /**
     * Colorspace
     *
     * @var string
     */
    private $colorspace;

    /**
     * Construct a new size action
     *
     * @param \Karla\Program $program
     *            The program to use
     * @param string $colorspace
     *            Colorspace
     *
     * @throws \InvalidArgumentException If he supplied colorspace is not supported by imagemagick.
     */
    public function __construct($program, $colorspace)
    {
        if (! Support::colorSpace($program, $colorspace)) {
            $message = 'The supplied colorspace (' . $colorspace . ') is not supported by imagemagick';
            throw new \InvalidArgumentException($message);
        }
        $this->colorspace = $colorspace;
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
        $query->notWith('colorspace', Query::ARGUMENT_TYPE_OUTPUT);
        $query->setOutputOption(" -colorspace " . $this->colorspace . ' ');

        return $query;
    }
}
