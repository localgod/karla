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
 * Class for handeling layers action
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Layers implements Action
{

    /**
     * Method
     *
     * @var string
     */
    private $method;

    /**
     * The program to use
     *
     * @var Program
     */
    private $program;

    /**
     * Contruct new action
     *
     * @param Program $program
     *            The program to use
     * @param string $method
     *            Method
     *
     * @return void
     */
    public function __construct($program, $method)
    {
        $this->program = $program;
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
    public function perform(Query $query)
    {
        if (! Support::layerMethod($this->program, $this->method)) {
            $message = 'Tried to apply unknown method to layers';
            throw new \InvalidArgumentException($message);
        }
        $query->setInputOption(" -layers " . $this->method);
        return $query;
    }
}