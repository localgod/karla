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
 * @since    2012-04-05
 */

declare(strict_types = 1);
namespace Karla\Program;

use InvalidArgumentException;
use RuntimeException;
use Karla\Action\Resize;
use Karla\Action\Gravity;
use Karla\Action\Density;
use Karla\Action\Profile;
use Karla\Action\Rotate;
use Karla\Action\Background;
use Karla\Action\Resample;
use Karla\Action\Size;
use Karla\Action\Flatten;
use Karla\Action\Strip;
use Karla\Action\Flip;
use Karla\Action\Flop;
use Karla\Action\Type;
use Karla\Action\Layers;
use Karla\Action\Crop;
use Karla\Action\Quality;
use Karla\Action\Colorspace;
use Karla\Action\Sepia;
use Karla\Action\Polaroid;
use Karla\Action\Bordercolor;
use Karla\Program;
use Karla\Cache;
use Karla\Query;

/**
 * Class for wrapping ImageMagicks convert tool
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Convert extends ImageMagick implements Program
{

    /**
     * Input file
     *
     * @var string
     */
    protected $inputFile;

    /**
     * Output file
     *
     * @var string
     */
    protected $outputFile;

    /**
     * Add input argument
     *
     * @param string $filePath
     *            Input file path
     *
     * @return Convert
     * @throws \InvalidArgumentException
     */
    public function in($filePath)
    {
        if (! file_exists($filePath)) {
            $message = 'The input file path (' . $filePath . ') is invalid or the file could not be located.';
            throw new InvalidArgumentException($message);
        }

        if (is_writeable($filePath)) {
            $this->inputFile = '"' . $filePath . '"';
        }
        $this->getQuery()->dirty();

        return $this;
    }

    /**
     * Add output argument
     *
     * @param string $filePath
     *            Output file path
     * @param boolean $includeOptions
     *            Include the used options as part of the filename
     *
     * @return Convert
     * @throws \InvalidArgumentException
     * @todo Implement include options to filename
     */
    public function out($filePath, $includeOptions = false)
    {
        $pathinfo = pathinfo($filePath);
        if (! file_exists($pathinfo['dirname'])) {
            $message = 'The output file path (' . $pathinfo['dirname'] . ') is invalid or could not be located.';
            throw new InvalidArgumentException($message);
        }
        if (! is_writeable($pathinfo['dirname'])) {
            $message = 'The output file path (' . $pathinfo['dirname'] . ') is not writable.';
            throw new InvalidArgumentException($message);
        }
        if (! $includeOptions) {
            $this->outputFile = '"' . $pathinfo['dirname'] . '/' . $pathinfo['basename'] . '"';
        } else {
            // TODO implement this feature
            $this->outputFile = '"' . $pathinfo['dirname'] . '/' . $pathinfo['basename'] . '"';
        }
        $this->getQuery()->dirty();

        return $this;
    }

    /**
     * Get the command to run
     *
     * @see ImageMagick::getCommand()
     * @return string
     */
    public function getCommand()
    {
        if ($this->outputFile == '') {
            throw new RuntimeException('Can not perform convert without an output file');
        }
        if ($this->inputFile == '') {
            throw new RuntimeException('Can not perform convert without an input file');
        }

        ! is_array($this->getQuery()->getOutputOptions()) ? $this->getQuery()->setOutputOption("") : null;
        ! is_array($this->getQuery()->getInputOptions()) ? $this->getQuery()->setInputOption("") : null;
        $inOptions = $this->getQuery()->prepareOptions($this->getQuery()->getInputOptions());
        $outOptions = $this->getQuery()->prepareOptions($this->getQuery()->getOutputOptions());

        return $this->binPath . $this->bin . ' ' . ($inOptions == '' ? '' : $inOptions . ' ') .
               $this->inputFile . ' ' . ($outOptions == '' ? '' : $outOptions . ' ') . $this->outputFile;
    }

    /**
     * Execute the command
     *
     * @see ImageMagick::execute()
     * @return string
     */
    public function execute($reset = true)
    {
        if ($this->cache instanceof Cache) {
            ! is_array($this->getQuery()->getInputOptions()) ? $this->getQuery()->setInputOption("") : null;
            if (! $this->cache->isCached($this->inputFile, $this->outputFile, $this->getQuery()->getInputOptions())) {
                parent::execute(false);
                $this->cache->setCache($this->inputFile, $this->outputFile, $this->getQuery()->getInputOptions());
                $temp = str_replace('"', '', $this->outputFile);
                shell_exec('rm ' . $temp);
                $out = $this->cache->getCached(
                    $this->inputFile,
                    $this->outputFile,
                    $this->getQuery()->getInputOptions()
                );
                $this->getQuery()->reset();
                return $out;
            }
            return $this->cache->getCached($this->inputFile, $this->outputFile, $this->getQuery()->getInputOptions());
        } else {
            $temp = str_replace('"', '', $this->outputFile);
            parent::execute();
            shell_exec('chmod 666 ' . $temp);
            return $this->outputFile;
        }
    }

    /**
     * Raw arguments directly to ImageMagick
     *
     * @param string $arguments
     *            Arguments
     * @param boolean $input
     *            Defaults to an input option, use false to use it as an output option
     *
     * @return Convert
     * @see ImageMagick::raw()
     */
    public function raw($arguments, $input = true)
    {
        parent::raw($arguments, $input);

        return $this;
    }

    /**
     * Set the gravity
     *
     * @param string $gravity
     *            Gravity
     *
     * @return Convert
     */
    public function gravity($gravity)
    {
        $action = new Gravity($this, $gravity);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

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
     * @return Convert
     */
    public function density($width = 72, $height = 72, $output = true)
    {
        $action = new Density($width, $height, $output);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Add a profile to the image.
     *
     * @param string $profilePath
     *            Profile path
     * @param string $profileName
     *            Profile name
     *
     * @return Convert
     */
    public function profile($profilePath = "", $profileName = "")
    {
        $action = new Profile($profilePath, $profileName);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Remove a profile from the image.
     *
     * @param string $profileName
     *            Profile name
     *
     * @return Convert
     *
     * @todo get list of profiles from image (can be done by identify but might be too expensive)
     */
    public function removeProfile($profileName)
    {
        $action = new Profile('', $profileName, true);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Change profile on the image.
     *
     * @param string $profilePathFrom
     *            Path to the profile
     * @param string $profilePathTo
     *            Path to the profile
     *
     * @return Convert
     * @throws \InvalidArgumentException
     */
    public function changeProfile($profilePathFrom, $profilePathTo)
    {
        $this->getQuery()->notWith('profile', Query::ARGUMENT_TYPE_OUTPUT);
        try {
            $this->profile($profilePathFrom);
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage() . ' for input profile';
            throw new InvalidArgumentException($message);
        }
        try {
            $this->profile($profilePathTo);
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage() . ' for output profile';
            throw new InvalidArgumentException($message);
        }

        return $this;
    }

    /**
     * Rotate image
     *
     * @param integer $degree
     *            Degrees to rotate the image
     * @param integer $background
     *            The background color to apply to empty triangles in the corners,
     *            left over from rotating the image
     *
     * @return Convert
     */
    public function rotate($degree, $background = '#ffffff')
    {
        $action = new Rotate($degree);
        $this->setQuery($action->perform($this->getQuery()));
        $this->background($background);
        return $this;
    }

    /**
     * Add a background color to a image
     *
     * @param string $color
     *            Color
     *
     * @return Convert
     */
    public function background($color)
    {
        $action = new Background($color);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Resample the image to a new resolution
     *
     * @param integer $newWidth
     *            New image resolution
     * @param integer $newHeight
     *            New image resolution
     * @param integer $originalWidth
     *            Original image resolution
     * @param integer $originalHeight
     *            Original image resolution
     *
     * @return Convert
     */
    public function resample($newWidth, $newHeight = "", $originalWidth = "", $originalHeight = "")
    {
        if ($originalWidth != "" && $originalHeight != "") {
            $this->density($originalWidth, $originalHeight, false);
        }
        if ($originalWidth != "" && $originalHeight == "") {
            $this->density($originalWidth, $originalWidth, false);
        }

        $action = new Resample($newWidth, $newHeight);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Size the input image
     *
     * @param integer $width
     *            Image width
     * @param integer $height
     *            Image height
     *
     * @return Convert
     */
    public function size($width = "", $height = "")
    {
        $action = new Size($width, $height);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Flatten layers in an image.
     *
     * @return Convert
     */
    public function flatten()
    {
        $action = new Flatten();
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Strip image of any profiles or comments.
     *
     * @return Convert
     */
    public function strip()
    {
        $action = new Strip();
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Flip image
     *
     * @return Convert
     */
    public function flip()
    {
        $action = new Flip();
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Flop image
     *
     * @return Convert
     */
    public function flop()
    {
        $action = new Flop();
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Set output image type
     *
     * @param string $type
     *            The output image type
     *
     * @return Convert
     */
    public function type($type)
    {
        $action = new Type($this, $type);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Apply a method to layers in images.
     *
     * @param string $method
     *            The method to use
     *
     * @return Convert
     */
    public function layers($method)
    {
        $action = new Layers($this, $method);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Resize the input image
     *
     * @param integer $width
     *            Image width
     * @param integer $height
     *            Image height
     * @param boolean $maintainAspectRatio
     *            Should we maintain aspect ratio? default is true
     * @param boolean $dontScaleUp
     *            Should we prohipped scaling up? default is true
     * @param string $aspect
     *            How should we handle aspect ratio?
     *
     * @return Convert
     */
    public function resize(
        $width = "",
        $height = "",
        $maintainAspectRatio = true,
        $dontScaleUp = true,
        $aspect = Resize::ASPECT_FIT
    ) {
        $action = new Resize($width, $height, $maintainAspectRatio, $dontScaleUp, $aspect);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Resize the input image
     *
     * @param integer $width
     *            Image width
     * @param integer $height
     *            Image height
     * @param integer $xOffset
     *            X offset from upper-left corner
     * @param integer $yOffset
     *            Y offset from upper-left corner
     *
     * @return Convert
     */
    public function crop($width, $height, $xOffset = 0, $yOffset = 0)
    {
        $action = new Crop($width, $height, $xOffset, $yOffset);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Set the quality of the output image for jpeg an png.
     *
     * @param integer $quality
     *            A value between 0 - 100
     * @param string $format
     *            Format to use; default is jpeg
     *
     * @return Convert
     */
    public function quality($quality, $format = 'jpeg')
    {
        $action = new Quality($quality, $format);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Set the colorspace for the image
     *
     * @param string $colorSpace
     *            The colorspace to use
     *
     * @return Convert
     */
    public function colorspace($colorSpace)
    {
        $action = new Colorspace($this, $colorSpace);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Sepia tone the image
     *
     * @param string $threshold
     *            The threshold to use
     *
     * @return Convert
     */
    public function sepia($threshold = 80)
    {
        $action = new Sepia($threshold);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Add polaroid effect to the image
     *
     * @param integer $angle
     *            The threshold to use
     *
     * @return Convert
     */
    public function polaroid($angle = 0)
    {
        $action = new Polaroid($angle);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Set the color of the border if border is set
     *
     * @param string $color
     *            The color of the border
     *
     * @return Convert
     */
    public function bordercolor($color = '#DFDFDF')
    {
        $action = new Bordercolor($color);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }
}
