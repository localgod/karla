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

namespace Karla\Program;

use Karla\CommandBuilder;
use Karla\PathValidator;

/**
 * Class for wrapping ImageMagicks identify tool
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class Identify extends ImageMagick
{
    /**
     * Input file
     *
     * @var string
     */
    protected string $inputFile;

    /**
     * Add input argument
     *
     * @param string $filePath Input file path
     *
     * @throws \InvalidArgumentException
     */
    public function in(string $filePath): self
    {
        if (str_contains($filePath, "\0")) {
            throw new \InvalidArgumentException('Path contains null bytes');
        }
        if (! file_exists($filePath)) {
            $message = 'The input file path (' . $filePath . ') is invalid or the file could not be located.';
            throw new \InvalidArgumentException($message);
        }
        $filePath = PathValidator::validatePath($filePath);
        $file = new \SplFileObject($filePath);
        if ($file->isReadable()) {
            $this->inputFile = escapeshellarg($file->getPathname());
        }

        return $this;
    }

    /**
     * Execute the command
     *
     * @param bool $reset Reset the query
     * @param bool $raw Get the raw output
     *
     * @see Imagemagick#execute()
     */
    public function execute(bool $reset = true, bool $raw = true): string|object
    {
        $result = parent::execute(false);
        // Ensure result is a string
        $resultStr = is_string($result) ? $result : '';

        if (! $raw) {
            if ($this->getQuery()->isOptionSet('verbose', $this->getQuery()->getInputOptions())) {
                $reset ? $this->getQuery()->reset() : null;
                return new \Karla\MetaData($resultStr, true);
            }
            $reset ? $this->getQuery()->reset() : null;
            return new \Karla\MetaData($resultStr);
        }

        $reset ? $this->getQuery()->reset() : null;
        return trim($resultStr);
    }

    /**
     * Add verbose argument
     */
    public function verbose(): self
    {
        $this->getQuery()->notWith('verbose', \Karla\Query::ARGUMENT_TYPE_INPUT);
        $this->getQuery()->setInputOption("-verbose ");

        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Imagemagick#getCommand()
     */
    public function getCommand(): string
    {
        return (new CommandBuilder($this->getQuery(), $this->binPath, $this->bin, $this->version))
            ->setInput($this->inputFile)
            ->build();
    }

    /**
     * Raw arguments directly to ImageMagick
     *
     * @param string $arguments Arguments
     * @param bool $input Defaults to an input option, use false to use it as an output option
     *
     * @see ImageMagick::raw()
     */
    public function raw(string $arguments, bool $input = true): self
    {
        parent::raw($arguments, $input);

        return $this;
    }
}
