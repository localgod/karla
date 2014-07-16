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
namespace Karla;

/**
 * Class for maintaining query info
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Query
{

    /**
     * This argument is to be considered for the input image
     *
     * @var interger
     */
    const ARGUMENT_TYPE_INPUT = 0;

    /**
     * This argument is to be considered for the output image
     *
     * @var integer
     */
    const ARGUMENT_TYPE_OUTPUT = 1;

    /**
     * Is the object dirty (has any arguments been set)
     *
     * @var boolean
     */
    private $dirty;

    /**
     * Input option
     *
     * @var Array
     */
    protected $inputOptions;

    /**
     * Output option
     *
     * @var Array
     */
    protected $outputOptions;

    /**
     * Set input option
     *
     * @param string $option
     *            Option to set
     *
     * @return void
     */
    public function setInputOption($option)
    {
        $this->inputOptions[] = $option;
        $this->dirty();
    }

    /**
     * Get input option
     *
     * @return array
     */
    public function getInputOptions()
    {
        return $this->inputOptions;
    }

    /**
     * Set output option
     *
     * @param string $option
     *            Option to set
     *
     * @return void
     */
    public function setOutputOption($option)
    {
        $this->outputOptions[] = $option;
        $this->dirty();
    }

    /**
     * Get output options
     *
     * @return array:
     */
    public function getOutputOptions()
    {
        return $this->outputOptions;
    }

    /**
     * Set the object as beeing dirty
     *
     * (Arguments has been set)
     *
     * @return void
     */
    public function dirty()
    {
        $this->dirty = true;
    }

    /**
     * Reset the command
     *
     * @return void
     */
    public function reset()
    {
        $this->inputOptions = array();
        $this->outputOptions = array();
        $this->dirty = false;
    }

    /**
     * Check if an option is already set
     *
     * @param string $lookop
     *            Option to look up
     * @param array $optionList
     *            Optionlist to look in
     *
     * @return boolean
     */
    final public function isOptionSet($lookop, array $optionList)
    {
        foreach ($optionList as $option) {
            if (strstr($option, trim($lookop))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Raise an error if a method is called in a invalid context
     *
     * @param string  $method       Method to check
     * @param integer $argumentType Is it an input or an output argument
     *
     * @throws \BadMethodCallException
     */
    public function notWith($method, $argumentType)
    {
        switch ($argumentType) {
            case self::ARGUMENT_TYPE_INPUT:
                if ($this->isOptionSet($method, $this->inputOptions)) {
                    $message = "'" . $method . "()' can only be called once as in input argument..";
                    throw new \BadMethodCallException($message);
                }
                break;
            case self::ARGUMENT_TYPE_OUTPUT:
                if ($this->isOptionSet($method, $this->outputOptions)) {
                    $message = "'" . $method . "()' can only be called once as in output argument..";
                    throw new \BadMethodCallException($message);
                }
                break;
        }
    }

    /**
     * Prepare option collection
     *
     * @param array $options
     *            Options
     *
     * @return string
     */
    final public function prepareOptions(array $options)
    {
        foreach ($options as $option) {
            if ($option == '') {
                unset($option);
            }
        }
        $options = implode(' ', $options);
        if (trim($options) == '') {
            return '';
        }

        return trim($options);
    }
}
