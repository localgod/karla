<?php

/**
 * PathValidator Test file
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2024-01-01
 */

use Karla\PathValidator;

/**
 * PathValidator Test class
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class PathValidatorTest extends PHPUnit\Framework\TestCase
{
    /**
     * Path to test files
     *
     * @var string
     */
    private string $testDataPath;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->testDataPath = realpath(__DIR__ . '/../_data/');
    }

    /**
     * Test that a valid file path is accepted and resolved to its real path.
     *
     * @test
     */
    public function validatePathReturnsRealPathForValidFile(): void
    {
        $path = $this->testDataPath . '/demo.jpg';
        $result = PathValidator::validatePath($path);
        $this->assertEquals(realpath($path), $result);
    }

    /**
     * Test that a valid directory path is accepted and resolved.
     *
     * @test
     */
    public function validateDirectoryReturnsRealPathForValidDirectory(): void
    {
        $result = PathValidator::validateDirectory($this->testDataPath);
        $this->assertEquals(realpath($this->testDataPath), $result);
    }

    /**
     * Test that a non-existent path throws InvalidArgumentException.
     *
     * @test
     */
    public function validatePathThrowsForNonExistentPath(): void
    {
        $this->expectException(InvalidArgumentException::class);
        PathValidator::validatePath('/non/existent/path/file.jpg');
    }

    /**
     * Test that a path containing null bytes throws InvalidArgumentException.
     *
     * @test
     */
    public function validatePathThrowsForNullByteInPath(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Path contains null bytes');
        PathValidator::validatePath("/tmp/file\0.jpg");
    }

    /**
     * Test that a path traversal attempt (../../) is resolved or rejected.
     *
     * @test
     */
    public function validatePathResolvesPathTraversal(): void
    {
        // Build a path with traversal that still resolves to the real test data path
        $traversalPath = $this->testDataPath . '/../_data/demo.jpg';
        $result = PathValidator::validatePath($traversalPath);
        // The resolved path should equal the real path (traversal is neutralized)
        $this->assertEquals(realpath($this->testDataPath . '/demo.jpg'), $result);
    }

    /**
     * Test that a relative path traversal to a non-existent location throws.
     *
     * @test
     */
    public function validatePathThrowsForTraversalToNonExistentPath(): void
    {
        $this->expectException(InvalidArgumentException::class);
        PathValidator::validatePath($this->testDataPath . '/../../../../../../../nonexistent_dir_12345/secret.txt');
    }

    /**
     * Test that passing a file path to validateDirectory throws InvalidArgumentException.
     *
     * @test
     */
    public function validateDirectoryThrowsForFilePath(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Path is not a directory');
        PathValidator::validateDirectory($this->testDataPath . '/demo.jpg');
    }

    /**
     * Test that a non-existent directory throws InvalidArgumentException.
     *
     * @test
     */
    public function validateDirectoryThrowsForNonExistentDirectory(): void
    {
        $this->expectException(InvalidArgumentException::class);
        PathValidator::validateDirectory('/non/existent/directory');
    }

    /**
     * Test that validatePath works with symlinks (resolves to real path).
     *
     * @test
     */
    public function validatePathResolvesSymlinks(): void
    {
        $target = $this->testDataPath . '/demo.jpg';
        $link = sys_get_temp_dir() . '/karla-symlink-test-' . getmypid() . '.jpg';

        if (file_exists($link)) {
            unlink($link);
        }

        if (!symlink($target, $link)) {
            $this->markTestSkipped('Unable to create symlinks on this system.');
        }

        try {
            $result = PathValidator::validatePath($link);
            // Symlink should resolve to the real file path
            $this->assertEquals(realpath($target), $result);
        } finally {
            if (file_exists($link)) {
                unlink($link);
            }
        }
    }

    /**
     * Test that a null byte in a directory path throws InvalidArgumentException.
     *
     * @test
     */
    public function validateDirectoryThrowsForNullByteInPath(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Path contains null bytes');
        PathValidator::validateDirectory("/tmp\0/fakedir");
    }
}
