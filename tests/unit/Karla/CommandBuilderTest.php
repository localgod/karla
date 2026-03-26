<?php

/**
 * CommandBuilder Test file
 *
 * PHP Version 8.0<
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 * @since    2026-03-26
 */

use Karla\CommandBuilder;
use Karla\Platform;
use Karla\Query;

/**
 * CommandBuilder Test class
 *
 * These tests exercise CommandBuilder in isolation — no ImageMagick installation
 * is required.
 *
 * @author   Johannes Skov Frandsen <jsf@greenoak.dk>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/localgod/karla Karla
 */
class CommandBuilderTest extends PHPUnit\Framework\TestCase
{
    /**
     * Shared bin path used in every test (mirrors what Karla sets on Unix)
     *
     * @var string
     */
    private string $binPath = 'export PATH=$PATH:/usr/bin/;';

    /**
     * Helper: create a fresh Query with optional input/output options.
     *
     * @param array<string> $inputOptions
     * @param array<string> $outputOptions
     */
    private function makeQuery(array $inputOptions = [], array $outputOptions = []): Query
    {
        $query = new Query();
        foreach ($inputOptions as $opt) {
            $query->setInputOption($opt);
        }
        foreach ($outputOptions as $opt) {
            $query->setOutputOption($opt);
        }
        return $query;
    }

    /**
     * Test
     *
     * @test
     */
    public function buildConvertIM6NoOptions(): void
    {
        $builder = new CommandBuilder($this->makeQuery(), $this->binPath, 'convert', 6);
        $inputFile  = escapeshellarg('/tmp/input.jpg');
        $outputFile = escapeshellarg('/tmp/output.png');

        $command = $builder->setInput($inputFile)->setOutput($outputFile)->build();

        $this->assertEquals(
            $this->binPath . 'convert ' . $inputFile . ' ' . $outputFile,
            $command
        );
    }

    /**
     * Test
     *
     * @test
     */
    public function buildConvertIM6WithInputOptions(): void
    {
        $query = $this->makeQuery(['-density 72x72']);
        $builder = new CommandBuilder($query, $this->binPath, 'convert', 6);
        $inputFile  = escapeshellarg('/tmp/input.jpg');
        $outputFile = escapeshellarg('/tmp/output.png');

        $command = $builder->setInput($inputFile)->setOutput($outputFile)->build();

        $this->assertEquals(
            $this->binPath . 'convert -density 72x72 ' . $inputFile . ' ' . $outputFile,
            $command
        );
    }

    /**
     * Test
     *
     * @test
     */
    public function buildConvertIM6WithOutputOptions(): void
    {
        $query = $this->makeQuery([], ['-quality 85']);
        $builder = new CommandBuilder($query, $this->binPath, 'convert', 6);
        $inputFile  = escapeshellarg('/tmp/input.jpg');
        $outputFile = escapeshellarg('/tmp/output.png');

        $command = $builder->setInput($inputFile)->setOutput($outputFile)->build();

        $this->assertEquals(
            $this->binPath . 'convert ' . $inputFile . ' -quality 85 ' . $outputFile,
            $command
        );
    }

    /**
     * Test
     *
     * @test
     */
    public function buildConvertIM6WithBothOptions(): void
    {
        $query = $this->makeQuery(['-density 72x72'], ['-quality 85']);
        $builder = new CommandBuilder($query, $this->binPath, 'convert', 6);
        $inputFile  = escapeshellarg('/tmp/input.jpg');
        $outputFile = escapeshellarg('/tmp/output.png');

        $command = $builder->setInput($inputFile)->setOutput($outputFile)->build();

        $this->assertEquals(
            $this->binPath . 'convert -density 72x72 ' . $inputFile . ' -quality 85 ' . $outputFile,
            $command
        );
    }

