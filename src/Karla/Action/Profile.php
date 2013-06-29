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
 * Class for handeling profile action
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Profile implements Action
{

    /**
     * Profile path
     *
     * @var string
     */
    private $profilePath;

    /**
     * Profile path
     *
     * @var string
     */
    private $profileName;

    /**
     * Construct a new profile action
     *
     * @param string $profilePath
     *            Profile path
     * @param string $profileName
     *            Profile path
     *
     * @return void
     * @throws \LogicException profilePath or profileName must be set, but not both.
     * @throws \InvalidArgumentException If profile input file (' . $profilePath . ') could not be found.
     */
    public function __construct($profilePath = "", $profileName = "")
    {
        if (($profilePath == '' && $profileName == '') || ($profilePath != '' && $profileName != '')) {
            $message = 'profilePath or profileName must be set, but not both.';
            throw new \LogicException($message);
        }
        if ($profilePath != '' && ! file_exists($profilePath)) {
            $message = 'Profile input file (' . $profilePath . ') could not be found';
            throw new \InvalidArgumentException($message);
        }
        $this->profilePath = $profilePath;
        $this->profileName = $profileName;
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
        if ($this->profilePath != '') {
            $query->setOutputOption(' -profile "' . $this->profilePath . '" ');
        } else {
            $query->setInputOption(" +profile " . $this->profileName);
        }

        return $query;
    }
}