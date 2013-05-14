<?php
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 * @since    2012-04-05
 */
/**
 * Class for wrapping image metda data
 *
 * @category   Utility
 * @package    Karla
 * @subpackage Karla
 * @author     Johannes Skov Frandsen <localgod@heaven.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/localgod/Karla Karla
 */
class MetaData extends SplFileInfo
{
    /**
     * Raw image info
     *
     * @var string
     */
    private $verboseImageinfo;

    /**
     * Raw image info
     *
     * @var string
     */
    private $imageinfo;

    /**
     * The image format.
     *
     * @var string
     */
    private $format;

    /**
     * The image depth.
     *
     * @var integer
     */
    private $depth;

    /**
     * The image colorspace.
     *
     * @var string
     */
    private $colorspace;

    /**
     * The image geometry
     *
     * @var array
     */
    private $geometry;

    /**
     * The image resolution
     *
     * @var array
     */
    private $resolution;

    /**
     * The resolution unit is measured in Pixels Per Inch
     * @var boolean
     */
    private $isPpi;

    /**
     * The resolution unit is measured in Pixels Per Centimeter
     * @var boolean
     */
    private $isPpc;

    /**
     * Are we scanning in verbose output from identify
     * @var boolean
     */
    private $verbose;

    /**
     * Construct a new image file.
     *
     * @param string  $imageinfo Image info as string
     * @param boolean $verbose   Should input be parsed as verbose
     *
     * @return void
     */
    public function __construct($imageinfo, $verbose = false)
    {
        $this->verbose = $verbose;
        if ($this->verbose) {
            //exit('not here');
            $this->verboseImageinfo = explode("\n", $imageinfo);
            $this->parseFileformat();
            $this->parseGeometry();
            $this->parseResolution();
            $this->parseUnits();
            $this->parseDepth();
            $this->parseColorspace();
            parent::__construct($this->parseFilename());
        } else {
            $info = explode(" ", $imageinfo);
            $this->imageinfo['Image'] = $info[0];
            $this->imageinfo['Format'] = $info[1];
            $this->imageinfo['Geometry'] = $info[3];
            $this->imageinfo['Depth'] = $info[4];
            $this->imageinfo['Colorspace'] = $info[5];
            $this->imageinfo['Resolution'] = 'x';
            $this->imageinfo['Units'] = '';
            $this->parseFileformat();
            $this->parseGeometry();
            $this->parseResolution();
            $this->parseUnits();
            $this->parseDepth();
            $this->parseColorspace();
            parent::__construct($this->parseFilename());
        }
    }

    /**
     * Get the image resolution.
     * If the resolution is in ppc we convert it to ppi
     *
     * @return array
     */
    private function getResolution()
    {
        if ($this->verbose) {
            if ($this->isPpc) {
                //Here we convert to ppi
                $this->resolution = array($this->ppc2ppi($this->resolution[0]), $this->ppc2ppi($this->resolution[1]));
                $this->isPpc = false;
                $this->isPpi = true;
            }
        } else {
            $this->resolution = array();
        }

        return $this->resolution;
    }

    /**
     * Get the resolution height.
     *
     * @return integer
     */
    public function getResolutionHeight()
    {
        $res = $this->getResolution();

        return isset($res[1]) ? $res[1] : null;
    }

    /**
     * Get the resolution width.
     *
     * @return integer
     */
    public function getResolutionWidth()
    {
        $res = $this->getResolution();

        return isset($res[0]) ? $res[0] : null;
    }

    /**
     * Get file format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Get image depth
     *
     * @return integer
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Get colorspace
     *
     * @return string
     */
    public function getColorspace()
    {
        return $this->colorspace;
    }
    /**
     * Get the image geometry
     *
     * @return array
     */
    public function getGeometry()
    {
        return $this->geometry;
    }

    /**
     * Get the image height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->geometry[1];
    }

    /**
     * Get the image width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->geometry[0];
    }

    /**
     * List the raw image information as a unorder list
     *
     * @return string
     */
    public function listRaw()
    {
        $output = array();
        $output[] = "<ul>";
        $list = $this->verbose ? $this->verboseImageinfo : $this->imageinfo;
        foreach ($list as $key => $line) {
            if ($this->verbose) {
                $output[] = "<li>" . $line . "</li>";
            } else {
                $output[] = "<li>" . $key . ' : ' . $line . "</li>";
            }
        }
        $output[] = "<ul>";

        return implode("\n", $output);
    }

    /**
     * Search for the name of the file
     *
     * @return string
     */
    private function parseFilename()
    {
        return $this->verbose ? $this->parseVerbose('Image') : $this->parse('Image');
    }

