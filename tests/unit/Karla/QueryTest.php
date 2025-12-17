<?php
use Karla\Query;

/**
 * Query Test file
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2025-12-17
 */

/**
 * Query Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class QueryTest extends PHPUnit\Framework\TestCase
{
    /**
     * Test set and get input options
     */
    public function testSetInputOption(): void
    {
        $query = new Query();
        $query->setInputOption('-resize 100x100');
        
        $options = $query->getInputOptions();
        $this->assertCount(1, $options);
        $this->assertContains('-resize 100x100', $options);
    }

    /**
     * Test set multiple input options
     */
    public function testSetMultipleInputOptions(): void
    {
        $query = new Query();
        $query->setInputOption('-resize 100x100');
        $query->setInputOption('-quality 90');
        $query->setInputOption('-crop 50x50');
        
        $options = $query->getInputOptions();
        $this->assertCount(3, $options);
        $this->assertContains('-resize 100x100', $options);
        $this->assertContains('-quality 90', $options);
        $this->assertContains('-crop 50x50', $options);
    }

    /**
     * Test set empty input option is ignored
     */
    public function testSetEmptyInputOption(): void
    {
        $query = new Query();
        $query->setInputOption('');
        
        $options = $query->getInputOptions();
        $this->assertCount(0, $options);
    }

    /**
     * Test set and get output options
     */
    public function testSetOutputOption(): void
    {
        $query = new Query();
        $query->setOutputOption('-resize 100x100');
        
        $options = $query->getOutputOptions();
        $this->assertCount(1, $options);
        $this->assertContains('-resize 100x100', $options);
    }

    /**
     * Test set multiple output options
     */
    public function testSetMultipleOutputOptions(): void
    {
        $query = new Query();
        $query->setOutputOption('-resize 100x100');
        $query->setOutputOption('-quality 90');
        $query->setOutputOption('-crop 50x50');
        
        $options = $query->getOutputOptions();
        $this->assertCount(3, $options);
        $this->assertContains('-resize 100x100', $options);
        $this->assertContains('-quality 90', $options);
        $this->assertContains('-crop 50x50', $options);
    }

    /**
     * Test set empty output option is ignored
     */
    public function testSetEmptyOutputOption(): void
    {
        $query = new Query();
        $query->setOutputOption('');
        
        $options = $query->getOutputOptions();
        $this->assertCount(0, $options);
    }

    /**
     * Test reset clears all options
     */
    public function testReset(): void
    {
        $query = new Query();
        $query->setInputOption('-resize 100x100');
        $query->setInputOption('-quality 90');
        $query->setOutputOption('-crop 50x50');
        $query->setOutputOption('-flip');
        
        $query->reset();
        
        $this->assertCount(0, $query->getInputOptions());
        $this->assertCount(0, $query->getOutputOptions());
    }

    /**
     * Test isOptionSet finds existing option
     */
    public function testIsOptionSetFindsOption(): void
    {
        $query = new Query();
        $query->setInputOption('-resize 100x100');
        $query->setInputOption('-quality 90');
        
        $this->assertTrue($query->isOptionSet('-resize', $query->getInputOptions()));
        $this->assertTrue($query->isOptionSet('-quality', $query->getInputOptions()));
    }

    /**
     * Test isOptionSet with partial match
     */
    public function testIsOptionSetPartialMatch(): void
    {
        $query = new Query();
        $query->setInputOption('-resize 100x100');
        
        $this->assertTrue($query->isOptionSet('resize', $query->getInputOptions()));
        $this->assertTrue($query->isOptionSet('-resize', $query->getInputOptions()));
        $this->assertTrue($query->isOptionSet('100x100', $query->getInputOptions()));
    }

    /**
     * Test isOptionSet returns false for missing option
     */
    public function testIsOptionSetNotFound(): void
    {
        $query = new Query();
        $query->setInputOption('-resize 100x100');
        
        $this->assertFalse($query->isOptionSet('-crop', $query->getInputOptions()));
        $this->assertFalse($query->isOptionSet('-quality', $query->getInputOptions()));
    }

    /**
     * Test isOptionSet on empty list
     */
    public function testIsOptionSetEmptyList(): void
    {
        $query = new Query();
        
        $this->assertFalse($query->isOptionSet('-resize', $query->getInputOptions()));
    }

    /**
     * Test notWith throws exception for duplicate input option
     */
    public function testNotWithInputThrowsException(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage("'resize()' can only be called once as in input argument");
        
        $query = new Query();
        $query->setInputOption('-resize 100x100');
        $query->notWith('resize', Query::ARGUMENT_TYPE_INPUT);
    }

    /**
     * Test notWith throws exception for duplicate output option
     */
    public function testNotWithOutputThrowsException(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage("'resize()' can only be called once as in output argument");
        
        $query = new Query();
        $query->setOutputOption('-resize 100x100');
        $query->notWith('resize', Query::ARGUMENT_TYPE_OUTPUT);
    }

    /**
     * Test notWith does not throw when option not set
     */
    public function testNotWithNoException(): void
    {
        $query = new Query();
        $query->setInputOption('-resize 100x100');
        
        // Should not throw
        $query->notWith('crop', Query::ARGUMENT_TYPE_INPUT);
        $query->notWith('resize', Query::ARGUMENT_TYPE_OUTPUT);
        
        $this->assertTrue(true); // Assert we got here
    }

    /**
     * Test prepareOptions joins array
     */
    public function testPrepareOptions(): void
    {
        $query = new Query();
        $options = ['-resize 100x100', '-quality 90', '-crop 50x50'];
        
        $result = $query->prepareOptions($options);
        
        $this->assertEquals('-resize 100x100 -quality 90 -crop 50x50', $result);
    }

    /**
     * Test prepareOptions removes empty strings
     */
    public function testPrepareOptionsRemovesEmpty(): void
    {
        $query = new Query();
        $options = ['-resize 100x100', '', '-quality 90', '', '-crop 50x50'];
        
        $result = $query->prepareOptions($options);
        
        // Empty strings should be filtered out completely
        $this->assertEquals('-resize 100x100 -quality 90 -crop 50x50', $result);
        $this->assertStringNotContainsString('  ', $result); // No double spaces
    }

    /**
     * Test prepareOptions with all empty returns empty string
     */
    public function testPrepareOptionsAllEmpty(): void
    {
        $query = new Query();
        $options = ['', '', ''];
        
        $result = $query->prepareOptions($options);
        
        $this->assertEquals('', $result);
    }

    /**
     * Test prepareOptions with empty array
     */
    public function testPrepareOptionsEmptyArray(): void
    {
        $query = new Query();
        $result = $query->prepareOptions([]);
        
        $this->assertEquals('', $result);
    }

    /**
     * Test prepareOptions trims result
     */
    public function testPrepareOptionsTrimmed(): void
    {
        $query = new Query();
        $options = ['-resize 100x100'];
        
        $result = $query->prepareOptions($options);
        
        $this->assertEquals('-resize 100x100', $result);
        $this->assertStringStartsNotWith(' ', $result);
        $this->assertStringEndsNotWith(' ', $result);
    }

    /**
     * Test input and output options are separate
     */
    public function testInputAndOutputSeparate(): void
    {
        $query = new Query();
        $query->setInputOption('-density 300');
        $query->setOutputOption('-quality 90');
        
        $inputOptions = $query->getInputOptions();
        $outputOptions = $query->getOutputOptions();
        
        $this->assertCount(1, $inputOptions);
        $this->assertCount(1, $outputOptions);
        $this->assertContains('-density 300', $inputOptions);
        $this->assertContains('-quality 90', $outputOptions);
        $this->assertNotContains('-quality 90', $inputOptions);
        $this->assertNotContains('-density 300', $outputOptions);
    }
}
