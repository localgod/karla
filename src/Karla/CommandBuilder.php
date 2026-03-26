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
 * @since    2026-03-26
 */

declare(strict_types=1);

namespace Karla;

/**
 * Centralises ImageMagick command construction.
 *
 * Each Program subclass (Convert, Identify, …) delegates to this class from
 * its getCommand() method, keeping quoting/escaping logic and the IM6-vs-IM7
 * binary-selection logic in a single, easily testable place.
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class CommandBuilder
{
    /**
     * Escaped input file path
     *
     * @var string
     */
    private string $inputFile = '';

    /**
     * Escaped output file path
     *
     * @var string
     */
    private string $outputFile = '';

    /**
     * @param Query       $query     The current query (holds accumulated options)
     * @param string      $binPath   Path prefix for binaries (may include PATH export)
     * @param string      $binary    Platform-appropriate binary name (e.g. "convert")
     * @param int|null    $imVersion Detected ImageMagick major version (6 or 7)
     */
    public function __construct(
        private Query $query,
        private string $binPath,
        private string $binary,
        private ?int $imVersion
    ) {
    }

    /**
     * Set the (already-escaped) input file path.
     *
     * The caller is responsible for escaping the path with escapeshellarg()
     * before passing it here; this method stores the value as-is so that
     * escaping is never applied twice.
     *
     * @param string $escapedFilePath Shell-safe file path
     */
    public function setInput(string $escapedFilePath): self
    {
        $this->inputFile = $escapedFilePath;
        return $this;
    }

    /**
     * Set the (already-escaped) output file path.
     *
     * @param string $escapedFilePath Shell-safe file path
     */
    public function setOutput(string $escapedFilePath): self
    {
        $this->outputFile = $escapedFilePath;
        return $this;
    }

    /**
     * Assemble and return the complete command string.
     *
     * Parts are joined with a single space; empty optional parts (options or
     * files that were not set) are simply omitted, so no extra whitespace is
     * introduced.
     */
    public function build(): string
    {
        $parts = [$this->getBaseCommand()];

        $inOptions = $this->query->prepareOptions($this->query->getInputOptions());
        if ($inOptions !== '') {
            $parts[] = $inOptions;
        }

        if ($this->inputFile !== '') {
            $parts[] = $this->inputFile;
        }

        $outOptions = $this->query->prepareOptions($this->query->getOutputOptions());
        if ($outOptions !== '') {
            $parts[] = $outOptions;
        }

        if ($this->outputFile !== '') {
            $parts[] = $this->outputFile;
        }

        return implode(' ', $parts);
    }

    /**
     * Return the base binary invocation, handling ImageMagick 7 vs 6.
     *
     * ImageMagick 7 consolidates all tools under the unified `magick` command:
     * - `convert` becomes `magick`
     * - `identify` / `composite` become `magick identify` / `magick composite`
     *
     * ImageMagick 6 keeps the individual tool binaries as-is.
     */
    private function getBaseCommand(): string
    {
        if ($this->imVersion !== null && $this->imVersion >= 7) {
            // Strip the .exe suffix (if any) before comparing the command name
            $command = str_replace('.exe', '', $this->binary);
            $magickBin = Platform::getBinary('magick');

            if ($command === 'convert') {
                return $this->binPath . $magickBin;
            }

            if (in_array($command, ['identify', 'composite'])) {
                return $this->binPath . $magickBin . ' ' . $command;
            }
        }

        return $this->binPath . $this->binary;
    }
}