    /**
     * Search for file format
     *
     * @return string
     */
    private function parseFileformat()
    {
        $format = $this->verbose ? $this->parseVerbose('Format') : $this->parse('Format');
        preg_match("/^[\s]*[A-Z0-9]+/", $format, $matches);
        if (is_array($matches) && count($matches) == 1) {
            $this->format = strtolower(trim($matches[0]));
        } else {
            $this->format = '';
        }
    }

    /**
     * Search for image geometry
     *
     * @todo output not sanetized yet
     *
     * @return void
     */
    private function parseGeometry()
    {
        $geometry = $this->verbose ? $this->parseVerbose('Geometry') : $this->parse('Geometry');
        preg_match("/^[0-9]*x[0-9]*/", $geometry, $matches);
        //var_dump(explode("x", $matches[0]));
        if (is_array($matches) && count($matches) == 1) {
            $this->geometry = explode("x", $matches[0]);
        } else {
            $this->geometry = '';
        }
    }

    /**
     * Search for image colorspace
     *
     * @return void
     */
    private function parseColorspace()
    {
        $colorspace = $this->verbose ? $this->parseVerbose('Colorspace') : $this->parse('Colorspace');
        preg_match("/^[a-zA-Z0-9]*/", $colorspace, $matches);
        if (is_array($matches)) {
            $this->colorspace = strtolower(trim($matches[0]));
        } else {
            $this->colorspace = '';
        }
    }

    /**
     * Search for image depth
     *
     * @return void
     */
    private function parseDepth()
    {
        $depth = $this->verbose ? $this->parseVerbose('Depth') : $this->parse('Depth');
        preg_match("/^[0-9]*/", $depth, $matches);
        if (is_array($matches)) {
            $this->depth = $matches[0];
        } else {
            $this->depth = '';
        }
    }

    /**
     * Search for image resolution
     *
     * @return void
     */
    private function parseResolution()
    {
        $resolution = $this->verbose ? $this->parseVerbose('Resolution') : $this->parse('Resolution');
        $this->resolution = explode("x", $resolution);
    }

    /**
     * Parse the image info array for the search line and
     * return it for futher processing
     *
     * @param string $search Search string
     *
     * @return string
     */
    private function parseVerbose($search)
    {
        foreach ($this->verboseImageinfo as $line) {
            if (preg_match("/^" . $search . ":/", trim($line))) {
                return trim(str_replace($search . ':', '', $line));
            }
        }
    }

    /**
     * Parse the image info string for the search line and
     * return it for futher processing
     *
     * @param string $search Search string
     *
     * @return string
     */
    private function parse($search)
    {
        return $this->imageinfo[$search];
    }

    /**
     * Search for print unit.
     *
     * If not found we default to Pixels Per Inch.
     *
     * @return void
     */
    private function parseUnits()
    {
        $units = $this->verbose ? $this->parseVerbose('Units') : $this->parse('Units');
        switch ($units) {
            case 'PixelsPerCentimeter' :
                $this->isPpc = true;
                $this->isPpi = false;
                break;

            case 'PixelsPerInch' :
                $this->isPpc = false;
                $this->isPpi = true;
                break;

            case 'Undefined' :
                $this->isPpc = false;
                $this->isPpi = true;
            default :
                $this->isPpc = false;
                $this->isPpi = true;
                break;
        }
    }

    /**
     * Get the resolution unit
     *
     * @return string
     */
    public function getUnit()
    {
        if ($this->isPpi) {
            return 'Pixels Per Inch';
        } else {
            return 'Pixels Per Centimeter';
        }
    }

    /**
     * Get hash of file
     *
     * @param string $hash Name of hash algorithm to use; default is md5
     *
     * @return string
     */
    public function getHash($hash = 'md5')
    {
        if ($hash = 'md5') {
            return md5_file($this->getPathname());
        } else {
            throw new InvalidArgumentException($hash . ' is not a supported hash algorithm');
        }
    }

    /**
     * Convert Pixels Per Centimeter (ppc) to Pixels Per Inch (ppi)
     *
     * @param integer $value Input value
     *
     * @return integer
     */
    private function ppc2ppi($value)
    {
        return intval(floor($value * 0.3937008));
    }

    /**
     * Convert Pixels Per Inch (ppi) to Pixels Per Centimeter (ppc)
     *
     * @param integer $value Input value
     *
     * @return integer
     */
    private function ppi2ppc($value)
    {
        return intval(floor($value * 2.54));
    }
}
