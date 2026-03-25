<?php

use Karla\Platform;

/**
 * Platform Test file
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2026-03-25
 */

/**
 * Platform Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class PlatformTest extends PHPUnit\Framework\TestCase
{
    /**
     * Test that isWindows returns a boolean
     */
    public function testIsWindowsReturnsBool(): void
    {
        $this->assertIsBool(Platform::isWindows());
    }

    /**
     * Test that isWindows matches PHP_OS_FAMILY
     */
    public function testIsWindowsMatchesPhpOsFamily(): void
    {
        $this->assertSame(PHP_OS_FAMILY === 'Windows', Platform::isWindows());
    }

    /**
     * Test that getBinary returns binary with .exe on Windows and unchanged on other platforms
     */
    public function testGetBinaryWithConvert(): void
    {
        $binary = 'convert';
        $result = Platform::getBinary($binary);

        if (Platform::isWindows()) {
            $this->assertSame('convert.exe', $result);
        } else {
            $this->assertSame('convert', $result);
        }
    }

    /**
     * Test getBinary with magick binary
     */
    public function testGetBinaryWithMagick(): void
    {
        $result = Platform::getBinary('magick');

        if (Platform::isWindows()) {
            $this->assertSame('magick.exe', $result);
        } else {
            $this->assertSame('magick', $result);
        }
    }

    /**
     * Test getBinary with an empty string
     */
    public function testGetBinaryWithEmptyString(): void
    {
        $result = Platform::getBinary('');

        if (Platform::isWindows()) {
            $this->assertSame('.exe', $result);
        } else {
            $this->assertSame('', $result);
        }
    }
}