    /**
     * Test — ImageMagick 7 uses the unified "magick" binary for convert.
     *
     * @test
     */
    public function buildConvertIM7NoOptions(): void
    {
        $builder = new CommandBuilder($this->makeQuery(), $this->binPath, 'convert', 7);
        $inputFile  = escapeshellarg('/tmp/input.jpg');
        $outputFile = escapeshellarg('/tmp/output.png');

        $command = $builder->setInput($inputFile)->setOutput($outputFile)->build();

        $magickBin = Platform::getBinary('magick');
        $this->assertEquals(
            $this->binPath . $magickBin . ' ' . $inputFile . ' ' . $outputFile,
            $command
        );
    }

    /**
     * Test — IM7 identify uses "magick identify".
     *
     * @test
     */
    public function buildIdentifyIM7NoOptions(): void
    {
        $builder = new CommandBuilder($this->makeQuery(), $this->binPath, 'identify', 7);
        $inputFile = escapeshellarg('/tmp/input.jpg');

        $command = $builder->setInput($inputFile)->build();

        $magickBin = Platform::getBinary('magick');
        $this->assertEquals(
            $this->binPath . $magickBin . ' identify ' . $inputFile,
            $command
        );
    }

    /**
     * Test — IM6 identify.
     *
     * @test
     */
    public function buildIdentifyIM6NoOptions(): void
    {
        $builder = new CommandBuilder($this->makeQuery(), $this->binPath, 'identify', 6);
        $inputFile = escapeshellarg('/tmp/input.jpg');

        $command = $builder->setInput($inputFile)->build();

        $this->assertEquals(
            $this->binPath . 'identify ' . $inputFile,
            $command
        );
    }

    /**
     * Test — IM6 identify with input option.
     *
     * @test
     */
    public function buildIdentifyIM6WithInputOption(): void
    {
        $query = $this->makeQuery(['-verbose']);
        $builder = new CommandBuilder($query, $this->binPath, 'identify', 6);
        $inputFile = escapeshellarg('/tmp/input.jpg');

        $command = $builder->setInput($inputFile)->build();

        $this->assertEquals(
            $this->binPath . 'identify -verbose ' . $inputFile,
            $command
        );
    }

    /**
     * Test — null version falls back to the legacy binary.
     *
     * @test
     */
    public function buildWithNullVersionUsesLegacyBinary(): void
    {
        $builder = new CommandBuilder($this->makeQuery(), $this->binPath, 'convert', null);
        $inputFile  = escapeshellarg('/tmp/input.jpg');
        $outputFile = escapeshellarg('/tmp/output.png');

        $command = $builder->setInput($inputFile)->setOutput($outputFile)->build();

        $this->assertEquals(
            $this->binPath . 'convert ' . $inputFile . ' ' . $outputFile,
            $command
        );
    }

    /**
     * Test — build() without setting input or output still returns a valid string.
     *
     * @test
     */
    public function buildWithNoFilesReturnsBaseCommand(): void
    {
        $builder = new CommandBuilder($this->makeQuery(), $this->binPath, 'convert', 6);

        $command = $builder->build();

        $this->assertEquals($this->binPath . 'convert', $command);
    }

    /**
     * Test — setInput() and setOutput() return the builder for fluent chaining.
     *
     * @test
     */
    public function setInputAndSetOutputReturnSelf(): void
    {
        $builder = new CommandBuilder($this->makeQuery(), $this->binPath, 'convert', 6);

        $this->assertSame($builder, $builder->setInput('foo'));
        $this->assertSame($builder, $builder->setOutput('bar'));
    }

    /**
     * Test — IM7 composite uses "magick composite".
     *
     * @test
     */
    public function buildCompositeIM7(): void
    {
        $builder = new CommandBuilder($this->makeQuery(), $this->binPath, 'composite', 7);

        $command = $builder->build();

        $magickBin = Platform::getBinary('magick');
        $this->assertEquals(
            $this->binPath . $magickBin . ' composite',
            $command
        );
    }
}
