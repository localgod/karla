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
 * Class for handeling resample action
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Resample implements Action
{

    /**
     * New width
     *
     * @var integer
     */
    private $newWidth;

    /**
     * New height
     *
     * @var integer
     */
    private $newHeight;

    /**
     * Construct a new size action
     *
     * @param integer $newWidth
     *            New width
     * @param integer $newHeight
     *            New height
     * @return void
     */
    public function __construct($newWidth, $newHeight)
    {
        $this->newWidth = $newWidth;
        $this->newHeight = $newHeight;
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
        $query->notWith('resample', Query::ARGUMENT_TYPE_INPUT);
        $query->notWith('resize', Query::ARGUMENT_TYPE_INPUT);

        if (! is_numeric($this->newWidth)) {
            $message = 'You must supply new width as a integer.
                    Was (' . $this->newWidth . ')';
            throw new \InvalidArgumentException($message);
        }
        if ($this->newHeight != '' && ! is_numeric($this->newHeight)) {
            $message = 'You must supply new height as a integer or as an empty string.
                    Was (' . $this->newHeight . ')';
            throw new \InvalidArgumentException($message);
        }

        $option = " -resample '";
        if ($this->newWidth != "" && $this->newHeight != "") {
            $option = $option . $this->newWidth . "x" . $this->newHeight;
        } elseif ($this->newWidth != "") {
            $option = $option . $this->newWidth;
        }
        $option = $option . "' ";
        $query->setInputOption($option);

        return $query;
    }
}