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
 * Class for handeling size action
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Size implements Action
{

    /**
     * Width
     *
     * @var integer
     */
    private $width;

    /**
     * Height
     *
     * @var integer
     */
    private $height;

    /**
     * Construct a new size action
     *
     * @param integer $width
     *            New width
     * @param integer $height
     *            New height
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function __construct($width, $height)
    {
        if ($width == "" && $height == "") {
            $message = 'You must supply height or width or both to size the image';
            throw new \InvalidArgumentException($message);
        }
        $this->width = $width;
        $this->height = $height;
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
        $query->notWith('size', Query::ARGUMENT_TYPE_INPUT);

        $query->setInputOption(" -size " . $this->width . "x" . $this->height . " ");

        return $query;
    }
}