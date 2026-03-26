<?php

/**
 * Test helper for handling platform and ImageMagick version differences
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class TestHelper
{
    /**
     * Detect ImageMagick version
     *
     * @param string $path Path to ImageMagick binaries
     * @return int Major version number (6 or 7)
     */
    public static function getImageMagickVersion(string $path): int
    {
        $magickBin = \Karla\Platform::getBinary('magick');
        $convertBin = \Karla\Platform::getBinary('convert');
        
        // Try ImageMagick 7 first
        if (file_exists($path . $magickBin)) {
            $output = shell_exec($path . $magickBin . ' -version');
            if ($output && preg_match('/ImageMagick (\d+)/', $output, $matches)) {
                return (int)$matches[1];
            }
        }
        
        // Try ImageMagick 6
        if (file_exists($path . $convertBin)) {
            $output = shell_exec($path . $convertBin . ' -version');
            if ($output && preg_match('/ImageMagick (\d+)/', $output, $matches)) {
                return (int)$matches[1];
            }
            return 6; // Assume v6 if version not found
        }
        
        return 6; // Default to 6
    }
    
    /**
     * Check if running on Windows
     *
     * 
     */
    public static function isWindows(): bool
    {
        return \Karla\Platform::isWindows();
    }
    
    /**
     * Build expected command string based on platform and version
     *
     * @param string $path ImageMagick path
     * @param string $command Command name (convert, identify, composite)
     * @param string $arguments Command arguments
     * 
     */
    public static function buildExpectedCommand(string $path, string $command, string $arguments): string
    {
        $isWindows = self::isWindows();
        $version = self::getImageMagickVersion($path);
        
        if ($isWindows) {
            // Windows: direct path
            $binPath = rtrim($path, '/\\') . '/';
            
            if ($version >= 7) {
                // ImageMagick 7: use magick or magick <subcommand>
                if ($command === 'convert') {
                    return $binPath . \Karla\Platform::getBinary('magick') . ' ' . $arguments;
                } else {
                    return $binPath . \Karla\Platform::getBinary('magick') . ' ' . $command . ' ' . $arguments;
                }
            } else {
                // ImageMagick 6: use legacy commands
                return $binPath . \Karla\Platform::getBinary($command) . ' ' . $arguments;
            }
        } else {
            // Unix: export PATH
            $binPath = 'export PATH=$PATH:' . $path . ';';
            
            if ($version >= 7) {
                // ImageMagick 7: use magick or magick <subcommand>
                if ($command === 'convert') {
                    return $binPath . \Karla\Platform::getBinary('magick') . ' ' . $arguments;
                } else {
                    return $binPath . \Karla\Platform::getBinary('magick') . ' ' . $command . ' ' . $arguments;
                }
            } else {
                // ImageMagick 6: use legacy commands
                return $binPath . \Karla\Platform::getBinary($command) . ' ' . $arguments;
            }
        }
    }
    
    /**
     * Check if ImageMagick executables are available
     *
     * @param string $path Path to ImageMagick binaries
     * 
     */
    public static function isImageMagickAvailable(string $path): bool
    {
        // Check for both ImageMagick 6 and 7
        $binaries = [
            \Karla\Platform::getBinary('magick'),
            \Karla\Platform::getBinary('convert'),
        ];
        
        foreach ($binaries as $binary) {
            if (file_exists($path . $binary)) {
                return true;
            }
        }
        
        return false;
    }
}
