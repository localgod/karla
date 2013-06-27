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
 * @since    2012-04-05
 */
namespace Karla\Program;

use Karla\Color;

/**
 * Class for wrapping ImageMagicks convert tool
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Convert extends ImageMagick implements \Karla\Program
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
    public function inputfile($filePath)
    {
        if (! file_exists($filePath)) {
            $message = 'The input file path (' . $filePath . ') is invalid or the file could not be located.';
            throw new \InvalidArgumentException($message);
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
    public function outputfile($filePath, $includeOptions = false)
    {
        $pathinfo = pathinfo($filePath);
        if (! file_exists($pathinfo['dirname'])) {
            $message = 'The output file path (' . $pathinfo['dirname'] . ') is invalid or could not be located.';
            throw new \InvalidArgumentException($message);
        }
        if (! is_writeable($pathinfo['dirname'])) {
            $message = 'The output file path (' . $pathinfo['dirname'] . ') is not writable.';
            throw new \InvalidArgumentException($message);
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
            throw new \RuntimeException('Can not perform convert without an output file');
        }
        if ($this->inputFile == '') {
            throw new \RuntimeException('Can not perform convert without an input file');
        }

        ! is_array($this->getQuery()->getOutputOptions()) ? $this->getQuery()->setOutputOption(array()) : null;
        ! is_array($this->getQuery()->getInputOptions()) ? $this->getQuery()->setInputOptions(array()) : null;
        $inOptions = $this->getQuery()->prepareOptions($this->getQuery()
            ->getInputOptions()) == '' ? '' : $this->getQuery()->prepareOptions($this->getQuery()
            ->getInputOptions()) . ' ';
        $outOptions = $this->getQuery()->prepareOptions($this->getQuery()
            ->getOutputOptions()) == '' ? '' : $this->getQuery()->prepareOptions($this->getQuery()
            ->getOutputOptions()) . ' ';

        return $this->binPath . $this->bin . ' ' . $inOptions . $this->inputFile . ' ' . $outOptions . $this->outputFile;
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
        $action = new \Karla\Action\Gravity($this, $gravity);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Execute the command
     *
     * @see ImageMagick::execute()
     * @return string
     */
    public function execute()
    {
        if ($this->cache instanceof \Karla\Cache) {
            ! is_array($this->getQuery()->getInputOptions()) ? $this->getQuery()->setInputOption(array()) : null;
            if ($this->cache->isCached($this->inputFile, $this->getQuery()
                ->getInputOptions())) {
                return $this->cache->getCached($this->inputFile, $this->getQuery()
                    ->getInputOptions());
            } else {
                $this->outputFile = $this->cache->setCache($this->inputFile, $this->getQuery()
                    ->getInputOptions());
            }
        } else {
            $temp = $this->outputFile;
            parent::execute();
            // For some reason php's chmod can't see the file
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
        $action = new \Karla\Action\Density($width, $height, $output);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Add a profile to the image.
     *
     * @param string $profilePath
     *            Path to the profile
     *
     * @return Convert
     * @throws \InvalidArgumentException
     */
    public function profile($profilePath)
    {
        if (! file_exists($profilePath)) {
            $message = 'Could not add profile as input file (' . $profilePath . ') could not be found.';
            throw new \InvalidArgumentException($message);
        }

        $this->getQuery()->setOutputOption(' -profile "' . $profilePath . '" ');

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
     * @todo get list of profiles from image (can be done by identify but might be to expensive)
     */
    public function removeProfile($profileName)
    {
        $this->getQuery()->setInputOption(" +profile " . $profileName);
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
     * @throws \BadMethodCallException if changeprofile has already been called
     * @throws \InvalidArgumentException
     */
    public function changeProfile($profilePathFrom, $profilePathTo)
    {
        if ($this->getQuery()->isOptionSet('profile', $this->getQuery()
            ->getOutputOptions())) {
            $message = "'changeProfile()' can only be called once and not at the same time as 'profile()'.";
            throw new \BadMethodCallException($message);
        }
        if (! file_exists($profilePathFrom)) {
            $message = 'Could not add input profile as input file (' . $profilePathFrom . ') could not be found.';
            throw new \InvalidArgumentException($message);
        }
        if (! file_exists($profilePathTo)) {
            $message = 'Could not add output profile as input file (' . $profilePathTo . ') could not be found.';
            throw new \InvalidArgumentException($message);
        }
        $this->profile($profilePathFrom);
        $this->profile($profilePathTo);

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
     * @throws \BadMethodCallException if rotate has already been called
     */
    public function rotate($degree, $background = '#ffffff')
    {
        $this->getQuery()->notWith('rotate', \Karla\Query::ARGUMENT_TYPE_INPUT);
        $this->getQuery()->setInputOption(' -rotate "' . $degree . '"');
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
     * @throws \BadMethodCallException if background has already been called
     */
    public function background($color)
    {
        $action = new \Karla\Action\Background($color);
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
     * @throws \BadMethodCallException if resample, resize or density has already been called
     * @throws \InvalidArgumentException
     */
    public function resample($newWidth, $newHeight = "", $originalWidth = "", $originalHeight = "")
    {
        if ($originalWidth != "" && $originalHeight != "") {
            $action = new \Karla\Action\Density($originalWidth, $originalHeight, false);
            $this->setQuery($action->perform($this->getQuery()));
        }
        if ($originalWidth != "" && $originalHeight == "") {
            $action = new \Karla\Action\Density($originalWidth, $originalWidth, false);
            $this->setQuery($action->perform($this->getQuery()));
        }

        $action = new \Karla\Action\Resample($newWidth, $newHeight);
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
     * @throws \BadMethodCallException if size has already been called
     * @throws \InvalidArgumentException
     */
    public function size($width = "", $height = "")
    {
        $action = new \Karla\Action\Size($width, $height);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Flatten layers in an image.
     *
     * @return Convert
     * @throws \BadMethodCallException if flatten has already been called
     * @throws \InvalidArgumentException
     */
    public function flatten()
    {
        $action = new \Karla\Action\Flatten();
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }

    /**
     * Strip image of any profiles or comments.
     *
     * @return Convert
     * @throws \BadMethodCallException if strip has already been called
     * @throws \InvalidArgumentException
     */
    public function strip()
    {
        $action = new \Karla\Action\Strip();
        $this->setQuery($action->perform($this->getQuery()));

        return $this;
    }

    /**
     * Flip image
     *
     * @return Convert
     * @throws \BadMethodCallException if flip has already been called
     */
    public function flip()
    {
        $action = new \Karla\Action\Flip();
        $this->setQuery($action->perform($this->getQuery()));

        return $this;
    }

    /**
     * Flop image
     *
     * @return Convert
     * @throws \BadMethodCallException if strip has already been called
     */
    public function flop()
    {
        $action = new \Karla\Action\Flop();
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
     * @throws \InvalidArgumentException
     * @throws \BadMethodCallException if type has already been called
     */
    public function type($type)
    {
        $type = new \Karla\Action\Type($this, $type);
        $this->setQuery($type->perform($this->getQuery()));

        return $this;
    }

    /**
     * Apply a method to layers in images.
     *
     * @param string $method
     *            The method to use
     *
     * @return Convert
     * @throws \InvalidArgumentException if the layer method wasn't recognized
     */
    public function layers($method)
    {
        $action = new \Karla\Action\Layers($this, $method);
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
     *
     * @return Convert
     * @throws \InvalidArgumentException
     * @throws \BadMethodCallException if resize has already been called
     */
    public function resize($width = "", $height = "", $maintainAspectRatio = true, $dontScaleUp = true)
    {
        $action = new \Karla\Action\Resize($width, $height, $maintainAspectRatio, $dontScaleUp);
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
     * @throws \InvalidArgumentException
     * @throws \BadMethodCallException if crop has already been called
     */
    public function crop($width, $height, $xOffset = 0, $yOffset = 0)
    {
        $action = new \Karla\Action\Crop($width, $height, $xOffset, $yOffset);
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
     * @throws \InvalidArgumentException
     * @throws \BadMethodCallException if quality has already been called
     * @throws \RangeException if quality is not a value between 0 - 100
     *
     * @return Convert
     */
    public function quality($quality, $format = 'jpeg')
    {
        $action = new \Karla\Action\Quality($quality, $format);
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
     * @throws \InvalidArgumentException
     * @throws \BadMethodCallException if colorspace has already been called
     */
    public function colorspace($colorSpace)
    {
        $action = new \Karla\Action\Colorspace($this, $colorSpace);
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
     * @throws \InvalidArgumentException
     * @throws \BadMethodCallException if sepia has already been called
     */
    public function sepia($threshold = 80)
    {
        $action = new \Karla\Action\Sepia($threshold);
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
     * @throws \InvalidArgumentException
     * @throws \BadMethodCallException if angle has already been called
     */
    public function polaroid($angle = 0)
    {
        $action = new \Karla\Action\Polaroid($angle);
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
     * @throws \BadMethodCallException if borderColor has already been called
     */
    public function bordercolor($color = '#DFDFDF')
    {
        $action = new \Karla\Action\Bordercolor($color);
        $this->setQuery($action->perform($this->getQuery()));
        return $this;
    }
}
