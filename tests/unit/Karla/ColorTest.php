<?php
use Karla\Color;

/**
 * Color Test file
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2025-12-17
 */

/**
 * Color Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class ColorTest extends PHPUnit\Framework\TestCase
{
    /**
     * Test valid hex colors with 3 digits
     */
    public function testValidHexColor3Digits(): void
    {
        $this->assertTrue(Color::validHexColor('#fff'));
        $this->assertTrue(Color::validHexColor('#000'));
        $this->assertTrue(Color::validHexColor('#abc'));
        $this->assertTrue(Color::validHexColor('#ABC'));
        $this->assertTrue(Color::validHexColor('#123'));
    }

    /**
     * Test valid hex colors with 6 digits
     */
    public function testValidHexColor6Digits(): void
    {
        $this->assertTrue(Color::validHexColor('#ffffff'));
        $this->assertTrue(Color::validHexColor('#000000'));
        $this->assertTrue(Color::validHexColor('#abcdef'));
        $this->assertTrue(Color::validHexColor('#ABCDEF'));
        $this->assertTrue(Color::validHexColor('#123456'));
        $this->assertTrue(Color::validHexColor('#aB12Cd'));
    }

    /**
     * Test valid hex colors without hash prefix
     */
    public function testValidHexColorWithoutHash(): void
    {
        $this->assertTrue(Color::validHexColor('fff'));
        $this->assertTrue(Color::validHexColor('ffffff'));
        $this->assertTrue(Color::validHexColor('abc123'));
    }

    /**
     * Test invalid hex colors
     */
    public function testInvalidHexColor(): void
    {
        $this->assertFalse(Color::validHexColor('#gggggg'));
        $this->assertFalse(Color::validHexColor('#12345'));
        $this->assertFalse(Color::validHexColor('#1234567'));
        $this->assertFalse(Color::validHexColor('purple'));
        $this->assertFalse(Color::validHexColor('rgb(255,0,0)'));
        $this->assertFalse(Color::validHexColor(''));
        $this->assertFalse(Color::validHexColor('#'));
        $this->assertFalse(Color::validHexColor('##fff'));
    }

    /**
     * Test valid color names
     */
    public function testValidColorName(): void
    {
        $this->assertTrue(Color::validColorName('aqua'));
        $this->assertTrue(Color::validColorName('black'));
        $this->assertTrue(Color::validColorName('blue'));
        $this->assertTrue(Color::validColorName('fuchsia'));
        $this->assertTrue(Color::validColorName('gray'));
        $this->assertTrue(Color::validColorName('green'));
        $this->assertTrue(Color::validColorName('lime'));
        $this->assertTrue(Color::validColorName('maroon'));
        $this->assertTrue(Color::validColorName('navy'));
        $this->assertTrue(Color::validColorName('olive'));
        $this->assertTrue(Color::validColorName('orange'));
        $this->assertTrue(Color::validColorName('purple'));
        $this->assertTrue(Color::validColorName('red'));
        $this->assertTrue(Color::validColorName('silver'));
        $this->assertTrue(Color::validColorName('teal'));
        $this->assertTrue(Color::validColorName('white'));
        $this->assertTrue(Color::validColorName('yellow'));
    }

    /**
     * Test invalid color names
     */
    public function testInvalidColorName(): void
    {
        $this->assertFalse(Color::validColorName('redd'));
        $this->assertFalse(Color::validColorName('blu'));
        $this->assertFalse(Color::validColorName('pink'));
        $this->assertFalse(Color::validColorName('brown'));
        $this->assertFalse(Color::validColorName('#fff'));
        $this->assertFalse(Color::validColorName('rgb(255,0,0)'));
        $this->assertFalse(Color::validColorName(''));
        $this->assertFalse(Color::validColorName('123'));
        $this->assertFalse(Color::validColorName('notacolor'));
        $this->assertFalse(Color::validColorName('xyz'));
    }

    /**
     * Test valid RGB colors with integers
     */
    public function testValidRgbColorIntegers(): void
    {
        $this->assertTrue(Color::validRgbColor('rgb(255,0,0)'));
        $this->assertTrue(Color::validRgbColor('rgb(0,255,0)'));
        $this->assertTrue(Color::validRgbColor('rgb(0,0,255)'));
        $this->assertTrue(Color::validRgbColor('rgb(128,128,128)'));
        $this->assertTrue(Color::validRgbColor('rgb(0,0,0)'));
        $this->assertTrue(Color::validRgbColor('rgb(255,255,255)'));
    }

    /**
     * Test valid RGB colors with spacing variations
     */
    public function testValidRgbColorSpacing(): void
    {
        $this->assertTrue(Color::validRgbColor('rgb(255, 0, 0)'));
        $this->assertTrue(Color::validRgbColor('rgb( 255, 0, 0 )'));
        $this->assertTrue(Color::validRgbColor('rgb(  255  ,  0  ,  0  )'));
        $this->assertTrue(Color::validRgbColor('rgb(255,0,0)'));
    }

    /**
     * Test valid RGB colors with percentages
     */
    public function testValidRgbColorPercentages(): void
    {
        $this->assertTrue(Color::validRgbColor('rgb(100%,0%,0%)'));
        $this->assertTrue(Color::validRgbColor('rgb(50%,50%,50%)'));
        $this->assertTrue(Color::validRgbColor('rgb(0%,100%,0%)'));
        $this->assertTrue(Color::validRgbColor('rgb(25%, 75%, 100%)'));
    }

    /**
     * Test invalid RGB colors
     */
    public function testInvalidRgbColor(): void
    {
        $this->assertFalse(Color::validRgbColor('rgb(256,0,0)'));
        $this->assertFalse(Color::validRgbColor('rgb(255,256,0)'));
        $this->assertFalse(Color::validRgbColor('rgb(255,0,256)'));
        $this->assertFalse(Color::validRgbColor('rgb(-1,0,0)'));
        $this->assertFalse(Color::validRgbColor('rgb(255,0)'));
        $this->assertFalse(Color::validRgbColor('rgb(255,0,0,0)'));
        $this->assertFalse(Color::validRgbColor('rgb(101%,0%,0%)'));
        $this->assertFalse(Color::validRgbColor('rgb(255)'));
        $this->assertFalse(Color::validRgbColor('255,0,0'));
        $this->assertFalse(Color::validRgbColor('#fff'));
        $this->assertFalse(Color::validRgbColor('red'));
        $this->assertFalse(Color::validRgbColor(''));
    }
}
