<?php
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5.3<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2013-05-26
 */
namespace Karla\Action;

use Karla\Query;
use Karla\Action;

/**
 * Class for handeling profile action
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
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
     * Profile name
     *
     * @var string
     */
    private $profileName;
    
    /**
     * Remove profile
     *
     * @var boolean
     */
    private $remove;

    /**
     * Construct a new profile action
     *
     * @param string $profilePath
     *            Profile path
     * @param string $profileName
     *            Profile name
     * @param boolean $remove
     *            Should the profile be removed? (default is false)
     *
     * @return void
     * @throws \LogicException profilePath or profileName must be set, but not both.
     * @throws \InvalidArgumentException If profile input file (' . $profilePath . ') could not be found.
     */
    public function __construct($profilePath = "", $profileName = "", $remove = false)
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
        $this->remove = $remove;
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
            $query->setOutputOption(' '. ($this->remove ? '+' : '-') .'profile "' . $this->profilePath . '" ');
        } else {
            $query->setOutputOption(' '. ($this->remove ? '+' : '-') .'profile ' . $this->profileName);
        }

        return $query;
    }
}
