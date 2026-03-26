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
 * Represents the result of an executed ImageMagick command
 *
 * @category Utility
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class CommandResult
{
    /**
     * Create a new CommandResult
     *
     * @param string $output   Standard output from the command
     * @param string $error    Standard error output from the command
     * @param int    $exitCode Process exit code (0 = success)
     */
    public function __construct(
        public readonly string $output,
        public readonly string $error,
        public readonly int $exitCode
    ) {
    }

    /**
     * Check whether the command succeeded
     */
    public function isSuccess(): bool
    {
        return $this->exitCode === 0;
    }

    /**
     * Return the output or throw a RuntimeException on failure
     *
     * @throws \RuntimeException When the command exited with a non-zero code
     */
    public function getOutputOrThrow(): string
    {
        if (!$this->isSuccess()) {
            throw new \RuntimeException(
                "ImageMagick command failed (exit code {$this->exitCode}): {$this->error}"
            );
        }
        return $this->output;
    }
}
