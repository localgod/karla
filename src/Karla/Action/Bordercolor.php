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
use Karla\Color;

/**
 * Class for handeling bordercolor action
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Bordercolor implements Action
{

    /**
     * Color
     *
     * @var string
     */
    private $color;

    /**
     * Construct new bordercolor action
     *
     * @param integer $color
     *            Color
     *
     * @return void
     */
    public function __construct($color)
    {
        $this->color = $color;
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
        $query->notWith('bordercolor', \Karla\Query::ARGUMENT_TYPE_INPUT);

        if (Color::validHexColor($this->color) || Color::validRgbColor($this->color) || Color::validColorName($this->color)) {
            if (Color::validColorName($this->color)) {
                $query->setInputOption(' -bordercolor ' . $this->color);
            } else {
                $query->setInputOption(' -bordercolor "' . $this->color . '"');
            }
        } else {
            throw new \InvalidArgumentException('The color supplied could not be parsed');
        }
        return $query;
    }
}