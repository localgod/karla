<?php
/**
 * Convert Test file
 *
 * PHP Version 5.1.2
 *
 * @category Test
 * @package  Karla
 * @author   Johannes Skov Frandsen <localgod@heaven.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/Karla Karla
 * @since    2012-04-05
 */
/**
 * Convert Test class
 *
 * @category   Test
 * @package    Karla
 * @subpackage Karla
 * @author     Johannes Skov Frandsen <localgod@heaven.dk>
 * @license    http://www.opensource.org/licenses/mit-license.php MIT
 * @link       https://github.com/localgod/Karla Karla
 */
class ConvertTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test
     *
     * @test
     * @covers Convert::inputfile
     * @expectedException RuntimeException
     * @return void
     */
    public function inputfileWithoutOutputfile()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::outputfile
     * @expectedException RuntimeException
     * @return void
     */
    public function outputfileWithoutInputfile()
    {
        $actual = Karla::getInstance()->convert()->outputfile('test-1920x1200.png')->getCommand();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::inputfile
     * @covers Convert::outputfile
     * @return void
     */
    public function inputfileAndOutputfile()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->outputfile('test-1920x1200.png')
                ->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::background
     * @return void
     */
    public function background()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->background('red')
                ->outputfile('test-1920x1200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -background "red" "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::borderColor
     * @return void
     */
    public function bordercolorWithColorName()
    {
        //You will not be able to see the border in the resulting image, as this test has no border argument.
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->borderColor('red')
                ->outputfile('test-1920x1200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -bordercolor red "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }
    /**
     * Test
     *
     * @test
     * @covers Convert::borderColor
     * @return void
     */
    public function bordercolorWithHexColor()
    {
        //You will not be able to see the border in the resulting image, as this test has no border argument.
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->borderColor('#666666')
                ->outputfile('test-1920x1200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -bordercolor "#666666" "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }
    /**
     * Test
     *
     * @test
     * @covers Convert::borderColor
     * @return void
     */
    public function bordercolorWithRgbColor()
    {
        //You will not be able to see the border in the resulting image, as this test has no border argument.
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->borderColor('rgb(255,255,255)')
                ->outputfile('test-1920x1200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -bordercolor "rgb(255,255,255)" "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::removeProfile
     * @return void
     */
    public function removeProfile()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->removeProfile('iptc')
                ->outputfile('test-1920x1200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert +profile iptc "tests/_data/demo.jpg" "./test-1920x1200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::resample
     * @return void
     */
    public function resample()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->resample(200, 200, 72, 72)
                ->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -density 72x72  -resample \'200x200\' "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }
    /**
     * Test
     *
     * @test
     * @covers Convert::resample
     * @return void
     */
    public function resampleWithOnlyWidth()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->resample(200)
                ->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -resample \'200\' "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Composite::reset
     * @return void
     */
    public function reset()
    {
        $command = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg');
        $this->assertTrue($command->isDirty());
        $command->reset();
        $this->assertFalse($command->isDirty());
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::size
     * @return void
     */
    public function size()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->size(200, 200)
                ->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -size 200x200 "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::density
     * @return void
     */
    public function density()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->density()
                ->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert "tests/_data/demo.jpg" -density 72x72 "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::flatten
     * @return void
     */
    public function flatten()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->flatten()
                ->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -flatten "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::strip
     * @return void
     */
    public function strip()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->strip()
                ->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -strip "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::profile
     * @return void
     */
    public function profile()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')
                ->profile('tests/_data/sRGB_Color_Space_Profile.icm')->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert "tests/_data/demo.jpg" -profile "tests/_data/sRGB_Color_Space_Profile.icm" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::changeProfile
     * @return void
     */
    public function changeProfile()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')
                ->changeProfile('tests/_data/sRGB_Color_Space_Profile.icm', 'tests/_data/sRGB_Color_Space_Profile.icm')
                ->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert "tests/_data/demo.jpg" -profile "tests/_data/sRGB_Color_Space_Profile.icm"   -profile "tests/_data/sRGB_Color_Space_Profile.icm" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::layers
     * @return void
     */
    public function layers()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->layers('flatten')
                ->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -layers flatten "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::resize
     * @return void
     */
    public function resize()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->resize(100, 100)
                ->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -resize 100x100\> "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::crop
     * @return crop
     */
    public function crop()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->crop(100, 100)
                ->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -crop 100x100+0+0 +repage "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::quality
     * @return void
     */
    public function quality()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->crop(100, 100)
                ->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -crop 100x100+0+0 +repage "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::colorspace
     * @return void
     */
    public function colorspace()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->colorspace('rgb')
                ->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert "tests/_data/demo.jpg" -colorspace rgb "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::gravity
     * @return void
     */
    public function gravity()
    {
        $actual = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->gravity('center')
                ->outputfile('test-200x200.png')->getCommand();
        $expected = 'export PATH=$PATH:/opt/local/bin/;convert -gravity center "tests/_data/demo.jpg" "./test-200x200.png"';
        $this->assertEquals($expected, $actual);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::isDirty
     * @return void
     */
    public function isDirty()
    {
        $this->assertTrue(!Karla::getInstance()->convert()->isDirty());
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::__clone
     * @expectedException BadMethodCallException
     * @return void
     */
    public function __clone()
    {
        $object = clone Karla::getInstance()->convert();
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::getCommand
     * @return void
     */
    public function getCommand()
    {
        $command = Karla::getInstance()->convert()->inputfile('tests/_data/demo.jpg')->outputfile('test-1920x1200.png')
                ->getCommand();
        $this->assertNotNull($command);
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::execute
     * @return void
     */
    public function execute()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::raw
     * @return void
     */
    public function raw()
    {
        $this->assertInstanceOf('Convert', Karla::getInstance()->convert()->raw(''));
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::validProgram
     * @return void
     */
    public function validProgram()
    {
        $this->assertTrue(Karla::getInstance()->convert()->validProgram('convert'));
        $this->assertFalse(Karla::getInstance()->convert()->validProgram('git'));
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::flip
     * @return void
     */
    public function flip()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::rotate
     * @return void
     */
    public function rotate()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::flop
     * @return void
     */
    public function flop()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::type
     * @return void
     */
    public function type()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::sepia
     * @return void
     */
    public function sepia()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    /**
     * Test
     *
     * @test
     * @covers Convert::polaroid
     * @return void
     */
    public function polaroid()
    {
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

}
