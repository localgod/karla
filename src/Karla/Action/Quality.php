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

namespace Karla\Action;

use Karla\Query;
use Karla\Action;

/**
 * Class for handeling quality action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Quality implements Action
{

    /**
     * The quality to use
     *
     * @var integer
     */
    private $quality;

    /**
     * The format to use
     *
     * @var string
     */
    private $format;

    /**
     * Construct a new quality action
     *
     * @param integer $quality
     *            Quality
     * @param string $format
     *            Format
     *
     * @throws \InvalidArgumentException
     * @throws \RangeException
     */
    public function __construct($quality, $format)
    {
        if (! preg_match('/^jpeg|jpg|png$/', $format)) {
            $message = "'quality()' is only supported for the jpeg and png format. Used (" . $format . ")";
            throw new \InvalidArgumentException($message);
        }
        if (! is_numeric($quality)) {
            $message = "quality argument must be an integer value. Used (" . $quality . ")";
            throw new \InvalidArgumentException($message);
        }
        if (! ($quality >= 0 && $quality <= 100)) {
            $message = "quality argument must be between 0 and 100 both inclusive. Used (" . $quality . ")";
            throw new \RangeException($message);
        }
        $this->quality = (int) $quality;
        $this->format = $format;
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
        $query->notWith('quality', Query::ARGUMENT_TYPE_INPUT);

        $query->setInputOption(" -quality " . $this->quality);
        return $query;
    }
}
