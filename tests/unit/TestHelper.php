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
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $magickBin = $isWindows ? 'magick.exe' : 'magick';
        $convertBin = $isWindows ? 'convert.exe' : 'convert';
        
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
     * @return bool
     */
    public static function isWindows(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }
    
    /**
     * Build expected command string based on platform and version
     *
     * @param string $path ImageMagick path
     * @param string $command Command name (convert, identify, composite)
     * @param string $arguments Command arguments
     * @return string Expected command
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
                    return $binPath . 'magick.exe ' . $arguments;
                } else {
                    return $binPath . 'magick.exe ' . $command . ' ' . $arguments;
                }
            } else {
                // ImageMagick 6: use legacy commands
                return $binPath . $command . '.exe ' . $arguments;
            }
        } else {
            // Unix: export PATH
            $binPath = 'export PATH=$PATH:' . $path . ';';
            
            if ($version >= 7) {
                // ImageMagick 7: use magick or magick <subcommand>
                if ($command === 'convert') {
                    return $binPath . 'magick ' . $arguments;
                } else {
                    return $binPath . 'magick ' . $command . ' ' . $arguments;
                }
            } else {
                // ImageMagick 6: use legacy commands
                return $binPath . $command . ' ' . $arguments;
            }
        }
    }
    
    /**
     * Check if ImageMagick executables are available
     *
     * @param string $path Path to ImageMagick binaries
     * @return bool
     */
    public static function isImageMagickAvailable(string $path): bool
    {
        $isWindows = self::isWindows();
        
        // Check for both ImageMagick 6 and 7
        $binaries = $isWindows 
            ? ['magick.exe', 'convert.exe']
            : ['magick', 'convert'];
        
        foreach ($binaries as $binary) {
            if (file_exists($path . $binary)) {
                return true;
            }
        }
        
        return false;
    }
}
