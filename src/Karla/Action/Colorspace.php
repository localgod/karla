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
use Karla\Support;

/**
 * Class for handeling colorspace action
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Colorspace implements Action
{

    /**
     * Colorspace
     *
     * @var integer
     */
    private $colorspace;

    /**
     * The program to use
     *
     * @var Program
     */
    private $program;

    /**
     * Construct a new size action
     *
     * @param Program $program
     *            The program to use
     * @param integer $colorspace
     *            Colorspace
     *
     * @return void
     */
    public function __construct($program, $colorspace)
    {
        $this->program = $program;
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

        if (! Support::colorSpace($this->program, $this->colorspace)) {
            $message = 'The supplied colorspace (' . $this->colorspace . ') is not supported by imagemagick';
            throw new \InvalidArgumentException($message);
        }
        $query->setOutputOption(" -colorspace " . $this->colorspace . ' ');

        return $query;
    }
}