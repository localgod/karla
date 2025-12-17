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
 * @since    2013-05-26
 */

declare(strict_types=1);

namespace Karla;

/**
 * Class for maintaining query info
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Query
{
    /**
     * This argument is to be considered for the input image
     *
     * @var int
     */
    public const ARGUMENT_TYPE_INPUT = 0;

    /**
     * This argument is to be considered for the output image
     *
     * @var int
     */
    public const ARGUMENT_TYPE_OUTPUT = 1;

    /**
     * Is the object dirty (has any arguments been set)
     *
     * @var bool
     */
    private bool $dirty;

    /**
     * Input option
     *
     * @var array<string>
     */
    protected array $inputOptions = [];

    /**
     * Output option
     *
     * @var array<string>
     */
    protected array $outputOptions = [];

    /**
     * Set input option
     *
     * @param string $option Option to set
     */
    public function setInputOption(string $option): void
    {
        if ($option != "") {
            $this->inputOptions[] = $option;
            $this->dirty();
        }
    }

    /**
     * Get input option
     *
     * @return array<string>
     */
    public function getInputOptions(): array
    {
        return $this->inputOptions;
    }

    /**
     * Set output option
     *
     * @param string $option Option to set
     */
    public function setOutputOption(string $option): void
    {
        if ($option != "") {
            $this->outputOptions[] = $option;
            $this->dirty();
        }
    }

    /**
     * Get output options
     *
     * @return array<string>
     */
    public function getOutputOptions(): array
    {
        return $this->outputOptions;
    }

    /**
     * Set the object as being dirty
     *
     * (Arguments have been set)
     */
    public function dirty(): void
    {
        $this->dirty = true;
    }

    /**
     * Reset the command
     */
    public function reset(): void
    {
        $this->inputOptions = array();
        $this->outputOptions = array();
        $this->dirty = false;
    }

    /**
     * Check if an option is already set
     *
     * @param string $lookop Option to look up
     * @param array<string> $optionList Optionlist to look in
     */
    final public function isOptionSet(string $lookop, array $optionList): bool
    {
        foreach ($optionList as $option) {
            if (strstr($option, trim($lookop))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Raise an error if a method is called in an invalid context
     *
     * @param string $method Method to check
     * @param int $argumentType Is it an input or an output argument
     *
     * @throws \BadMethodCallException
     */
    public function notWith(string $method, int $argumentType): void
    {
        if ($argumentType == Query::ARGUMENT_TYPE_INPUT) {
            if ($this->isOptionSet($method, $this->inputOptions)) {
                $message = "'" . $method . "()' can only be called once as in input argument..";
                throw new \BadMethodCallException($message);
            }
        } elseif ($argumentType == Query::ARGUMENT_TYPE_OUTPUT) {
            if ($this->isOptionSet($method, $this->outputOptions)) {
                $message = "'" . $method . "()' can only be called once as in output argument..";
                throw new \BadMethodCallException($message);
            }
        }
    }

    /**
     * Prepare option collection
     *
     * @param array<string> $options Options
     */
    final public function prepareOptions(array $options): string
    {
        // Filter out empty strings
        $options = array_filter($options, function($option) {
            return $option !== '';
        });
        
        $options = implode(' ', $options);
        if (trim($options) == '') {
            return '';
        }

        return trim($options);
    }
}
