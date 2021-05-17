<?php

/**
 * Karla ImageMagick wrapper library
 *
 * PHP Version 8.0<
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */

declare(strict_types=1);

namespace Karla;

/**
 * Class for wrapping image metadata
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class MetaData extends \SplFileInfo
{

    /**
     * Raw image info
     *
     * @var string[]
     */
    private array $verboseImageinfo;

    /**
     * Raw image info
     *
     * @var array
     */
    private array $imageinfo;

    /**
     * The image format.
     *
     * @var string
     */
    private string $format;

    /**
     * The image depth.
     *
     * @var integer
     */
    private int $depth;

    /**
     * The image colorspace.
     *
     * @var string
     */
    private string $colorspace;

    /**
     * The image geometry
     *
     * @var array
     */
    private array $geometry;

    /**
     * The image resolution
     *
     * @var array
     */
    private array $resolution;

    /**
     * The resolution unit is measured in Pixels Per Inch
     *
     * @var boolean
     */
    private bool $isPpi;

    /**
     * The resolution unit is measured in Pixels Per Centimeter
     *
     * @var boolean
     */
    private bool $isPpc;

    /**
     * Are we scanning in verbose output from identify
     *
     * @var boolean
     */
    private bool $verbose;

    /**
     * Construct a new image file.
     *
     * @param string $imageinfo
     *            Image info as string
     * @param boolean $verbose
     *            Should input be parsed as verbose
     */
    public function __construct(string $imageinfo, bool $verbose = false)
    {
        $this->verbose = $verbose;
        if ($this->verbose) {
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
    private function getResolution(): array
    {
        if ($this->verbose) {
            if ($this->isPpc) {
                // Here we convert to ppi
                $this->resolution = array(
                    $this->ppc2ppi($this->resolution[0]),
                    $this->ppc2ppi($this->resolution[1])
                );
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
    public function getResolutionHeight(): int|null
    {
        $res = $this->getResolution();
        return isset($res[1]) ? (int) $res[1] : null;
    }

    /**
     * Get the resolution width.
     *
     * @return integer
     */
    public function getResolutionWidth(): int|null
    {
        $res = $this->getResolution();

        return isset($res[0]) ? (int) $res[0] : null;
    }

    /**
     * Get file format
     *
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * Get image depth
     *
     * @return integer
     */
    public function getDepth(): int
    {
        return $this->depth;
    }

    /**
     * Get colorspace
     *
     * @return string
     */
    public function getColorspace(): string
    {
        return $this->colorspace;
    }

    /**
     * Get the image geometry
     *
     * @return array
     */
    public function getGeometry(): array
    {
        return $this->geometry;
    }

    /**
     * Get the image height
     *
     * @return integer
     */
    public function getHeight(): int
    {
        return (int) $this->geometry[1];
    }

    /**
     * Get the image width
     *
     * @return integer
     */
    public function getWidth(): int
    {
        return (int) $this->geometry[0];
    }

    /**
     * List the raw image information as a unorder list
     *
     * @return string
     */
    public function listRaw(): string
    {
        $output = array();
        $output[] = "<ul>";
        $list = $this->verbose ? $this->verboseImageinfo : $this->imageinfo;
        if (is_array($list)) {
            foreach ($list as $key => $line) {
                if ($this->verbose) {
                    $output[] = "<li>" . $line . "</li>";
                } else {
                    $output[] = "<li>" . $key . ' : ' . $line . "</li>";
                }
            }
        } else {
            $output[] = "<li>" . $this->imageinfo . "</li>";
        }
        $output[] = "<ul>";

        return implode("\n", $output);
    }

    /**
     * Search for the name of the file
     *
     * @return string
     */
    private function parseFilename(): string
    {
        return $this->verbose ? $this->parseVerbose('Image') : $this->parse('Image');
    }

    /**
     * Search for file format
     *
     * @return void
     */
    private function parseFileformat(): void
    {
        $format = $this->verbose ? $this->parseVerbose('Format') : $this->parse('Format');
        $matches = [];
        preg_match("/^[\s]*[A-Z0-9]+/", $format, $matches);
        if (count($matches) == 1) {
            $this->format = strtolower(trim($matches[0]));
        }
    }

    /**
     * Search for image geometry
     *
     * @todo output not sanetized yet
     *
     * @return void
     */
    private function parseGeometry(): void
    {
        $geometry = $this->verbose ? $this->parseVerbose('Geometry') : $this->parse('Geometry');
        $matches = [];
        preg_match("/^[0-9]*x[0-9]*/", $geometry, $matches);
        if (count($matches) == 1) {
            $this->geometry = explode("x", $matches[0]);
        }
    }

    /**
     * Search for image colorspace
     *
     * @return void
     */
    private function parseColorspace(): void
    {
        $colorspace = $this->verbose ? $this->parseVerbose('Colorspace') : $this->parse('Colorspace');
        $matches = [];
        preg_match("/^[a-zA-Z0-9]*/", $colorspace, $matches);
        $this->colorspace = strtolower(trim($matches[0]));
    }

    /**
     * Search for image depth
     *
     * @return void
     */
    private function parseDepth(): void
    {
        $depth = $this->verbose ? $this->parseVerbose('Depth') : $this->parse('Depth');
        $matches = [];
        preg_match("/^[0-9]*/", $depth, $matches);
        $this->depth = (int) $matches[0];
    }

    /**
     * Search for image resolution
     *
     * @return void
     */
    private function parseResolution(): void
    {
        $resolution = $this->verbose ? $this->parseVerbose('Resolution') : $this->parse('Resolution');
        $this->resolution = explode("x", $resolution);
    }

    /**
     * Parse the image info array for the search line and
     * return it for futher processing
     *
     * @param string $search
     *            Search string
     *
     * @return string
     */
    private function parseVerbose($search): string
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
     * @param string $search
     *            Search string
     *
     * @return string
     */
    private function parse($search): string
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
    private function parseUnits(): void
    {
        $units = $this->verbose ? $this->parseVerbose('Units') : $this->parse('Units');
        switch ($units) {
            case 'PixelsPerCentimeter':
                $this->isPpc = true;
                $this->isPpi = false;
                break;

            case 'PixelsPerInch':
                $this->isPpc = false;
                $this->isPpi = true;
                break;

            case 'Undefined':
                $this->isPpc = false;
                $this->isPpi = true;
                break;

            default:
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
    public function getUnit(): string
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
     * @param string $hash
     *            Name of hash algorithm to use; default is md5
     *
     * @return string
     */
    public function getHash(string $hash = 'md5'): string
    {
        if ($hash == 'md5') {
            return md5_file($this->getPathname());
        } else {
            throw new \InvalidArgumentException($hash . ' is not a supported hash algorithm');
        }
    }

    /**
     * Convert Pixels Per Centimeter (ppc) to Pixels Per Inch (ppi)
     *
     * @param integer $value
     *            Input value
     *
     * @return integer
     */
    private function ppc2ppi(int $value): int
    {
        return intval(floor($value * 0.3937008));
    }

    /**
     * Convert Pixels Per Inch (ppi) to Pixels Per Centimeter (ppc)
     *
     * @param integer $value
     *            Input value
     *
     * @return integer
     */
    private function ppi2ppc(int $value): int
    {
        return intval(floor($value * 2.54));
    }
}
