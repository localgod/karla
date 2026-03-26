<?php

/**
 * CommandResult Test file
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2012-04-05
 */

use Karla\CommandResult;

/**
 * CommandResult Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class CommandResultTest extends PHPUnit\Framework\TestCase
{
    /**
     * Test
     *
     * @test
     */
    public function isSuccessReturnsTrueWhenExitCodeIsZero()
    {
        $result = new CommandResult('output', '', 0);
        $this->assertTrue($result->isSuccess());
    }

    /**
     * Test
     *
     * @test
     */
    public function isSuccessReturnsFalseWhenExitCodeIsNonZero()
    {
        $result = new CommandResult('', 'some error', 1);
        $this->assertFalse($result->isSuccess());
    }

    /**
     * Test
     *
     * @test
     */
    public function getOutputOrThrowReturnsOutputOnSuccess()
    {
        $result = new CommandResult('expected output', '', 0);
        $this->assertSame('expected output', $result->getOutputOrThrow());
    }

    /**
     * Test
     *
     * @test
     */
    public function getOutputOrThrowThrowsOnFailure()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('ImageMagick command failed (exit code 1): error message');
        $result = new CommandResult('', 'error message', 1);
        $result->getOutputOrThrow();
    }

    /**
     * Test
     *
     * @test
     */
    public function propertiesAreReadonlyAndAccessible()
    {
        $result = new CommandResult('out', 'err', 42);
        $this->assertSame('out', $result->output);
        $this->assertSame('err', $result->error);
        $this->assertSame(42, $result->exitCode);
    }
}
