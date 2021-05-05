<?php

/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 7.4<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2013-05-26
 */

declare(strict_types = 1);
namespace Karla\Action;

use Karla\Query;
use Karla\Action;

/**
 * Class for handeling size action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
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
     * @throws \InvalidArgumentException
     */
    public function __construct($width, $height)
    {
        if ($width == "" && $height == "") {
            $message = 'You must supply height or width or both to size the image';
            throw new \InvalidArgumentException($message);
        }
        $this->width = (int) $width;
        $this->height = (int) $height;
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
