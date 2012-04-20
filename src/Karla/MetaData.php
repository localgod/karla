<?php
/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 5
 *
 * @category Utility
 * @package  Karla
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
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
 * @author     Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/localgod/Karla Karla
 */
class MetaData extends SplFileInfo {
    /**
     * Raw image info
     *
     * @var string
     */
    private $_imageinfo;
    /**
     * The image format.
     *
     * @var string
     */
    private $_format;
    /**
     * The image depth.
     *
     * @var integer
     */
    private $_depth;
    /**
     * The image colorspace.
     *
     * @var string
     */
    private $_colorspace;
    /**
     * The image geometry
     *
     * @var array
     */
    private $_geometry;
    /**
     * The image resolution
     *
     * @var array
     */
    private $_resolution;
    /**
     * The resolution unit is measured in Pixels Per Inch
     * @var boolean
     */
    private $_isPpi;
    /**
     * The resolution unit is measured in Pixels Per Centimeter
     * @var boolean
     */
    private $_isPpc;
    /**
     * Construct a new image file.
     *
     * @param string $imageinfo Image info as string
     *
     * @return void
     */
    public function __construct($imageinfo) {
        $this->_imageinfo = explode("\n", $imageinfo);
        $this->_parseFileformat();
        $this->_parseGeometry();
        $this->_parseResolution();
        $this->_parseUnits();
        $this->_parseDepth();
        $this->_parseColorspace();
        parent::__construct($this->_parseFilename());
    }
    /**
     * Get the image resolution.
     * If the resolution is in ppc we convert it to ppi
     *
     * @return array
     */
    private function _getResolution() {
        if ($this->_isPpc) {
            //Here we convert to ppi
            $this->_resolution = array(
                $this->_ppc2ppi($this->_resolution[0]) ,
                $this->_ppc2ppi($this->_resolution[1])
            );
            $this->_isPpc = false;
            $this->_isPpi = true;
        }
        return $this->_resolution;
    }
    /**
     * Get the resolution height.
     *
     * @return integer
     */
    public function getResolutionHeight() {
        $res = $this->_getResolution();
        return $res[1];
    }
    /**
     * Get the resolution width.
     *
     * @return integer
     */
    public function getResolutionWidth() {
        $res = $this->_getResolution();
        return $res[0];
    }
    /**
     * Get file format
     *
     * @return string
     */
    public function getFormat() {
        return $this->_format;
    }
    /**
     * Get image depth
     *
     * @return integer
     */
    public function getDepth() {
        return $this->_depth;
    }
    /**
     * Get colorspace
     *
     * @return string
     */
    public function getColorspace() {
        return $this->_colorspace;
    }
    /**
     * Get the image geometry
     *
     * @return array
     */
    public function getGeometry() {
        return $this->_geometry;
    }
    /**
     * Get the image height
     *
     * @return integer
     */
    public function getHeight() {
        return $this->_geometry[1];
    }
    /**
     * Get the image width
     *
     * @return integer
     */
    public function getWidth() {
        return $this->_geometry[0];
    }
    /**
     * List the raw image information as a unorder list
     *
     * @return string
     */
    public function listRaw() {
        $output = array();
        $output[] = "<ul>";
        foreach ($this->_imageinfo as $line) {
            $output[] = "<li>" . $line . "</li>";
        }
        $output[] = "<ul>";
        return implode("\n", $output);
    }
    /**
     * Search for the name of the file
     *
     * @return string
     */
    private function _parseFilename() {
        return $this->_parse('Image');
    }
    /**
     * Search for file format
     *
     * @return string
     */
    private function _parseFileformat() {
        preg_match("/^[\s]*[A-Z0-9]+/", $this->_parse('Format'), $matches);
        if (is_array($matches) && sizeof($matches) == 1) {
            $this->_format = strtolower(trim($matches[0]));
        } else {
            $this->_format = '';
        }
    }
    /**
     * Search for image geometry
     *
     * @todo output not sanetized yet
     *
     * @return void
     */
    private function _parseGeometry() {
        preg_match("/^[0-9]*x[0-9]*/", $this->_parse('Geometry'), $matches);
        if (is_array($matches) && sizeof($matches) == 1) {
            $this->_geometry = explode("x", $matches[0]);
        } else {
            $this->_geometry = '';
        }
    }
    /**
     * Search for image colorspace
     *
     * @return void
     */
    private function _parseColorspace() {
        preg_match("/^[a-zA-Z0-9]*/", $this->_parse('Colorspace'), $matches);
        if (is_array($matches)) {
            $this->_colorspace = strtolower(trim($matches[0]));
        } else {
            $this->_colorspace = '';
        }
    }
    /**
     * Search for image depth
     *
     * @return void
     */
    private function _parseDepth() {
        preg_match("/^[0-9]*/", $this->_parse('Depth'), $matches);
        if (is_array($matches)) {
            $this->_depth = $matches[0];
        } else {
            $this->_depth = '';
        }
    }
    /**
     * Search for image resolution
     *
     * @return void
     */
    private function _parseResolution() {
        $this->_resolution = explode("x", $this->_parse('Resolution'));
    }
    /**
     * Parse the image info array for the search line and return it for futher processing
     *
     * @param string $search - search string
     *
     * @return string
     */
    private function _parse($search) {
        foreach ($this->_imageinfo as $line) {
            if (preg_match("/^" . $search . ":/", trim($line))) {
                return trim(str_replace($search . ':', '', $line));
            }
        }
    }
    /**
     * Search for print unit.
     * 
     * If not found we default to Pixels Per Inch.
     *
     * @return void
     */
    private function _parseUnits() {
        switch ($this->_parse('Units')) {
        case 'PixelsPerCentimeter':
            $this->_isPpc = true;
            $this->_isPpi = false;
            break;

        case 'PixelsPerInch':
            $this->_isPpc = false;
            $this->_isPpi = true;
            break;

        case 'Undefined':
            $this->_isPpc = false;
            $this->_isPpi = true;
        default:
            $this->_isPpc = false;
            $this->_isPpi = true;
            break;
        }
    }
    /**
     * Get the resolution unit
     *
     * @return string
     */
    public function getUnit() {
        if ($this->_isPpi) {
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
    public function getHash($hash = 'md5') {
        if ($hash = 'md5') {
            return md5_file($this->getPathname());
        } else {
            throw new InvalidArgumentException($hash.' is not a supported hash algorithm');
        }
    }
    /**
     * Convert Pixels Per Centimeter (ppc) to Pixels Per Inch (ppi)
     *
     * @param integer $value Input value
     *
     * @return integer
     */
    private function _ppc2ppi($value) {
        return intval(floor($value * 0.3937008));
    }
    /**
     * Convert Pixels Per Inch (ppi) to Pixels Per Centimeter (ppc)
     *
     * @param integer $value Input value
     *
     * @return integer
     */
    private function _ppi2ppc($value) {
        return intval(floor($value * 2.54));
    }
}
