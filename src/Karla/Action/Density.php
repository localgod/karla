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
 * Class for handeling density action
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Density implements Action
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
     * Is it an output argument
     *
     * @var boolean
     */
    private $output;

    /**
     * Set the density of the output image.
     *
     * @param integer $width
     *            The width of the image
     * @param integer $height
     *            The height of the image
     * @param boolean $output
     *            If output is true density is set for the resulting image
     *            If output is false density is used for reading the input image
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function __construct($width, $height, $output)
    {
        if (! is_numeric($width)) {
            $message = 'Width must be numeric values in the density method';
            throw new \InvalidArgumentException($message);
        }
        if (! is_numeric($height)) {
            $message = 'Height must be numeric values in the density method';
            throw new \InvalidArgumentException($message);
        }
        if (! is_bool($output)) {
            $message = 'Output must be aboolean values in the density method';
            throw new \InvalidArgumentException($message);
        }
        $this->width = $width;
        $this->height = $height;
        $this->output = $output;
    }

    /**
     * (non-PHPdoc)
     *
     * @param Query $query
     *            The query to add the action to
     * @return Query
     * @see Action::perform()
     * @throws \BadMethodCallException if density has already been called
     */
    public function perform(Query $query)
    {
        $query->notWith('density', Query::ARGUMENT_TYPE_INPUT);
        $query->notWith('density', Query::ARGUMENT_TYPE_OUTPUT);

        if ($this->output) {
            $query->setOutputOption(" -density " . $this->width . "x" . $this->height);
        } else {
            $query->setInputOption(" -density " . $this->width . "x" . $this->height);
        }
        return $query;
    }
}
