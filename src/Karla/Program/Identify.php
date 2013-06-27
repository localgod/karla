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

/**
 * Class for wrapping ImageMagicks identify tool
 *
 * @category Utility
 * @package Karla
 * @author Johannes Skov Frandsen <localgod@heaven.dk>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/localgod/Karla Karla
 */
class Identify extends ImageMagick
{

    /**
     * Input file
     *
     * @var string
     */
    protected $inputFile;

    /**
     * Add input argument
     *
     * @param string $filePath
     *            Input file path
     *
     * @return Identify
     * @throws \InvalidArgumentException
     */
    public function inputfile($filePath)
    {
        if (! file_exists($filePath)) {
            $message = 'The input file path (' . $filePath . ') is invalid or the file could not be located.';
            throw new \InvalidArgumentException($message);
        }
        $file = new \SplFileObject($filePath);
        if ($file->isReadable()) {
            $this->inputFile = '"' . $file->getPathname() . '"';
        }
        $this->getQuery()->dirty();

        return $this;
    }

    /**
     * Execute the command
     *
     * @param boolean $reset
     *            Reset the query
     * @param boolean $raw
     *            Get the raw output
     *
     * @see Imagemagick#execute()
     * @return string MetaData
     */
    public function execute($reset = true, $raw = true)
    {
        $result = parent::execute(false);

        if (! $raw) {
            if ($this->getQuery()->isOptionSet('verbose', $this->getQuery()
                ->getInputOptions())) {
                $reset == true ? $this->getQuery()->reset() : null;
                return new \Karla\MetaData($result, true);
            }
            $reset == true ? $this->getQuery()->reset() : null;
            return new \Karla\MetaData($result);
        }

        $reset == true ? $this->getQuery()->reset() : null;
        return trim($result);
    }

    /**
     * Add verbose argument
     *
     * @return Identify
     */
    public function verbose()
    {
        $this->getQuery()->notWith('verbose', \Karla\Query::ARGUMENT_TYPE_INPUT);
        $this->getQuery()->setInputOption("-verbose ");

        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Imagemagick#getCommand()
     * @return string
     */
    public function getCommand()
    {
        ! is_array($this->getQuery()->getInputOptions()) ? $this->getQuery()->setInputOption(array()) : null;
        $options = $this->getQuery()->prepareOptions($this->getQuery()
            ->getInputOptions()) == '' ? '' : $this->getQuery()->prepareOptions($this->getQuery()
            ->getInputOptions()) . ' ';

        return $this->binPath . $this->bin . ' ' . $options . $this->inputFile;
    }

    /**
     * Raw arguments directly to ImageMagick
     *
     * @param string $arguments
     *            Arguments
     * @param boolean $input
     *            Defaults to an input option, use false to use it as an output option
     *
     * @return Identify
     * @see ImageMagick::raw()
     */
    public function raw($arguments, $input = true)
    {
        parent::raw($arguments, $input);

        return $this;
    }
}