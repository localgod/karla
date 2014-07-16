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
 * Class for handeling quality action
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
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
     * @return void
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
        $this->quality = $quality;
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
