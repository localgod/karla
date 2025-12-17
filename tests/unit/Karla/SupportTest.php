<?php
use Karla\Karla;
use Karla\Support;

/**
 * Support Test file
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2025-12-17
 */

/**
 * Support Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class SupportTest extends PHPUnit\Framework\TestCase
{
    /**
     * Karla instance
     *
     * @var Karla
     */
    private $karla;
    
    /**
     * Sets up the fixture
     */
    protected function setUp(): void
    {
        if (! TestHelper::isImageMagickAvailable(PATH_TO_IMAGEMAGICK)) {
            $this->markTestSkipped('The imagemagick executables are not available.');
        }
        
        $this->karla = Karla::perform(PATH_TO_IMAGEMAGICK);
    }
    
    /**
     * Test gravity with valid gravities
     */
    public function testGravityValid(): void
    {
        $convert = $this->karla->convert();
        
        // Common gravities that should be supported
        $this->assertTrue(Support::gravity($convert, 'center'));
        $this->assertTrue(Support::gravity($convert, 'Center'));
        $this->assertTrue(Support::gravity($convert, 'north'));
        $this->assertTrue(Support::gravity($convert, 'south'));
        $this->assertTrue(Support::gravity($convert, 'east'));
        $this->assertTrue(Support::gravity($convert, 'west'));
        $this->assertTrue(Support::gravity($convert, 'northeast'));
        $this->assertTrue(Support::gravity($convert, 'northwest'));
        $this->assertTrue(Support::gravity($convert, 'southeast'));
        $this->assertTrue(Support::gravity($convert, 'southwest'));
    }
    
    /**
     * Test gravity with invalid gravity
     */
    public function testGravityInvalid(): void
    {
        $convert = $this->karla->convert();
        
        $this->assertFalse(Support::gravity($convert, 'invalidgravityxyz'));
        $this->assertFalse(Support::gravity($convert, 'topleft'));
        $this->assertFalse(Support::gravity($convert, 'bottomright'));
        $this->assertFalse(Support::gravity($convert, 'notarealplace'));
    }
    
    /**
     * Test gravity with Composite program
     * 
     * Note: This test is marked incomplete because composite binary in ImageMagick 6
     * doesn't support -list commands, and the workaround of using convert binary
     * doesn't work reliably in all CI environments (particularly Ubuntu).
     * The gravity() method works correctly with Convert programs.
     */
    public function testGravityWithComposite(): void
    {
        $this->markTestIncomplete(
            'Composite -list gravity not supported in IM6. Use Convert for gravity validation.'
        );
        
        $composite = $this->karla->composite();
        
        $this->assertTrue(Support::gravity($composite, 'center'));
        $this->assertTrue(Support::gravity($composite, 'north'));
    }
    
    /**
     * Test gravity throws exception with wrong program type
     */
    public function testGravityThrowsExceptionWithIdentify(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('This method can not be used in this context');
        
        $identify = $this->karla->identify();
        Support::gravity($identify, 'center');
    }
    
    /**
     * Test imageTypes with valid types
     */
    public function testImageTypesValid(): void
    {
        $convert = $this->karla->convert();
        
        // Common image types that should be supported
        $this->assertTrue(Support::imageTypes($convert, 'Grayscale'));
        $this->assertTrue(Support::imageTypes($convert, 'grayscale'));
        $this->assertTrue(Support::imageTypes($convert, 'TrueColor'));
        $this->assertTrue(Support::imageTypes($convert, 'truecolor'));
    }
    
    /**
     * Test imageTypes with invalid type
     */
    public function testImageTypesInvalid(): void
    {
        $convert = $this->karla->convert();
        
        $this->assertFalse(Support::imageTypes($convert, 'InvalidTypeXYZ12345'));
        $this->assertFalse(Support::imageTypes($convert, 'NotARealImageType'));
        $this->assertFalse(Support::imageTypes($convert, 'XxXxInvalidXxXx'));
    }
    
    /**
     * Test imageTypes with Identify program
     */
    public function testImageTypesWithIdentify(): void
    {
        $identify = $this->karla->identify();
        
        $this->assertTrue(Support::imageTypes($identify, 'Grayscale'));
    }
    
    /**
     * Test imageTypes throws exception with wrong program type
     */
    public function testImageTypesThrowsExceptionWithComposite(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('This method can not be used in this context');
        
        $composite = $this->karla->composite();
        Support::imageTypes($composite, 'Grayscale');
    }
    
    /**
     * Test colorSpace with valid colorspaces
     */
    public function testColorSpaceValid(): void
    {
        $convert = $this->karla->convert();
        
        // Common colorspaces that should be supported
        $this->assertTrue(Support::colorSpace($convert, 'sRGB'));
        $this->assertTrue(Support::colorSpace($convert, 'RGB'));
        $this->assertTrue(Support::colorSpace($convert, 'Gray'));
        $this->assertTrue(Support::colorSpace($convert, 'CMYK'));
    }
    
    /**
     * Test colorSpace with case insensitivity
     */
    public function testColorSpaceCaseInsensitive(): void
    {
        $convert = $this->karla->convert();
        
        $this->assertTrue(Support::colorSpace($convert, 'srgb'));
        $this->assertTrue(Support::colorSpace($convert, 'SRGB'));
        $this->assertTrue(Support::colorSpace($convert, 'gray'));
        $this->assertTrue(Support::colorSpace($convert, 'GRAY'));
    }
    
    /**
     * Test colorSpace with invalid colorspace
     */
    public function testColorSpaceInvalid(): void
    {
        $convert = $this->karla->convert();
        
        $this->assertFalse(Support::colorSpace($convert, 'InvalidColorSpaceXYZ'));
        $this->assertFalse(Support::colorSpace($convert, 'NotARealColorSpace123'));
        $this->assertFalse(Support::colorSpace($convert, 'XxXInvalidXxX'));
    }
    
    /**
     * Test colorSpace with Identify program
     */
    public function testColorSpaceWithIdentify(): void
    {
        $identify = $this->karla->identify();
        
        $this->assertTrue(Support::colorSpace($identify, 'sRGB'));
    }
    
    /**
     * Test colorSpace throws exception with wrong program type
     */
    public function testColorSpaceThrowsExceptionWithComposite(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('This method can not be used in this context');
        
        $composite = $this->karla->composite();
        Support::colorSpace($composite, 'sRGB');
    }
    
    /**
     * Test layerMethod with valid methods
     */
    public function testLayerMethodValid(): void
    {
        $convert = $this->karla->convert();
        
        // Common layer methods that should be supported
        $this->assertTrue(Support::layerMethod($convert, 'flatten'));
        $this->assertTrue(Support::layerMethod($convert, 'merge'));
        $this->assertTrue(Support::layerMethod($convert, 'coalesce'));
    }
    
    /**
     * Test layerMethod with case insensitivity
     */
    public function testLayerMethodCaseInsensitive(): void
    {
        $convert = $this->karla->convert();
        
        $this->assertTrue(Support::layerMethod($convert, 'Flatten'));
        $this->assertTrue(Support::layerMethod($convert, 'FLATTEN'));
        $this->assertTrue(Support::layerMethod($convert, 'Merge'));
    }
    
    /**
     * Test layerMethod with invalid method
     */
    public function testLayerMethodInvalid(): void
    {
        $convert = $this->karla->convert();
        
        $this->assertFalse(Support::layerMethod($convert, 'InvalidMethodXYZ123'));
        $this->assertFalse(Support::layerMethod($convert, 'NotARealMethod789'));
        $this->assertFalse(Support::layerMethod($convert, 'XxXInvalidXxX'));
    }
    
    /**
     * Test layerMethod with Identify program
     */
    public function testLayerMethodWithIdentify(): void
    {
        $identify = $this->karla->identify();
        
        $this->assertTrue(Support::layerMethod($identify, 'flatten'));
    }
    
    /**
     * Test layerMethod throws exception with wrong program type
     */
    public function testLayerMethodThrowsExceptionWithComposite(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('This method can not be used in this context');
        
        $composite = $this->karla->composite();
        Support::layerMethod($composite, 'flatten');
    }
    
    /**
     * Test supportedFormat with valid formats
     */
    public function testSupportedFormatValid(): void
    {
        $convert = $this->karla->convert();
        
        // Common formats that should be supported
        $this->assertTrue(Support::supportedFormat($convert, 'JPEG'));
        $this->assertTrue(Support::supportedFormat($convert, 'PNG'));
        $this->assertTrue(Support::supportedFormat($convert, 'GIF'));
        $this->assertTrue(Support::supportedFormat($convert, 'BMP'));
        $this->assertTrue(Support::supportedFormat($convert, 'TIFF'));
    }
    
    /**
     * Test supportedFormat with case insensitivity
     */
    public function testSupportedFormatCaseInsensitive(): void
    {
        $convert = $this->karla->convert();
        
        $this->assertTrue(Support::supportedFormat($convert, 'jpeg'));
        $this->assertTrue(Support::supportedFormat($convert, 'Jpeg'));
        $this->assertTrue(Support::supportedFormat($convert, 'png'));
        $this->assertTrue(Support::supportedFormat($convert, 'PNG'));
    }
    
    /**
     * Test supportedFormat with invalid format
     */
    public function testSupportedFormatInvalid(): void
    {
        $convert = $this->karla->convert();
        
        $this->assertFalse(Support::supportedFormat($convert, 'INVALIDFORMAT999'));
        $this->assertFalse(Support::supportedFormat($convert, 'NOTAREALFORMAT888'));
        $this->assertFalse(Support::supportedFormat($convert, 'XXXINVALIDXXX'));
    }
    
    /**
     * Test supportedFormat with Identify program
     */
    public function testSupportedFormatWithIdentify(): void
    {
        $identify = $this->karla->identify();
        
        $this->assertTrue(Support::supportedFormat($identify, 'JPEG'));
        $this->assertTrue(Support::supportedFormat($identify, 'PNG'));
    }
    
    /**
     * Test supportedFormat throws exception with wrong program type
     */
    public function testSupportedFormatThrowsExceptionWithComposite(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('This method can not be used in this context');
        
        $composite = $this->karla->composite();
        Support::supportedFormat($composite, 'JPEG');
    }
}
